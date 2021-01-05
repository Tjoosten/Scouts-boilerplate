<?php

namespace App\Models;

use App\Models\Traits\ActivityLogging;
use App\Models\Traits\KioskMethods;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\TwoFactorAuthMethods;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable implements BannableContract
{
    use HasFactory;
    use Notifiable;
    use ActivityLogging;
    use HasRoles;
    use KioskMethods;
    use Bannable;
    use CausesActivity;
    use TwoFactorAuthMethods;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Method for hashing the user password in the database storage.
     *
     * @param  string $password The given password from the user login.
     * @return void
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Method for uppercase the first character of the username.
     *
     * @param  string $name The username from the user account.
     * @return string
     */
    public function getNameAttribute(string $name): string
    {
        return ucwords($name);
    }


    public function banInformation()
    {
        return $this->bans()->first();
    }
}
