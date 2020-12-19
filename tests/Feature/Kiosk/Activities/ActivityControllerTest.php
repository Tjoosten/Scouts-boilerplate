<?php

namespace Tests\Feature\Kiosk\Activities;

use App\Http\Controllers\Kiosk\Users\ActivityController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function canSuccessfullyViewTheActivityWhenThereAreActivitiesLogged(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(ActivityController::class, '__invoke', ['auth', 'forbid-banned-user', 'kiosk']);
        $this->setupLoggedActivities($lena = User::whereEmail('administrator@domain.tld')->firstOrFail());

        $response = $this->actingAs($lena)->get(route('kiosk.users.activities', $lena));
        $response->assertSuccessful();
        $response->assertViewIs('kiosk.activities.show');
    }

    private function setupLoggedActivities(User $user): void
    {
        $user->logActivity('Gebruikers', __($this->faker->sentence));
        $user->logActivity('Gebruikers', __($this->faker->sentence));
    }
}
