<?php

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Foundation\Testing\DatabaseTruncation;

uses(DatabaseTruncation::class);

it('can list employees', function () {
    Employee::factory()->count(3)->create();

    $response = $this->getJson('/api/employees');

    $response
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('can create an employee', function () {
    $position = Position::factory()->create();

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
    $employee = Employee::factory()->create();

    $response = $this->getJson("/api/employees/{$employee->id}");

    $response
        ->assertStatus(200)
        ->assertJson($employee->toArray());
});

it('can update an employee', function () {
    $employee = Employee::factory()->create();
    $position = Position::factory()->create();

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
    $employee = Employee::factory()->create();

    $response = $this->deleteJson("/api/employees/{$employee->id}");

    $response->assertStatus(204);

    expect(Employee::find($employee->id))->toBeNull();
});
