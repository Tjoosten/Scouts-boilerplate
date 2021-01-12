<?php

namespace Tests\Feature\Front;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    /** @test */
    public function canDisplaySuccessfullyTheWelcomePage(): void
    {
        $this->get(route('welcome'))
            ->assertSuccessful()
            ->assertViewIs('welcome');
    }
}
