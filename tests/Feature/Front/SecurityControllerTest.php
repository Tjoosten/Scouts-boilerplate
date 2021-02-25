<?php

namespace Tests\Feature\Front;

use App\Http\Controllers\Front\Settings\SecurityController;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SecurityControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function canDisplaySuccessfullyTheSecuritySettingsView(): void
    {
        $this->assertActionUsesMiddleware(SecurityController::class, 'index', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->get(route('account.settings.security'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.settings.security');
    }
}
