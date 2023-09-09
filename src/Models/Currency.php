<?php

namespace OpenWallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'currency',
        'exchange_buy',
        'exchange_sell',
    ];

    protected $casts = [
        'exchange_buy' => 'decimal:5',
        'exchange_sell' => 'decimal:5',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
