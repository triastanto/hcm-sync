<?php

use App\Models\Unit;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list positions', function () {
    $data = Position::paginate()->toArray();
    $response = $this->getJson('/api/positions');

    $response
        ->assertOk()
        ->assertJsonFragment(['data' => $data['data']]);
});

it('can create a position', function () {
    $unit = Unit::first();

    $data = [
        'title' => 'Software Engineer',
        'unit_id' => $unit->id,
    ];

    $response = $this->postJson('/api/positions', $data);

    $response
        ->assertStatus(201)
        ->assertJson($data);

    expect(Position::where('title', 'Software Engineer')->exists())->toBeTrue();
});

it('can show a position', function () {
    $position = Position::first();

    $response = $this->getJson("/api/positions/{$position->id}");

    $response
        ->assertOk()
        ->assertJson($position->toArray());
});

it('can update a position', function () {
    $position = Position::first();
    $unit = Unit::first();

    $newData = [
        'title' => 'Senior Software Engineer',
        'unit_id' => $unit->id,
    ];

    $response = $this->putJson("/api/positions/{$position->id}", $newData);

    $response
        ->assertOk()
        ->assertJson($newData);

    expect(Position::find($position->id)->title)->toBe('Senior Software Engineer');
});

it('can delete a position', function () {
    $position = Position::first();

    $response = $this->deleteJson("/api/positions/{$position->id}");

    $response->assertStatus(204);

    expect(Position::find($position->id))->toBeNull();
});
