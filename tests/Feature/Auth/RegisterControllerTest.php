<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @see https://github.com/DCzajkowski/auth-tests/blob/master/src/Console/stubs/tests/Feature/Auth/RegisterTest.php
 */
class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function successfulRegistrationRoute(): string
    {
        return route('home');
    }

    protected function registerGetRoute(): string
    {
        return route('register');
    }

    protected function registerPostRoute(): string
    {
        return route('register');
    }

    protected function guestMiddlewareRoute(): string
    {
        return route('home');
    }

    /** @test */
    public function userCanViewARegistrationForm(): void
    {
        $response = $this->get($this->registerGetRoute());
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function userCannotViewARegistrationFormWhenAuthenticated(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($this->registerGetRoute());
        $response->assertRedirect($this->guestMiddlewareRoute());
    }

    /** @test */
    public function testUserCanRegister(): void
    {
        Event::fake();

        $response = $this->post($this->registerPostRoute(), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-laravel'
        ]);

        $response->assertRedirect($this->successfulRegistrationRoute());

        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('i-love-laravel', $user->password));

        Event::assertDispatched(Registered::class, static function (Registered $event) use ($user): bool {
            return $event->user->id === $user->id;
        });
    }

    /** @test */
    public function userCannotRegisteredWithoutName(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
           'name' => '',
           'email' => 'john@example.com',
           'password' => 'i-love-laravel',
           'password_confirmation' => 'i-love-laravel',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('name');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotRegisterWithoutEmail(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
           'name' => 'John Doe',
           'email' => '',
           'password' => 'i-love-laravel',
           'password_confirmation' => 'i-love-laravel',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotRegisterWithInvalidEmail(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
           'name' => 'John Doe',
           'email' => 'invalid-email',
           'password' => 'i-love-laravel',
           'password_confirmation' => 'i-love-laravel'
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotRegisterWithoutPassword(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotRegisterWithoutPasswordConfirmation(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
           'name' => 'John Doe',
           'email' => 'jogn@example.com',
           'password' => 'i-love-laravel',
           'password_confirmation' => '',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotRegisterWithPasswordsNotMatching(): void
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
           'name' => 'John Doe',
           'email' => 'john@example.com',
           'password' => 'i-love-laravel',
           'password_confirmation' => 'i-hate-laravel',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);

        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
