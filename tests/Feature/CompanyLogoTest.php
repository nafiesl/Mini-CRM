<?php

namespace Tests\Feature;

use App\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Storage;
use Tests\TestCase;

class CompanyLogoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_upload_a_company_logo()
    {
        Storage::fake('avatars');

        $company = factory(Company::class)->create();

        $this->loginAsAdmin();
        $this->visit(route('companies.edit', $company));

        $this->attach(storage_path('app/sample-logo.jpg'), 'logo');
        $this->press(trans('company.upload_logo'));

        $this->seePageIs(route('companies.edit', $company));

        Storage::disk('avatars')->assertExists($company->fresh()->logo);
    }
}
