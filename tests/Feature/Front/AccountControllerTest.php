<?php

namespace Tests\Feature\Front;

use App\Http\Controllers\Front\AccountController;
use App\Http\Requests\Profile\InformationSettingsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function canSuccessFullyViewTheAccountSettingsPage(): void
    {
        $this->assertActionUsesMiddleware(AccountController::class, 'index', [
            'auth', 'forbid-banned-user'
        ]);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->get(route('account.settings'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.settings');
    }

    /** @test */
    public function canSuccessfullyTheAccountInformation(): void
    {
        $this->assertActionUsesFormRequest(AccountController::class, 'updateInformation', InformationSettingsRequest::class);
        $this->assertActionUsesMiddleware(AccountController::class, 'updateInformation', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->patch(route('account.settings.information'), [
            'name' => $this->faker->name, 'email' => $this->faker->safeEmail
        ]);

        $response->assertRedirect(route('account.settings'));
        $response->assertSessionHas('informationUpdated', true);
    }

    /** @test */
    public function canSuccessfullyTheAccountSecurity(): void
    {
        $this->assertActionUsesFormRequest(AccountController::class, 'updateSecurity', SecuritySettingsRequest::class);
        $this->assertActionUsesMiddleware(AccountController::class, 'updateSecurity', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create(['password' => $password = 'laravel']);

        $response = $this->actingAs($rick)->patch(route('account.settings.security'), [
           'currentPassword' => $password, 'password' => 'password', 'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('account.settings'));
        $response->assertSessionHas('securityUpdated.success', true);
    }

    /** @test */
    public function userCanDeleteHisAccount(): void
    {
        $this->assertActionUsesMiddleware(AccountController::class, 'destroy', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->delete(route('account.delete'));
        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('users', ['id' => $rick->id]);
    }
}
