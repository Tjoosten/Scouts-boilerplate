<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @see https://github.com/DCzajkowski/auth-tests/blob/master/src/Console/stubs/tests/Feature/Auth/LoginTest.php
 */
class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function successfulLoginRoute(): string
    {
        return route('home');
    }

    protected function loginGetRoute(): string
    {
        return route('login');
    }

    protected function loginPostRoute(): string
    {
        return route('login');
    }

    public function logoutRoute(): string
    {
        return route('logout');
    }

    protected function successfulLogoutRoute(): string
    {
        return '/';
    }

    protected function guestMiddlewareRoute(): string
    {
        return route('home');
    }

    /** @test */
    protected function getTooManyLoginAttemptsMessage(): string
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    public function userCanViewALoginForm(): string
    {
        $response = $this->get($this->loginGetRoute());
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function userCannotViewALoginFormWhenAuthenticated(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($this->loginGetRoute());
        $response->assertRedirect($this->guestMiddlewareRoute());
    }

    /** @test */
    public function userCanLoginWithCorrectCredentials(): void
    {
        $user = User::factory()->create(['password' => $password = 'i-love-laravel']);

        $response = $this->post($this->loginPostRoute(), ['email' => $user->email, 'password' => $password]);
        $response->assertRedirect($this->successfulLoginRoute());

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function rememberMeFunctionality(): void
    {
        $user = User::factory()->create(['id' => random_int(1, 100), 'password' => $password = 'i-love-laravel']);

        $response = $this->post($this->loginPostRoute(), [
            'email' => $user->email, 'password' => $password, 'remember' => 'on',
        ]);

        $user = $user->fresh();

        $response->assertRedirect($this->successfulLoginRoute());
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id, $user->getRememberToken(), $user->password,
        ]));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function userCannotLoginWithIncorrectPassword(): void
    {
        $user = User::factory()->create(['password' => Hash::make('i-love-laravel'),]);

        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'email' => $user->email, 'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotLoginWithEmailThatDoesNotExist(): void
    {
        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'email' => 'nobody@example.com', 'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function userCanLogout(): void
    {
        $this->be(User::factory()->create());

        $response = $this->post($this->logoutRoute());
        $response->assertRedirect($this->successfulLogoutRoute());

        $this->assertGuest();
    }

    /** @test */
    public function userCannotLogoutWhenNotAuthenticated(): void
    {
        $response = $this->post($this->logoutRoute());
        $response->assertRedirect($this->successfulLogoutRoute());

        $this->assertGuest();
    }

    /** @test */
    public function userCannotMakeMoreThanFiveAttemptsInOneMinute(): void
    {
        $user = User::factory()->create(['password' => $password = 'i-love-laravel']);

        foreach (range(0, 5) as $_) {
            $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
                'email' => $user->email, 'password' => 'invalid-password',
            ]);
        }

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('email');

        $this->assertMatchesRegularExpression(
            $this->getTooManyLoginAttemptsMessage(),
            collect($response->baseResponse->getSession()->get('errors')->getBag('default')->get('email'))->first()
        );

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
