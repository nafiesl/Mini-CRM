<?php

namespace Tests\Feature;

use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManageCompaniesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_company_list_in_company_index_page()
    {
        $company = factory(Company::class)->create();

        $this->loginAsAdmin();
        $this->visit(route('companies.index'));
        $this->see($company->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'    => 'Company 1 name',
            'email'   => 'contact@company1.com',
            'website' => 'http://company1.com',
            'address' => 'Palm Street, Little Rock, AR',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_company()
    {
        $this->loginAsAdmin();
        $this->visit(route('companies.index'));

        $this->click(trans('company.create'));
        $this->seePageIs(route('companies.create'));

        $this->submitForm(trans('company.create'), $this->getCreateFields());

        $this->seePageIs(route('companies.show', Company::first()));

        $this->seeInDatabase('companies', $this->getCreateFields());
    }

    /** @test */
    public function create_company_action_must_pass_validations()
    {
        $this->loginAsAdmin();

        // Name empty
        $this->post(route('companies.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->post(route('companies.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Email empty
        $this->post(route('companies.store'), $this->getCreateFields(['email' => '']));
        $this->assertSessionHasErrors('email');

        // Invalid Email
        $this->post(route('companies.store'), $this->getCreateFields([
            'email' => 'Test non email',
        ]));
        $this->assertSessionHasErrors('email');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'    => 'Company 1 name',
            'email'   => 'contact@company1.com',
            'website' => 'http://company1.com',
            'address' => 'Palm Street, Little Rock, AR',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_company()
    {
        $this->loginAsAdmin();
        $company = factory(Company::class)->create(['name' => 'Testing 123']);

        $this->visit(route('companies.show', $company));
        $this->click('edit-company-'.$company->id);
        $this->seePageIs(route('companies.edit', $company));

        $this->submitForm(trans('company.update'), $this->getEditFields());

        $this->seePageIs(route('companies.show', $company));

        $this->seeInDatabase('companies', [
            'id' => $company->id,
        ] + $this->getEditFields());
    }

    /** @test */
    public function edit_company_action_must_pass_validations()
    {
        $this->loginAsAdmin();
        $company = factory(Company::class)->create(['name' => 'Testing 123']);

        // Name empty
        $this->patch(route('companies.update', $company), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->patch(route('companies.update', $company), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Email empty
        $this->patch(route('companies.update', $company), $this->getEditFields(['email' => '']));
        $this->assertSessionHasErrors('email');

        // Invalid Email
        $this->patch(route('companies.update', $company), $this->getEditFields([
            'email' => 'Test non email',
        ]));
        $this->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_can_delete_a_company()
    {
        $this->loginAsAdmin();
        $company = factory(Company::class)->create();

        $this->visit(route('companies.edit', $company));
        $this->click('del-company-'.$company->id);
        $this->seePageIs(route('companies.edit', [$company, 'action' => 'delete']));

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('companies', [
            'id' => $company->id,
        ]);
    }
}
