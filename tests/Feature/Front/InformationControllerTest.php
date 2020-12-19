<?php

namespace Tests\Feature\Front;

use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\Settings\DeleteController;
use App\Http\Controllers\Front\Settings\InformationController;
use App\Http\Requests\Profile\InformationSettingsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InformationControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function canSuccessFullyViewTheAccountSettingsPage(): void
    {
        $this->assertActionUsesMiddleware(InformationController::class, 'index', [
            'auth', 'forbid-banned-user'
        ]);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->get(route('account.settings.information'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.settings.information');
    }

    /** @test */
    public function canSuccessfullyTheAccountInformation(): void
    {
        $this->assertActionUsesFormRequest(InformationController::class, 'update', InformationSettingsRequest::class);
        $this->assertActionUsesMiddleware(InformationController::class, 'update', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->patch(route('account.settings.information'), [
            'name' => $this->faker->name, 'email' => $this->faker->safeEmail
        ]);

        $response->assertRedirect(route('account.settings.information'));
        $response->assertSessionHas('informationUpdated', true);
    }



    /** @test */
    public function userCanDeleteHisAccount(): void
    {
        $this->assertActionUsesMiddleware(DeleteController::class, '__invoke', ['auth', 'forbid-banned-user']);

        $rick = User::factory()->create();

        $response = $this->actingAs($rick)->delete(route('account.delete'));
        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('users', ['id' => $rick->id]);
    }
}
