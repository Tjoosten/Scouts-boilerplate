<?php

namespace Tests\Feature;

use App\Http\Controllers\Kiosk\Users\UsersController;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Users\AccountDeletedNotification;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private function requestData(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'role' => Role::first()->name,
            'password' => $password = $this->faker->password(8),
            'password_confirmation' => $password
        ];
    }

    /** @test */
    public function UserOverviewPageCanBeDisplayedSuccessful(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'index', ['auth', 'kiosk']);

        $lena = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $this->actingAs($lena)
            ->get(route('kiosk.users.index'))
            ->assertSuccessful()
            ->assertViewIs('kiosk.users.index');
    }

    /** @test */
    public function UserCanBeShownInTheKiosk(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'show', ['auth', 'kiosk']);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $this->actingAs($lena)
            ->get(route('kiosk.users.show', $willem))
            ->assertSuccessful()
            ->assertViewIs('kiosk.users.show');
    }

    /** @test */
    public function canDisplayTheUserCreateView(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'create', ['auth', 'kiosk']);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();

        $this->actingAs($lena)
            ->get(route('kiosk.users.create'))
            ->assertSuccessful()
            ->assertViewIs('kiosk.users.create');
    }

    /** @test */
    public function canDisplayTheUserUpdateView(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'edit', ['auth', 'kiosk']);

        $lena = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();

        $this->actingAs($willem)
            ->get(route('kiosk.users.update', $lena))
            ->assertSuccessful()
            ->assertViewIs('kiosk.users.edit');
    }

    /** @test */
    public function canSuccessfullyStoreUsers(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'store', ['auth', 'kiosk']);
        $this->assertActionUsesFormRequest(UsersController::class, 'store', CreateUserRequest::class);

        $willem = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $requestData = $this->requestData();

        $this->actingAs($willem)
            ->post(route('kiosk.users.create'), $requestData)
            ->assertRedirect(route('kiosk.users.show', User::whereEmail($requestData['email'])->firstOrFail()));

        $this->assertDatabaseHas('users', Arr::except($requestData, ['password', 'password_confirmation', 'role']));
    }

    /** @test */
    public function canUpdateAnUserAccountWithPassword(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesFormRequest(UsersController::class, 'update', UpdateUserRequest::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'update', ['auth', 'kiosk']);

        $willem      = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $lena        = User::whereEmail('webmaster@domain.tld')->firstOrFail();
        $requestData = $this->requestData();

        $this->actingAs($lena)
            ->patch(route('kiosk.users.update', $willem), $requestData)
            ->assertRedirect(route('kiosk.users.show', $willem))
            ->assertSessionHas([
                'laravel_flash_message.message' => __('Het gebruikers account van :user is met success aangepast.', ['user' => $requestData['name']]),
                'laravel_flash_message.class' => 'alert-success',
            ]);
    }

    /** @test  */
    public function canUpdateANUserAccountWithoutAnGivenPassword(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesFormRequest(UsersController::class, 'update', UpdateUserRequest::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'update', ['auth', 'kiosk']);

        $willem      = User::whereEmail('administrator@domain.tld')->firstOrFail();
        $lena        = User::whereEmail('webmaster@domain.tld')->firstOrFail();
        $requestData = $this->requestData();

        $this->actingAs($lena)
            ->patch(route('kiosk.users.update', $willem), Arr::except($requestData, ['password', 'password_confirmation']))
            ->assertRedirect(route('kiosk.users.show', $willem))
            ->assertSessionHas([
                'laravel_flash_message.message' => __('Het gebruikers account van :user is met success aangepast.', ['user' => $requestData['name']]),
                'laravel_flash_message.class' => 'alert-success',
            ]);
    }

    /** @test */
    public function administratorOfWebmasterCVanViewTheDeletionConfirmationView(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'destroy', ['auth', 'kiosk']);

        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();
        $lena   = User::whereEmail('administrator@domain.tld')->firstOrFail();

        $response = $this->actingAs($lena)->get(route('kiosk.users.delete', $willem))
            ->assertSuccessful()
            ->assertViewIs('kiosk.users.delete');
    }

    /** @test */
    public function userCanByDeletedByAnAdministatorOrWebmaster(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertActionUsesMiddleware(UsersController::class, 'destroy', ['auth', 'kiosk']);

        $willem = User::whereEmail('webmaster@domain.tld')->firstOrFail();
        $lena   = User::whereEmail('administrator@domain.tld')->firstOrFail();

        $this->actingAs($willem)
            ->delete(route('kiosk.users.delete', $willem))
            ->assertRedirect(route('kiosk.users.index'))
            ->assertSessionHas([
                'laravel_flash_message.message' => __('De login van :user is verwijderd in :applicatie', [
                    'user' => $willem->name, 'applicatie' => config('app.name')
                ])
            ]);

        $this->assertDatabaseMissing('users', ['id' => $willem->id]);
    }
}
