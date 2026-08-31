<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Table;

class TablePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Table $table): bool
    {
        return $user->isAdmin() || $user->id === $table->user_id;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Table $table): bool
    {
        return $user->isAdmin() || $user->id === $table->user_id;
    }
    public function delete(User $user, Table $table): bool
    {
        return $user->isAdmin() || $user->id === $table->user_id;
    }
}
