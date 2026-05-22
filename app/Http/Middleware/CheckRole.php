<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Проверяем, авторизован ли пользователь
        if (!auth()->check()) {
            return redirect()->route('home'); // Если не вошел — на главную
        }

        // 2. Проверяем роль (должно быть admin)
        if (auth()->user()->role !== 'admin') {
            // Если роль не admin — запрещаем доступ (ошибка 403)
            // Можно сделать редирект на главную, если хочешь:
            // return redirect()->route('home')->with('error', 'У вас нет прав администратора');
            abort(403, 'У вас нет прав администратора.');
        }

        // 3. Если всё ок — пропускаем дальше
        return $next($request);
    }
}