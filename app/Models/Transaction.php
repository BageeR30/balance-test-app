<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'description',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function balance(): BelongsTo
    {
        return $this->belongsTo(Balance::class, 'user_id');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query
            ->when(
                $search,
                fn (Builder $q, string $search): Builder => $q->whereFullText(
                    'description',
                    "+$search*",
                    ['mode' => 'boolean'],
                ),
            );
    }
}
