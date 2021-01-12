<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

/**
 * @see https://github.com/DCzajkowski/auth-tests/blob/master/src/Console/stubs/tests/Feature/Auth/ResetPasswordTest.php
 */
class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidToken(User $user): string
    {
        return Password::broker()->createToken($user);
    }

    protected function getInvalidToken(): string
    {
        return 'invalid-token';
    }

    protected function passwordResetGetRoute(string $token): string
    {
        return route('password.reset', $token);
    }

    protected function passwordResetPostRoute(): string
    {
        return '/password/reset';
    }

    protected function successfulPasswordResetRoute(): string
    {
        return route('home');
    }

    /** @test */
    public function testUserCanViewAPasswordResetForm(): void
    {
        $user = User::factory()->create();

        $response = $this->get($this->passwordResetGetRoute($token = $this->getValidToken($user)));
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
    }

    /** @test */
    public function testUserCanViewAPasswordResetFormWhenAuthenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($this->passwordResetGetRoute($token = $this->getValidToken($user)));
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
    }

    /** @test */
    public function userCanResetPasswordWithValidToken(): void
    {
        Event::fake();

        $user = User::factory()->create();

        $this->post($this->passwordResetPostRoute(), [
            'token' => $this->getValidToken($user),
            'email' => $user->email,
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ])->assertRedirect($this->successfulPasswordResetRoute());

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(PasswordReset::class, static function (PasswordReset $event) use ($user): bool {
            return $event->user->id === $user->id;
        });
    }

    /** @test */
    public function userCannotResetPasswordWithInvalidToken(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);

        $this->from($this->passwordResetGetRoute($this->getInvalidToken()))
            ->post($this->passwordResetPostRoute(), [
               'token' => $this->getInvalidToken(),
               'email' => $user->email,
               'password' => 'new-awesome-password',
               'password_confirmation' => 'new-awesome-password'
            ])->assertRedirect($this->passwordResetGetRoute($this->getInvalidToken()));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotResetPasswordWithoutProvidingANewPassword(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);

        $response = $this->from($this->passwordResetGetRoute($token = $this->getValidToken($user)))
            ->post($this->passwordResetPostRoute(), [
                'token' => $token,
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function userCannotResetPasswordWithoutProvidingAnEmail(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);

        $response = $this->from($this->passwordResetGetRoute($token = $this->getValidToken($user)))
            ->post($this->passwordResetPostRoute(), [
                'token' => $token,
                'email' => '',
                'password' => 'new-awesome-password',
                'password_confirmation' => 'new-awesome-password',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('email');

        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }
}
