<?php

namespace Tests\Unit\Models;

use App\Company;
use App\Employee;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase as TestCase;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_company_has_name_link_method()
    {
        $company = factory(Company::class)->create();

        $this->assertEquals(
            link_to_route('companies.show', $company->name, [$company->id], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $company->name, 'type' => trans('company.company')]
                ),
            ]), $company->nameLink()
        );
    }

    /** @test */
    public function a_company_has_belongs_to_creator_relation()
    {
        $company = factory(Company::class)->make();

        $this->assertInstanceOf(User::class, $company->creator);
        $this->assertEquals($company->creator_id, $company->creator->id);
    }

    /** @test */
    public function a_company_has_many_employees_relation()
    {
        $company = factory(Company::class)->create();
        $employee = factory(Employee::class)->create(['company_id' => $company->id]);

        $this->assertInstanceOf(Collection::class, $company->employees);
        $this->assertInstanceOf(Employee::class, $company->employees->first());
    }
}
