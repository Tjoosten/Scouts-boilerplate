<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @see https://github.com/DCzajkowski/auth-tests/blob/master/src/Console/stubs/tests/Feature/Auth/ForgotPasswordTest.php
 */
class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function passwordRequestRoute(): string
    {
        return route('password.request');
    }

    protected function passwordEmailGetRoute(): string
    {
        return route('password.email');
    }

    protected function passwordEmailPostRoute(): string
    {
        return route('password.email');
    }

    /** @test */
    public function userCanViewAnEmailPasswordForm(): void
    {
        $response = $this->get($this->passwordRequestRoute());
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.email');
    }

    /** @test */
    public function userCanViewAnEmailPasswordFormWhenAuthenticated(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($this->passwordRequestRoute());
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.email');
    }

    /** @test */
    public function userReceivesAnEmailWithAPasswordResetLink(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'john@example.com']);
        $response = $this->post($this->passwordEmailPostRoute(), ['email' => $user->email]);

        $this->assertNotNull($token = DB::table('password_resets')->first());

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    /** @test */
    public function userDoesNotReceiveEmailWhenNotRegistered(): void
    {
        Notification::fake();

        $response = $this->from($this->passwordEmailGetRoute())
            ->post($this->passwordEmailPostRoute(), ['email' => 'nobidt@example.com']);

        $response->assertRedirect($this->passwordEmailGetRoute());
        $response->assertSessionHasErrors('email');

        Notification::assertNotSentTo(User::factory()->make(['email' => 'nobody@example.com']), ResetPassword::class);
    }

    /** @test */
    public function emailIsRequired(): void
    {
        $response = $this->from($this->passwordEmailGetRoute())->post($this->passwordEmailPostRoute(), []);
        $response->assertRedirect($this->passwordEmailGetRoute());
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function emailIsAValidEmail(): void
    {
        $response = $this->from($this->passwordEmailGetRoute())
            ->post($this->passwordEmailPostRoute(), ['email' => 'invalid-email']);

        $response->assertRedirect($this->passwordEmailGetRoute());
        $response->assertSessionHasErrors('email');
    }
}
