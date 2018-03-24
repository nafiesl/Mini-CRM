<?php

namespace Tests\Unit\Policies;

use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class EmployeePolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_employee()
    {
        $user = $this->loginAsAdmin();
        $this->assertTrue($user->can('create', new Employee));
    }

    /** @test */
    public function user_can_view_employee()
    {
        $user = $this->loginAsAdmin();
        $employee = factory(Employee::class)->create();
        $this->assertTrue($user->can('view', $employee));
    }

    /** @test */
    public function user_can_update_employee()
    {
        $user = $this->loginAsAdmin();
        $employee = factory(Employee::class)->create();
        $this->assertTrue($user->can('update', $employee));
    }

    /** @test */
    public function user_can_delete_employee()
    {
        $user = $this->loginAsAdmin();
        $employee = factory(Employee::class)->create();
        $this->assertTrue($user->can('delete', $employee));
    }
}
