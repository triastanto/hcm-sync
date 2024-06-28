<?php

use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseTruncation;

uses(DatabaseTruncation::class);

it('can list units', function () {

    Unit::factory()->count(3)->create();

    $response = $this->getJson('/api/units');

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

it('can create a unit', function () {
    $unitData = [
        'name' => 'New Unit',
        'organization_id' => Organization::factory()->create()->id,
    ];

    $response = $this->postJson('/api/units', $unitData);

    $response->assertStatus(201)
             ->assertJsonFragment($unitData);

    $this->assertDatabaseHas('units', $unitData);
});

it('can show a unit', function () {
    $unit = Unit::factory()->create();

    $response = $this->getJson("/api/units/{$unit->id}");

    $response->assertStatus(200)
             ->assertJsonFragment(['name' => $unit->name]);
});

it('can update a unit', function () {
    $unit = Unit::factory()->create();

    $updatedData = [
        'name' => 'Updated Unit',
    ];

    $response = $this->putJson("/api/units/{$unit->id}", $updatedData);

    $response->assertStatus(200)
             ->assertJsonFragment($updatedData);

    $this->assertDatabaseHas('units', $updatedData);
});

it('can delete a unit', function () {
    $unit = Unit::factory()->create();

    $response = $this->deleteJson("/api/units/{$unit->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('units', ['id' => $unit->id]);
});
