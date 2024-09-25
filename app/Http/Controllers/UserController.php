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
        // Валідація запиту
        $request->validate([
            'current_user_id' => 'required|exists:users,user_id', // Перевірка наявності користувача
        ]);

        // Зберігаємо поточного користувача в сесії або іншому місці, де вам потрібно
        $currentUserId = $request->input('current_user_id');
        
        // Збережіть ID поточного користувача в сесії
        session(['current_user_id' => $currentUserId]);

        // Повертаємо назад з повідомленням про успіх
        return redirect()->route('users.index')->with('success', 'Поточний користувач встановлено успішно.');
    }

    // Перегляд усіх користувачів
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

        //$users = $query->paginate(10); // Або інше число для пагінації
        $users = $query->get();

        return view('users.index', compact('users'));
    }

    // Відображення форми для створення нового користувача
    public function create()
    {
        return view('users.create');
    }

    // Збереження нового користувача
    public function store(Request $request)
    {
         // Додай логування для відслідковування
        Log::info('User creation started');

        $request->validate([
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
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

    // Відображення форми для редагування користувача
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->user_id . ',user_id',// Оновлене правило для username
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        // Оновлюємо дані користувача, якщо вони були надані
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            // Якщо пароль був введений, оновлюємо його, інакше залишаємо старий пароль
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Користувача оновлено успішно');
    }

    // Видалення користувача
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
