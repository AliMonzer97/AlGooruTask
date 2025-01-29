<?php

namespace App\Models\User;

use App\Enums\FavoriteTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor to get the type as the name of the favorite type.
     *
     * @return string
     */
    public function getTypeNameAttribute(): string
    {
        return FavoriteTypes::from($this->type)->name;
    }
}
