<?php

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list employees', function () {
    $response = $this->getJson('/api/employees');

    $response
        ->assertStatus(200)
        ->assertJsonIsArray();
});

it('can create an employee', function () {
    $position = Position::first();

    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'username' => 'johndoe',
        'personnel_no' => 'EMP001',
        'position_id' => $position->id,
    ];

    $response = $this->postJson('/api/employees', $data);

    $response
        ->assertStatus(201)
        ->assertJson($data);

    expect(Employee::where('name', 'John Doe')->exists())->toBeTrue();
});

it('can show an employee', function () {
    $employee = Employee::first();

    $response = $this->getJson("/api/employees/{$employee->id}");

    $response
        ->assertStatus(200)
        ->assertJson($employee->toArray());
});

it('can update an employee', function () {
    $employee = Employee::first();
    $position = Position::first();

    $newData = [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'username' => 'janedoe',
        'personnel_no' => 'EMP002',
        'position_id' => $position->id,
    ];

    $response = $this->putJson("/api/employees/{$employee->id}", $newData);

    $response
        ->assertStatus(200)
        ->assertJson($newData);

    expect(Employee::find($employee->id)->name)->toBe('Jane Doe');
});

it('can delete an employee', function () {
    $employee = Employee::first();

    $response = $this->deleteJson("/api/employees/{$employee->id}");

    $response->assertStatus(204);

    expect(Employee::find($employee->id))->toBeNull();
});
