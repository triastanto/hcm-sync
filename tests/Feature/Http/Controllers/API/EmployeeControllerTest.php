<?php

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list employees', function () {
    $data = Employee::paginate()->toArray();
    $response = $this->getJson('/api/employees');

    $response
        ->assertOk()
        ->assertJsonFragment(['data' => $data['data']]);
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
        ->assertOk()
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
        ->assertOk()
        ->assertJson($newData);

    expect(Employee::find($employee->id)->name)->toBe('Jane Doe');
});

it('can delete an employee', function () {
    $employee = Employee::first();

    $response = $this->deleteJson("/api/employees/{$employee->id}");

    $response->assertStatus(204);

    expect(Employee::find($employee->id))->toBeNull();
});
