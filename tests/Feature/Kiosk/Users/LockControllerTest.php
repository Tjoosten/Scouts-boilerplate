<?php

namespace Tests\Feature\Kiosk\Users;

use App\Http\Controllers\Kiosk\Users\LockController;
use App\Http\Requests\Users\DeactivateFormRequest;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LockControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function userCanViewTheDeactivationView(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(LockController::class, 'create', [
            'auth', 'kiosk', 'forbid-banned-user'
        ]);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $response = $this->actingAs($lena)->get(route('kiosk.users.deactivate', $willem));
        $response->assertSuccessful();
        $response->assertViewIs('kiosk.users.deactivate');
    }

    /** @test */
    public function reasonIsRequiredByDeactivation(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesFormRequest(LockController::class, 'store', DeactivateFormRequest::class);
        $this->assertActionUsesMiddleware(LockController::class, 'store', [
            'auth', 'kiosk', 'forbid-banned-user'
        ]);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $response = $this->actingAs($lena)->post(route('kiosk.users.deactivate', $willem), ['reden' => '']);
        $response->assertSessionHasErrors('reden');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    public function anUserCanSuccessfullyDeactivated(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesFormRequest(LockController::class, 'store', DeactivateFormRequest::class);
        $this->assertActionUsesMiddleware(LockController::class, 'store', [
            'auth', 'kiosk', 'forbid-banned-user'
        ]);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $response = $this->actingAs($lena)->post(route('kiosk.users.deactivate', $willem), ['reden' => $this->faker->sentence]);
        $response->assertRedirect(route('kiosk.users.show', $willem));

        $this->assertTrue($willem->fresh()->isBanned());
    }

    /** @test */
    public function anUserCanBeActivated(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(LockController::class, 'store', [
            'auth', 'kiosk', 'forbid-banned-user'
        ]);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();
        $willem->ban();

        $response = $this->actingAs($lena)->get(route('kiosk.users.activate', $willem->fresh()));
        $response->assertRedirect(route('kiosk.users.show', $willem));
        $response->assertSessionHas([
           'laravel_flash_message.message' => __('De gebruikers account van :user is terug geactiveerd.', ['user' => $willem->name]),
           'laravel_flash_message.class' => 'alert-success',
        ]);

        $this->assertTrue($willem->isNotBanned());
    }
}
