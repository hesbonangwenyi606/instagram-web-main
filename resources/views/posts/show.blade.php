@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        @if($post->user->image)
                            <img src="{{ asset('storage/' . $post->user->image) }}" class="nav-profile-image me-2" alt="Profile" style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
                        @else
                            <div class="nav-profile-image bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px; font-size: 1rem;">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <strong>
                                <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none text-dark">
                                    {{ $post->user->username }}
                                </a>
                            </strong>
                        </div>
                    </div>
                    
                    @if($post->user_id === auth()->id())
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="bi bi-trash me-2"></i>Delete Post
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
                
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid w-100" alt="Post Image" style="max-height: 600px; object-fit: cover;">
                
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex">
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline like-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <button type="submit" class="action-btn like-btn {{ $post->isLikedBy(auth()->user()) ? 'text-danger liked' : 'text-dark' }}" data-post-id="{{ $post->id }}">
                                    <i class="bi bi-heart{{ $post->isLikedBy(auth()->user()) ? '-fill' : '' }}" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>
                            <button type="button" class="action-btn text-dark comment-btn toggle-comments me-2" data-post-id="{{ $post->id }}" style="font-size: 1.5rem;">
                                <i class="bi bi-chat"></i>
                            </button>
                            <button class="action-btn text-dark me-2" style="font-size: 1.5rem;">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                        <button class="action-btn text-dark" style="font-size: 1.5rem;">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <strong class="likes-count" data-post-id="{{ $post->id }}">{{ $post->likes->count() }}</strong> likes
                    </div>
                    
                    
                    <div class="mb-3">
                        <p class="mb-0">
                            <strong>{{ $post->user->username }}</strong> 
                            <span class="post-caption">{{ $post->caption }}</span>
                        </p>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    
                    <div class="comments-section show" data-post-id="{{ $post->id }}" id="comments-section-{{ $post->id }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <span class="comments-count-{{ $post->id }}">{{ $post->comments->count() }}</span> 
                                <span class="comments-count-text-{{ $post->id }}">{{ $post->comments->count() === 1 ? 'comment' : 'comments' }}</span>
                            </h6>
                        </div>
                        
                        <div id="comments-list-{{ $post->id }}" class="mb-3" style="max-height: 400px; overflow-y: auto;">
                            @forelse($post->comments->sortByDesc('created_at') as $comment)
                                <div class="comment-item d-flex mb-3">
                                    <div class="flex-shrink-0 me-2">
                                        @if($comment->user->image)
                                            <img src="{{ asset('storage/' . $comment->user->image) }}" 
                                                 class="rounded-circle" 
                                                 style="width: 32px; height: 32px; object-fit: cover;" 
                                                 alt="{{ $comment->user->name }}">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="bg-light rounded p-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <strong>{{ $comment->user->username }}</strong>
                                                    <p class="mb-1 mt-1">{{ $comment->content }}</p>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                @if($comment->user_id === auth()->id())
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Are you sure?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3 no-comments">No comments yet. Be the first to comment!</p>
                            @endforelse
                        </div>
                        
                        <form class="comment-form-ajax" data-post-id="{{ $post->id }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control border-top comment-input" 
                                       placeholder="Add a comment..." 
                                       required
                                       autocomplete="off"
                                       style="border-radius: 0; border-left: none; border-right: none;">
                                <button type="submit" class="btn btn-link text-primary text-decoration-none" style="border: none;">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mb-4">
                <i class="bi bi-arrow-left"></i> Back to Feed
            </a>
        </div>
    </div>
</div>

<style>
    .post-caption {
        word-break: break-word;
    }
    
    .comments-section {
        border-top: 1px solid #efefef;
    }
    
    #comments-list-{{ $post->id }}::-webkit-scrollbar {
        width: 4px;
    }
    
    #comments-list-{{ $post->id }}::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #comments-list-{{ $post->id }}::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    #comments-list-{{ $post->id }}::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentInput = document.querySelector('.comment-input');
        if (commentInput) {
            setTimeout(() => {
                commentInput.focus();
            }, 100);
        }

        if (window.location.hash === '#comments') {
            const commentsSection = document.querySelector('.comments-section');
            if (commentsSection) {
                commentsSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>
@endsection
@endsection