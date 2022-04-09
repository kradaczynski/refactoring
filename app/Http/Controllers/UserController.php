<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {}

    public function create(): View
    {
        return view('user.create-edit');
    }

    public function index(): View
    {
        $users = $this->userService->getAll();
        return view('welcome')->with('users', $users);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->userService->save($request);

        return redirect('/');
    }

    public function show(int $id): View
    {
        return $this->edit((int) $id);
    }

    public function edit(int $id): View
    {
        $user = $this->userService->getById($id);

        return view('user.create-edit', compact('user'));
    }

    public function update(int $id, UserRequest $request): RedirectResponse
    {
        $this->userService->update($id, $request->all());

        return redirect('/');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->userService->delete($id);

        return redirect('/');
    }
}
