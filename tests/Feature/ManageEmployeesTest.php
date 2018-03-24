<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManageEmployeesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_employee_list_in_employee_index_page()
    {
        factory(Employee::class)->create(['first_name' => 'Testing name']);

        $this->loginAsAdmin();
        $this->visit(route('employees.index'));
        $this->see('Testing name');
    }

    /** @test */
    public function user_can_create_a_employee()
    {
        $company = factory(Company::class)->create();

        $this->loginAsAdmin();
        $this->visit(route('employees.index'));

        $this->click(trans('employee.create'));
        $this->seePageIs(route('employees.index', ['action' => 'create']));

        $this->submitForm(trans('employee.create'), [
            'first_name' => 'First',
            'last_name'  => 'Last Name',
            'company_id' => $company->id,
            'email'      => 'employee@company1.com',
            'phone'      => '081234567890',
        ]);

        $this->seePageIs(route('employees.index'));

        $this->seeInDatabase('employees', [
            'first_name' => 'First',
            'last_name'  => 'Last Name',
            'company_id' => $company->id,
            'email'      => 'employee@company1.com',
            'phone'      => '081234567890',
        ]);
    }

    /** @test */
    public function user_can_edit_a_employee_within_search_query()
    {
        $employee = factory(Employee::class)->create(['first_name' => 'Testing 123']);
        $company = factory(Company::class)->create();

        $this->loginAsAdmin();
        $this->visit(route('employees.index', ['q' => '123']));
        $this->click('edit-employee-'.$employee->id);
        $this->seePageIs(route('employees.index', ['action' => 'edit', 'id' => $employee->id, 'q' => '123']));

        $this->submitForm(trans('employee.update'), [
            'first_name' => 'First',
            'last_name'  => 'Last Name',
            'company_id' => $company->id,
            'email'      => 'employee@company1.com',
            'phone'      => '081234567890',
        ]);

        $this->seePageIs(route('employees.index', ['q' => '123']));

        $this->seeInDatabase('employees', [
            'id'         => $employee->id,
            'first_name' => 'First',
            'last_name'  => 'Last Name',
            'company_id' => $company->id,
            'email'      => 'employee@company1.com',
            'phone'      => '081234567890',
        ]);
    }

    /** @test */
    public function user_can_delete_a_employee()
    {
        $this->loginAsAdmin();
        $employee = factory(Employee::class)->create();

        $this->visit(route('employees.index', [$employee->id]));
        $this->click('del-employee-'.$employee->id);
        $this->seePageIs(route('employees.index', ['action' => 'delete', 'id' => $employee->id]));

        $this->seeInDatabase('employees', [
            'id' => $employee->id,
        ]);

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('employees', [
            'id' => $employee->id,
        ]);
    }
}
