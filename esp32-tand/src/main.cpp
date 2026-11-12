#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>

const int PINO_SENSOR = 4;
const char* WIFI_SSID = "Wokwi-GUEST";
const char* WIFI_SENHA = "";

OneWire oneWire(PINO_SENSOR);
DallasTemperature sensor(&oneWire);

void setup()
{
    Serial.begin(115200);
    sensor.begin();
    WiFi.begin(WIFI_SSID, WIFI_SENHA);

    Serial.print("Conectando ao Wi-Fi");

    while (WiFi.status() != WL_CONNECTED)
    {
      delay(500);
      Serial.print(".");
    }

    Serial.println("\nWi-Fi conectado!");

    HTTPClient http;

    http.begin("http://host.wokwi.internal:8000/api/teste");

    int codigoHTTP = http.GET();

    Serial.print("Código HTTP: ");
    Serial.println(codigoHTTP);

    if (codigoHTTP > 0)
    {
        Serial.println(http.getString());
    }
    else
    {
        Serial.println(http.errorToString(codigoHTTP));
    }

    http.end();

    Serial.println(WiFi.localIP());
}

void loop()
{
    sensor.requestTemperatures();
    float temperatura = sensor.getTempCByIndex(0);

    if (temperatura == DEVICE_DISCONNECTED_C)
    {
        Serial.println("Erro: sensor desconectado!");
    }
    else
    {
        Serial.print("Temperatura: ");
        Serial.println(temperatura);

        if (WiFi.status() == WL_CONNECTED)
        {
            HTTPClient http;

            http.begin("http://host.wokwi.internal:8000/api/leituras");

            http.addHeader("Content-Type", "application/json");
            http.addHeader("Accept", "application/json");

            String dados = String("{\"id_sensores\":1,\"temperatura\":")
                           + String(temperatura, 2) + "}";

            int codigoHTTP = http.POST(dados);

            Serial.print("Código HTTP: ");
            Serial.println(codigoHTTP);

            if (codigoHTTP > 0)
            {
                Serial.println(http.getString());
            }
            else
            {
                Serial.println(http.errorToString(codigoHTTP));
            }

            http.end();
        }
        else
        {
            Serial.println("Wi-Fi desconectado!");
        }
    }

    delay(10000);
}