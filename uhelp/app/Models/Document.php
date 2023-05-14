<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Document extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const APPROVED_STATUS = 'Approved';
    public const DECLINED_STATUS = 'Declined';
    public const SENT_STATUS     = 'Sent';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'account_type_id',
        'user_id',
        'document',
        'status',
    ];

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    /**
     * @return HasOne
     */
    public function accountType()
    {
        return $this->hasOne('app\Models\AccountType');
    }
}
