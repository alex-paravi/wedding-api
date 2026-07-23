<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Guest extends Model
{
    use HasFactory;


    /**
     * Атрибуты, которые можно заполнять массово (Белый список).
     * Теперь у Laravel есть официальное разрешение сохранять эти поля в базу.
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'side',
        'category',
        'status',
        'table_id',
        'invitation_token',
        'dietary_preferences',
    ];

    /**
     * Связь: Гость принадлежит пользователю (создателю).
     * Это позволит в коде легко получать автора: $guest->user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь: Гость сидит за определённым столом (или ни за каким, если null).
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
