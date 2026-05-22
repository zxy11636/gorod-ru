<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Регистрация (AJAX)
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'passport' => 'required|digits:10|unique:users,passport',
                'email'    => 'required|email|unique:users,email',
                'password' => ['required', 'confirmed', Password::min(6)],
                'role'     => 'required|in:donor,author', // 🔹 ДОБАВИЛИ ВАЛИДАЦИЮ РОЛИ
            ], [
                'passport.required' => 'Введите серию и номер паспорта',
                'passport.digits'   => 'Паспорт должен содержать ровно 10 цифр',
                'passport.unique'   => 'Этот паспорт уже зарегистрирован',
                'email.unique'      => 'Этот email уже занят',
                'password.confirmed'=> 'Пароли не совпадают',
                'password.min'      => 'Пароль должен быть не менее 6 символов',
                'role.required'     => 'Укажите, кем вы хотите быть на платформе', // 🔹 Сообщение об ошибке
                'role.in'           => 'Выбрана некорректная роль', // 🔹 Сообщение об ошибке
            ]);

            $user = User::create([
                'name'     => 'Пользователь', // можно позже добавить поле имени в форму
                'passport' => $validated['passport'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'], // 🔹 ТЕПЕРЬ РОЛЬ БЕРЕТСЯ ИЗ ФОРМЫ, А НЕ ПИШЕТСЯ ЖЕСТКО
                'verified' => false,
            ]);

            Auth::login($user);

            return response()->json([
                'success'  => true,
                'message'  => 'Регистрация успешна!',
                'redirect' => route('home'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * Вход (AJAX)
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($validated)) {
                throw ValidationException::withMessages([
                    'email' => ['Неверный email или пароль'],
                ]);
            }

            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Вход выполнен!',
                'redirect' => route('home'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * Выход
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}