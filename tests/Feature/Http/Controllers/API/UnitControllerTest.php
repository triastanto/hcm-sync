<?php

use App\Models\Organization;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list units', function () {
    $data = Unit::paginate()->toArray();
    $response = $this->getJson('/api/units');

    $response
        ->assertOk()
        ->assertJsonFragment(['data' => $data['data']]);
});

it('can create a unit', function () {
    $organization = Organization::first();
    $unitData = [
        'name' => 'New Unit',
        'organization_id' => $organization->id,
    ];

    $response = $this->postJson('/api/units', $unitData);

    $response->assertStatus(201)
        ->assertJsonFragment($unitData);

    $this->assertDatabaseHas('units', $unitData);
});

it('can show a unit', function () {
    $unit = Unit::first();

    $response = $this->getJson("/api/units/{$unit->id}");

    $response->assertOk()
        ->assertJsonFragment(['name' => $unit->name]);
});

it('can update a unit', function () {
    $unit = Unit::first();

    $updatedData = [
        'name' => 'Updated Unit',
    ];

    $response = $this->putJson("/api/units/{$unit->id}", $updatedData);

    $response->assertOk()
        ->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('units', $updatedData);
});

it('can delete a unit', function () {
    $unit = Unit::first();

    $response = $this->deleteJson("/api/units/{$unit->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('units', ['id' => $unit->id]);
});
