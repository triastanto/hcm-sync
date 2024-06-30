<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list organizations', function () {
    $response = $this->getJson('/api/organizations');

    $response
        ->assertStatus(200)
        ->assertJsonIsArray();
});

it('can create an organization', function () {
    $data = [
        'name' => 'Test Organization',
    ];

    $response = $this->postJson('/api/organizations', $data);

    $response
        ->assertStatus(201)
        ->assertJson($data);

    expect(Organization::where('name', 'Test Organization')->exists())->toBeTrue();
});

it('can show an organization', function () {
    $organization = Organization::first();

    $response = $this->getJson("/api/organizations/{$organization->id}");

    $response
        ->assertStatus(200)
        ->assertJson($organization->toArray());
});

it('can update an organization', function () {
    $organization = Organization::first();
    $newData = [
        'name' => 'Updated Organization Name',
    ];

    $response = $this->putJson("/api/organizations/{$organization->id}", $newData);

    $response
        ->assertStatus(200)
        ->assertJson($newData);

    expect(Organization::find($organization->id)->name)->toBe('Updated Organization Name');
});

it('can delete an organization', function () {
    $organization = Organization::first();

    $response = $this->deleteJson("/api/organizations/{$organization->id}");

    $response->assertStatus(204);

    expect(Organization::find($organization->id))->toBeNull();
});
