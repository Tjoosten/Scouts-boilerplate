<?php declare(strict_types=1);

namespace Tests\Feature\Front;

use App\Http\Controllers\Front\Settings\TokensController;
use App\Http\Requests\Users\CreateAccessTokenRequest;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

final class TokenControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function cannotViewTheTokenSettingPageAsGuest(): void
    {
        $response = $this->get(route('api.tokens'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function canSuccessFullyViewTheTokenSettings(): void
    {
        $willem = User::factory()->create();

        $response = $this->actingAs($willem)->get(route('api.tokens'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.settings.apiTokens');
    }

    /** @test */
    public function testIfPersonalAccessTokenCanBeStored(): void
    {
        $this->assertActionUsesMiddleware(TokensController::class, 'store', ['auth']);
        $this->assertActionUsesFormRequest(TokensController::class, 'store', CreateAccessTokenRequest::class);

        $willem = User::factory()->create();

        $response = $this->actingAs($willem)->post(route('api.tokens'), ['name' => 'test_token']);
        $response->assertRedirect(route('api.tokens'));

        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'test_token']);
    }

    /** @test */
    public function testIfAnPersonalAccessTokenCanBeDeleted(): void
    {
        $this->assertActionUsesMiddleware(TokensController::class, 'store', ['auth']);

        $willem = User::factory()->create();
        $willem->createToken('test_token');

        $personalAccessToken = PersonalAccessToken::where('name', 'test_token')->first();

        $response = $this->actingAs($willem)->get(route('api.tokens.revoke', $personalAccessToken));
        $response->assertRedirect(route('api.tokens'));
        $response->assertSessionHas('message', __('De API tokens voor de service :service is met success verwijderd?', ['service' => 'test_token']));
    }
}
