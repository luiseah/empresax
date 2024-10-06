<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Managers\ProductManager;
use Tests\Managers\UserManager;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;
    use UserManager;
    use ProductManager;
}
