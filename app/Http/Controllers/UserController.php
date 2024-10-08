<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 

class UserController extends Controller
{
    public function setCurrent(Request $request)
    {
        $request->validate([
            'current_user_id' => [
                'required',
                'exists:users,user_id',
            ]
        ]);

        // Збереження поточного користувача в сесії
        $currentUserId = $request->input('current_user_id');
        session(['current_user_id' => $currentUserId]);

        return redirect()->route('users.index')->with('success', 'Поточний користувач встановлено успішно.');
    }

    public function index(Request $request)
    {
        $query = User::query();

        // Пошук за username
        if ($request->filled('search')) {
            $query->where('username', 'like', '%' . $request->input('search') . '%');
        }

        // Сортування
        if ($request->filled('sort')) {
            $query->orderBy('username', $request->input('sort'));
        }

        // Фільтрація за роллю
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        //$users = $query->paginate(10);
        $users = $query->get();

        return view('users.index', compact('users'));
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        Log::info('User creation started');

        $request->validate([
            'username' => [
                'required',
                'unique:users',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
            'role' => [
                'required',
                'in:admin,user',
            ],
        ]);        

        Log::info('Validation passed');

        try {
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
    
            Log::info('User created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withErrors('Error creating user');
        }

        Log::info('Redirecting to users.index');

        return redirect()->route('users.index')->with('success', 'Користувача створено успішно');
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => [
                'required',
                'unique:users,username,' . $user->user_id . ',user_id',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->user_id . ',user_id',
            ],
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
            ],
            'role' => [
                'required',
                'in:admin,user',
            ],
        ]);        

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Користувача оновлено успішно');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Користувача видалено');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

}
