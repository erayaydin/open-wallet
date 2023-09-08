<?php

namespace OpenWallet\UserAccess\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin Builder
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
