<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Страница профиля
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Получаем историю пожертвований пользователя
        $donations = Donation::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->with('project') // Подгружаем связанные проекты
            ->get();
        
        // Общая сумма пожертвований
        $totalAmount = $donations->sum('amount');
        
        return view('profile.edit', compact('user', 'donations', 'totalAmount'));
    }

    /**
     * Обновление профиля
     */
    public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Обновление имени
    if (isset($validated['name']) && $validated['name'] !== $user->name) {
        $user->name = $validated['name'];
    }

    // Загрузка аватара
    if ($request->hasFile('avatar')) {
        // Удаляем старый аватар, если есть
        if ($user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
        }
        
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->save();

    // Если это AJAX-запрос
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Профиль обновлён! ✓',
            'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
            'name' => $user->name,
        ]);
    }

    return back()->with('success', 'Профиль обновлён! ✓');
}
    /**
     * Удаление профиля
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        $user = Auth::user();
        
        // Удаляем аватар
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }
        
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Профиль удалён');
    }
}