<?php

use App\Models\Tanque;
use App\Models\User;

test('custom login and registration screens are used by Fortify', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Faça login na sua conta')
        ->assertSee('name="password"', false);

    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Crie sua nova conta')
        ->assertSee('name="password_confirmation"', false);
});

test('registration saves the custom user columns and default permission', function () {
    $this->post(route('register'), [
        'name' => 'Produtor de Tilápia',
        'email' => 'produtor@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'nome' => 'Produtor de Tilápia',
        'email' => 'produtor@example.com',
        'permissao' => 'usuario',
    ]);
}

test('users can create and view their own tanks', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('tanques.store'), [
        'nome' => 'Tanque 03',
        'dimensoes' => '30 m x 15 m x 1,5 m',
        'quantidade_alevinos' => 500,
        'especie' => 'Tilápia',
        'volume_estimado' => 810,
        'data_povoamento' => '2026-09-25',
        'temperatura_min' => 24,
        'temperatura_max' => 30,
        'temperatura_alerta_min' => 24,
        'temperatura_alerta_max' => 32,
        'temperatura_critica_min' => 22,
        'temperatura_critica_max' => 34,
        'ph_real' => 7.2,
    ])->assertRedirect(route('tanques.index'));

    $tanque = Tanque::firstOrFail();

    $this->assertDatabaseHas('sensores', [
        'id_tanque' => $tanque->id_tanque,
        'temperatura_min_tanque' => 24,
        'temperatura_max_tanque' => 30,
        'temperatura_critica_min' => 22,
        'temperatura_critica_max' => 34,
    ]);

    $this->get(route('tanques.show', $tanque->id_tanque))
        ->assertOk()
        ->assertSee('Tanque 03');
});

test('a user cannot view another users tank', function () {
    $owner = User::factory()->create();
    $tanque = Tanque::create([
        'id_usuario' => $owner->getKey(),
        'status' => 'normal',
        'tipo' => 'escavado',
        'datatanque_registrada' => now()->toDateString(),
        'nome' => 'Privado',
    ]);

    $this->actingAs(User::factory()->create())
        ->get(route('tanques.show', $tanque->id_tanque))
        ->assertNotFound();
});

test('users can register feed and mortality for their tanks', function () {
    $user = User::factory()->create();
    $tanque = Tanque::create([
        'id_usuario' => $user->getKey(),
        'status' => 'normal',
        'tipo' => 'escavado',
        'datatanque_registrada' => now()->toDateString(),
        'nome' => 'Tanque 01',
    ]);

    $this->actingAs($user)
        ->post(route('alimentacoes.store'), [
            'id_tanque' => $tanque->id_tanque,
            'quantidade_kg' => 2.4,
            'tipo_racao' => 'Extrusada 32%',
            'registrado_em' => now()->format('Y-m-d H:i:s'),
        ])
        ->assertRedirect(route('alimentacoes.index'));

    $this->post(route('mortalidades.store'), [
        'id_tanque' => $tanque->id_tanque,
        'quantidade' => 6,
        'observacao' => 'Queda de temperatura',
        'ocorrido_em' => now()->toDateString(),
    ])->assertRedirect(route('mortalidades.index'));

    $this->assertDatabaseHas('alimentacoes', [
        'id_tanque' => $tanque->id_tanque,
        'tipo_racao' => 'Extrusada 32%',
    ]);
    $this->assertDatabaseHas('mortalidades', [
        'id_tanque' => $tanque->id_tanque,
        'quantidade' => 6,
        'observacao' => 'Queda de temperatura',
    ]);
});
