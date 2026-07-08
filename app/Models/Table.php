<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

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
