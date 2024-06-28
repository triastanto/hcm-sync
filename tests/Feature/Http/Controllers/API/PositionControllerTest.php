<?php

use App\Models\Organization;
use App\Models\Position;
use Illuminate\Foundation\Testing\DatabaseTruncation;

uses(DatabaseTruncation::class);

it('can list positions', function () {
    Position::factory()->count(3)->create();

    $response = $this->getJson('/api/positions');

    $response
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('can create a position', function () {
    $organization = Organization::factory()->create();

    $data = [
        'title' => 'Software Engineer',
        'organization_id' => $organization->id,
    ];

    $response = $this->postJson('/api/positions', $data);

    $response
        ->assertStatus(201)
        ->assertJson($data);

    expect(Position::where('title', 'Software Engineer')->exists())->toBeTrue();
});

it('can show a position', function () {
    $position = Position::factory()->create();

    $response = $this->getJson("/api/positions/{$position->id}");

    $response
        ->assertStatus(200)
        ->assertJson($position->toArray());
});

it('can update a position', function () {
    $position = Position::factory()->create();
    $organization = Organization::factory()->create();

    $newData = [
        'title' => 'Senior Software Engineer',
        'organization_id' => $organization->id,
    ];

    $response = $this->putJson("/api/positions/{$position->id}", $newData);

    $response
        ->assertStatus(200)
        ->assertJson($newData);

    expect(Position::find($position->id)->title)->toBe('Senior Software Engineer');
});

it('can delete a position', function () {
    $position = Position::factory()->create();

    $response = $this->deleteJson("/api/positions/{$position->id}");

    $response->assertStatus(204);

    expect(Position::find($position->id))->toBeNull();
});