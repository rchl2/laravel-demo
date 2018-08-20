<?php

namespace App\Models;

use Carbon\Carbon;
use App\Helpers\HasTimestamps;
use App\Relations\UserRelations;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AccountResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    use UserRelations, HasTimestamps, Notifiable;

    // Types of account
    const USER = 0;
    const ADMIN = 1;

    // Statuses of account
    const OK = 'OK';
    const BLOCK = 'BLOCK';
    const INACTIVE = 'INACTIVE';

    /**
     * The database table used by the model.
     */
    protected $table = 'account';

    /**
     * The connection name for the model.
     */
    protected $connection = 'account';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'login',
        'password',
        'pin',
        'social_id',
        'email',
        'status',
        'blocked_by',
        'blocked_desc',
        'root',
        'web_admin',
        'web_ip',
        'last_successful_login',
        'session_id',
        'verification_token',
        'new_email',
        'new_email_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes are dates.
     */
    protected $dates = [
        'last_successful_login',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function login(): string
    {
        return $this->login;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function pin(): string
    {
        return $this->pin;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function blocked_by(): string
    {
        return $this->blocked_by;
    }

    public function blocked_desc(): string
    {
        return $this->blocked_desc;
    }

    public function social_id(): string
    {
        return $this->social_id;
    }

    public function web_admin(): int
    {
        return $this->web_admin;
    }

    public function root(): bool
    {
        return $this->root;
    }

    public function web_ip(): ?string
    {
        return $this->web_ip;
    }

    public function last_successful_login(): Carbon
    {
        return $this->last_successful_login;
    }

    public function session_id(): ?string 
    {
        return $this->session_id;
    }

    public function verification_token(): ?string
    {
        return $this->verification_token;
    }

    public function new_email(): ?string
    {
        return $this->new_email;
    }

    public function new_email_token(): ?string
    {
        return $this->new_email_token;
    }
    
    public function isAdmin(): bool
    {
        return self::ADMIN === $this->web_admin();
    }

    public function isInactive(): bool
    {
        return self::INACTIVE === $this->status();
    }

    public function isRoot(): bool
    {
        return true === $this->root();
    }

    public function isBlocked(): bool
    {
        return ! is_null($this->blocked_by);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AccountResetPassword($token));
    }
    
    /**
    * Overrides the method to ignore the remember token.
    */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
}
