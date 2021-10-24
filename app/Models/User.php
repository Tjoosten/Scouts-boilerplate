<?php

namespace App\Models;

use App\Models\Traits\ActivityLogging;
use App\Models\Traits\KioskMethods;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

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
    use HasApiTokens;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getNameAttribute(string $name): string
    {
        return ucwords($name);
    }

    public function banInformation(): Model|MorphMany|null
    {
        return $this->bans()->first();
    }
}
