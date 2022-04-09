<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;

final class UserService
{
    public function __construct(private UserRepository $UserRepository)
    {}

    public function getAll(): Collection
    {
        return $this->UserRepository->getAll();
    }

    public function save(UserRequest $request): void
    {
        $this->UserRepository->save($request->only(['name', 'email', 'password']));
    }

    public function getById(int $id): Model
    {
        $user = $this->UserRepository->find($id);

        return $user ? $user : throw new Exception('User doesnt exist');
    }

    public function update(int $id, array $data): void
    {
        $this->UserRepository->update($id, [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function delete(int $id): void
    {
        $this->UserRepository->destroy($id);
    }
}
