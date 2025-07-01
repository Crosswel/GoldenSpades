<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Produto;

class ProdutoPolicy
{
    public function viewAny(User $user)
    {
        return $user->usertype === 0;
    }

    public function view(User $user, Produto $produto)
    {
        return $user->usertype === 0;
    }

    public function create(User $user)
    {
        return $user->usertype === 0;
    }

    public function update(User $user, Produto $produto)
    {
        return $user->usertype === 0;
    }

    public function delete(User $user, Produto $produto)
    {
        return $user->usertype === 0;
    }
}
