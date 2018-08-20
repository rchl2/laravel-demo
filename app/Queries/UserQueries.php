<?php

namespace App\Queries;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

final class UserQueries
{
    // Status of account
    const BLOCK = 'BLOCK';
    const INACTIVE = 'INACTIVE';
    
    /**
     * Get latest users, paginate results.
     */
    public static function latestPaginated(int $perPage = 15) : Paginator
    {
        return User::latest()
            ->simplePaginate($perPage);
    }

    /**
     * Search for user ("accounts") with given value.
     * Paginate results as return and appends to search.
     */
    public static function searchAccounts(string $value, int $per_page = 15) : Paginator
    {
        return User::where(function ($query) use ($value) {
                $query->where('login', 'LIKE', '%'.$value.'%');
                $query->orWhere('email', 'LIKE', '%'.$value.'%');
                $query->orWhere('web_ip', 'LIKE', '%'.$value.'%');
            })
            ->simplePaginate($per_page)
            ->appends(['search' => $value]);
    }
    
    /**
     * Find users with this IP address.
     */
    public static function getWithIpAddress(string $ip) : Collection
    {
        return User::where('web_ip', $ip)
            ->select(['id', 'login', 'last_successful_login', 'web_admin', 'cash'])
            ->orderBy('cash', 'desc')
            ->get();
    }

    /**
     * Find user with this e-mail address.
     */
    public static function getWithEmail(string $email): ?User
    {
        return User::where('email', $email)
            ->select(['id', 'login', 'email', 'pin'])
            ->first();
    }

    /**
     * Find users with expired bans.
     */
    public static function getWithExpiredBans(): Collection
    {
        return User::where(function ($query) {
                $query->where('status', '=', self::BLOCK);
                $query->where('availDt', '<=', Carbon::now('Europe/Warsaw')->toDateTimeString());
            })
            ->select(['id', 'login', 'email', 'status', 'blocked_by', 'blocked_desc', 'availDt', 'web_ip'])
            ->get();
    }

    /**
     * Count users with expired bans.
     */
    public static function countWithExpiredBans(): int
    {
        return User::where(function ($query) {
                $query->where('status', '=', self::BLOCK);
                $query->where('availDt', '<=', Carbon::now()->toDateTimeString());
            })
            ->count();
    }

    /**
     * Find user by ID.
     */
    public static function findById(int $id): ?User
    {
        return User::where('id', $id)
            ->select(['id', 'login', 'email', 'pin', 'cash'])
            ->first();
    }

    /**
     * Find user by login.
     */
    public static function findByLogin(string $login): ?User
    {
        return User::where('login', $login)
            ->select(['id', 'login', 'status', 'email', 'pin', 'cash'])
            ->first();
    }

    /**
     * Find user by login to verify account.
     */
    public static function findToVerifyByLogin(string $login): ?User
    {
        return User::where(function ($query) use ($login) {
                $query->where('login', $login);
                $query->where('status', self::INACTIVE);
            })
            ->select(['id', 'login', 'status', 'email', 'pin', 'verification_token'])
            ->first();
    }

    /**
     * Find user by login to verify email change on account.
     */
    public static function findToVerifyEmailChange(string $login): ?User
    {
        return User::where(function ($query) use ($login) {
                $query->where('login', $login);
                $query->whereNotNull('new_email_token');
            })
            ->select(['id', 'login', 'new_email_token', 'new_email'])
            ->first();
    }
}
