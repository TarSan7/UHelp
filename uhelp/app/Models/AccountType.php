<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AccountType extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ACCOUNT_TYPE_ADMIN        = 'admin';
    public const ACCOUNT_TYPE_VOLUNTEER    = 'volunteer';
    public const ACCOUNT_TYPE_VICTIM       = 'victim';
    public const ACCOUNT_TYPE_ADMIN_ID     = 1;
    public const ACCOUNT_TYPE_VOLUNTEER_ID = 2;
    public const ACCOUNT_TYPE_VICTIM_ID    = 3;

    public const ACCOUNT_TYPES = [
        self::ACCOUNT_TYPE_ADMIN_ID     => self::ACCOUNT_TYPE_ADMIN,
        self::ACCOUNT_TYPE_VOLUNTEER_ID => self::ACCOUNT_TYPE_VOLUNTEER,
        self::ACCOUNT_TYPE_VICTIM_ID    => self::ACCOUNT_TYPE_VICTIM,
    ];

    public const REGISTER_ACCOUNT_TYPES = [
        self::ACCOUNT_TYPE_VOLUNTEER_ID => self::ACCOUNT_TYPE_VOLUNTEER,
        self::ACCOUNT_TYPE_VICTIM_ID    => self::ACCOUNT_TYPE_VICTIM,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

}
