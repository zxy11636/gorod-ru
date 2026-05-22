<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Создание комментария
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'project_id' => $validated['project_id'],
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        // Если это AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $comment->load('user');
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('d.m.Y'),
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar,
                    ],
                    'likes' => 0,
                    'dislikes' => 0,
                ]
            ]);
        }

        return back()->with('success', 'Комментарий добавлен!');
    }

    /**
     * Обновление комментария
     */
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && Auth::user()?->role !== 'admin') {
            abort(403, 'Нет прав');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $validated['content'],
            'edited_at' => now(),
        ]);

        return back()->with('success', 'Комментарий обновлён!');
    }

    /**
     * Удаление комментария
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && Auth::user()?->role !== 'admin') {
            abort(403, 'Нет прав');
        }

        $comment->delete();

        return back()->with('success', 'Комментарий удалён!');
    }

    /**
     * Лайк / Дизлайк
     */
    public function vote(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        if ($validated['type'] === 'like') {
            $comment->increment('likes_count');
        } else {
            $comment->increment('dislikes_count');
        }

        return response()->json([
            'success' => true,
            'likes' => $comment->likes_count,
            'dislikes' => $comment->dislikes_count,
        ]);
    }
}