<?php

namespace Tests\Unit\Policies;

use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class CompanyPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_company()
    {
        $user = $this->loginAsAdmin();
        $this->assertTrue($user->can('create', new Company));
    }

    /** @test */
    public function user_can_view_company()
    {
        $user = $this->loginAsAdmin();
        $company = factory(Company::class)->create(['name' => 'Company 1 name']);
        $this->assertTrue($user->can('view', $company));
    }

    /** @test */
    public function user_can_update_company()
    {
        $user = $this->loginAsAdmin();
        $company = factory(Company::class)->create(['name' => 'Company 1 name']);
        $this->assertTrue($user->can('update', $company));
    }

    /** @test */
    public function user_can_delete_company()
    {
        $user = $this->loginAsAdmin();
        $company = factory(Company::class)->create(['name' => 'Company 1 name']);
        $this->assertTrue($user->can('delete', $company));
    }
}
