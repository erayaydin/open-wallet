<?php

namespace OpenWallet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use OpenWallet\Traits\UsesUuid;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Account::class, secondKey: 'source_account_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function rootCategories(): HasMany
    {
        return $this->hasMany(Category::class)->whereNull('parent_id');
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class);
    }
}
