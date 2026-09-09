<?php

namespace App\Models;

use App\Models\Concerns\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $phone
 * @property string $side
 * @property string $category
 * @property string $status
 * @property int|null $table_id
 * @property string|null $invitation_token
 * @property string|null $dietary_preferences
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Table|null $table
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\GuestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest visibleTo(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereDietaryPreferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereInvitationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guest whereUserId($value)
 * @mixin \Eloquent
 */
class Guest extends Model
{
    use HasFactory, HasOwner;

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
