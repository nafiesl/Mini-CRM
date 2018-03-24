<?php

namespace Tests;

use App\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost';

    use CreatesApplication;

    public function loginAsAdmin()
    {
        $admin = factory(User::class)->create();
        $this->actingAs($admin);

        return $admin;
    }
}
