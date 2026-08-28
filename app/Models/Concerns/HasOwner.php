<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

trait HasOwner
{
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }
        return $query->where('user_id', $user->id);
    }
}
