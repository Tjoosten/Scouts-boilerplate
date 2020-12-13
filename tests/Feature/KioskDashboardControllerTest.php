<?php

namespace Tests\Feature;

use App\Http\Controllers\Kiosk\DashboardController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class KioskDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canSuccessFullyViewTheKioskDashboardPage(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(DashboardController::class, '__invoke', ['auth', 'kiosk']);

        $rick = User::whereEmail('administrator@domain.tld')->firstOrFail();

        $this->actingAs($rick)
            ->get(route('kiosk.dashboard'))
            ->assertSuccessful();
    }
}
