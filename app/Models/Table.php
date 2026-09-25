<?php

namespace App\Models;

use App\Models\Concerns\HasOwner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Guest> $guests
 * @property-read int|null $guests_count
 * @property-read User $user
 *
 * @method static \Database\Factories\TableFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table visibleTo(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Table whereUserId($value)
 *
 * @mixin \Eloquent
 */
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
