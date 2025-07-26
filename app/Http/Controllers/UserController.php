<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhere('name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%");
                });
            })
            ->paginate(10);

        return view('users.index', [
            'pageTitle' => 'Usuários',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.form', [
            'pageTitle' => 'Novo usuário',
            'user' => User::make(),
            'action' => route('users.store'),
            'method' => 'POST',
            'roles' => UserRoleEnum::asSelectArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('users.index')
            ->with('status', ['class' => 'success', 'message' => 'Usuário criado com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $city = City::find($user->city_id);
        $state = State::find($city->state_id);

        return view('users.form', [
            'pageTitle' => 'Editar usuário',
            'user' => $user,
            'action' => route('users.update', $user),
            'method' => 'PUT',
            'roles' => UserRoleEnum::asSelectArray(),
            'city' => $city->name,
            'state' => "$state->name ($state->acronym)"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('status', ['class' => 'success', 'message' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('status', ['class' => 'success', 'message' => 'Usuário removido com sucesso!']);
    }
}
