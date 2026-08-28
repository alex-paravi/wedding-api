<?php

namespace App\Models;

use App\Models\Concerns\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Table extends Model
{
    use HasFactory, HasOwner;

    // Разрешаем заполнять эти поля при создании/обновлении
    protected $fillable = ['name', 'capacity', 'user_id'];

    /**
     * Связь: Стол принадлежит конкретному пользователю.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь: За одним столом может сидеть много гостей.
     */
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
