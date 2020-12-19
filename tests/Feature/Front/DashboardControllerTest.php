<?php

namespace Tests\Feature\Front;

use App\Http\Controllers\Front\DashboardController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canDisplayTheDashboardPageSuccessfully(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(DashboardController::class, '__invoke', [
            'auth', 'forbid-banned-user'
        ]);

        $lena = User::first();

        $response = $this->actingAs($lena)->get(route('home'));
        $response->assertSuccessful();
        $response->assertViewIs('home');
    }
}
