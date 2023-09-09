<?php

namespace OpenWallet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenWallet\Traits\UsesUuid;

class Category extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
        'color',
        'type',
    ];

    public $timestamps = false;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeOnlyParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }
}
