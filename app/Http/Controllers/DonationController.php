<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Сохранение пожертвования (AJAX или обычная форма)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:100',
            'comment' => 'nullable|string|max:500',
        ]);

        $project = Project::findOrFail($validated['project_id']);

        // 🔹 Здесь должна быть интеграция с платёжной системой
        // Пока просто создаём запись со статусом "completed" для демо

        DB::transaction(function () use ($validated, $project) {
            // Создаём пожертвование
            $donation = Donation::create([
                'user_id' => auth()->id(),
                'project_id' => $validated['project_id'],
                'amount' => $validated['amount'],
                'comment' => $validated['comment'] ?? null,
                'status' => 'completed', // В реальном проекте: 'pending' до подтверждения оплаты
                'payment_id' => 'demo_' . uniqid(),
            ]);

            // Обновляем сумму сбора в проекте
            $project->increment('current_amount', $validated['amount']);
        });

        // Если это AJAX-запрос
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Спасибо за поддержку! 🎉',
                'redirect' => route('project.show', $validated['project_id']),
            ]);
        }

        // Обычный редирект
        return redirect()->route('project.show', $validated['project_id'])
            ->with('success', 'Спасибо за поддержку! 🎉');
    }
}