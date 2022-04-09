<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository extends AbstractRepository
{
    public function __construct(protected User $user)
    {
        $this->model = $user;
    }

    public function getByEmail(string $email): Collection
    {
        return $this->model->where('email', $email)->get();
    }
}
