<?php

use App\Models\Province;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('redirects guests away from the provinces list', function () {
    $this->get(route('admin.provinces.index'))->assertRedirect(route('admin.login'));
});

it('lists provinces', function () {
    Province::factory()->create(['name' => 'Gauteng']);

    $this->actingAs($this->admin)
        ->get(route('admin.provinces.index'))
        ->assertOk()
        ->assertSee('Gauteng');
});

it('adds a province', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.provinces.store'), ['name' => 'Limpopo', 'order' => 3])
        ->assertRedirect(route('admin.provinces.index'));

    $province = Province::query()->sole();

    expect($province->name)->toBe('Limpopo')
        ->and($province->order)->toBe(3);
});

it('requires a name when adding a province', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.provinces.store'), ['name' => '', 'order' => 0])
        ->assertSessionHasErrors('name');

    expect(Province::query()->count())->toBe(0);
});

it('updates a province', function () {
    $province = Province::factory()->create(['name' => 'Free State']);

    $this->actingAs($this->admin)
        ->put(route('admin.provinces.update', $province), ['name' => 'North West', 'order' => 1])
        ->assertRedirect(route('admin.provinces.index'));

    expect($province->refresh()->name)->toBe('North West');
});

it('deletes a province', function () {
    $province = Province::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.provinces.destroy', $province))
        ->assertRedirect(route('admin.provinces.index'));

    expect(Province::query()->count())->toBe(0);
});
