@php
    $avatar = $comment->user->avatar ? Storage::url($comment->user->avatar) : null;
    $initials = strtoupper(substr($comment->user->name ?? 'A', 0, 1)) . 
                strtoupper(substr(strstr($comment->user->name ?? ' ', ' '), 1, 1));
@endphp

<div class="comment-item" id="comment-{{ $comment->id }}" data-depth="{{ $depth }}">
    <div class="comment-header">
        @if($avatar)
            <img src="{{ $avatar }}" alt="{{ $comment->user->name }}" class="comment-avatar">
        @else
            <div class="comment-avatar" style="background: linear-gradient(135deg, #3B82F6, #60A5FA);">
                {{ $initials }}
            </div>
        @endif
        <div>
            <div class="comment-author">{{ $comment->user->name ?? 'Аноним' }}</div>
            <div class="comment-date" style="font-size: 12px; color: #94A3B8;">
                {{ $comment->created_at->format('d.m.Y') }}
                @if($comment->edited_at) <span style="color: #64748B;">(изменено)</span> @endif
            </div>
        </div>
    </div>
    
    <div class="comment-text" id="content-{{ $comment->id }}">
        {{ $comment->content }}
    </div>
    
    <div class="comment-actions">
        <button class="comment-action like" onclick="voteComment({{ $comment->id }}, 'like')">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M2 8L6 4V8H10L8 12V8H2Z" stroke="#94A3B8" stroke-width="1.2"/>
            </svg>
            <span id="likes-{{ $comment->id }}">{{ $comment->likes_count }}</span>
        </button>
        <button class="comment-action dislike" onclick="voteComment({{ $comment->id }}, 'dislike')">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M14 8L10 12V8H6L8 4V8H14Z" stroke="#94A3B8" stroke-width="1.2"/>
            </svg>
            <span id="dislikes-{{ $comment->id }}">{{ $comment->dislikes_count }}</span>
        </button>
        
        @auth
            @if($comment->canEdit(auth()->id()))
                <button class="comment-action" onclick="editComment({{ $comment->id }})">✎</button>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить комментарий?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="comment-action" style="color: #EF4444;">🗑</button>
                </form>
            @endif
            @if($depth < 2)
                <button class="comment-action" onclick="replyToComment({{ $comment->id }})">Ответить</button>
            @endif
        @endauth
    </div>

    <!-- Ответы -->
    @if($comment->replies->count() > 0)
        <div class="comment-replies" style="margin-left: {{ min($depth + 1, 2) * 24 }}px; margin-top: 16px;">
            @foreach($comment->replies as $reply)
                @include('projects.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>