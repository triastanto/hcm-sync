<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can find superior', function () {
    $employee = Employee::first();
    $superior = $employee->getSuperior();

    $response = $this->getJson("/api/employees/{$employee->id}/superior");

    $response
        ->assertOk()
        ->assertJson($superior->toArray());
});

it('can find subordinates', function () {
    $employee = Employee::first();
    $superior = $employee->getSuperior();

    $response = $this->getJson("/api/employees/{$superior->id}/subordinates");

    $response
        ->assertOk()
        ->assertJsonIsArray();
});
