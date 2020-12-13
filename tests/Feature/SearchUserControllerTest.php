<?php

namespace Tests\Feature;

use App\Http\Controllers\Kiosk\Users\SearchController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function searchUserWithoutSearchTerm(): void
    {
         $this->seed(DatabaseSeeder::class);
         $this->assertActionUsesMiddleware(SearchController::class, '__invoke', [
             'auth', 'kiosk', 'forbid-banned-user'
         ]);

         $willem = User::whereEmail('administrator@domain.tld')->firstOrFail();

         $this->actingAs($willem)
             ->get(route('kiosk.users.search', ['term' => '']))
             ->assertSuccessful();
    }

    /** @test */
    public function searchUserWithTermParameter(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(SearchController::class, '__invoke', [
            'auth', 'kiosk', 'forbid-banned-user'
        ]);

        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $this->actingAs($willem)
            ->get(route('kiosk.users.search', ['term' => 'administrator@domain.tld']))
            ->assertSuccessful();
    }
}
