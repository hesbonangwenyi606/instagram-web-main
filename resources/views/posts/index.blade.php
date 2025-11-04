@extends('layouts.app')

@section('content')
<div class="container">
    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="post-card mb-4">
                <div class="post-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none d-flex align-items-center">
                            @if($post->user->image)
                                <img src="{{ asset('storage/' . $post->user->image) }}" 
                                     class="nav-profile-image me-2" 
                                     alt="{{ $post->user->username }}"
                                     style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div class="nav-profile-image bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white me-2" 
                                     style="width: 32px; height: 32px; font-size: 1rem;">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <strong class="text-dark">{{ $post->user->username }}</strong>
                                @if($post->location)
                                    <div class="text-muted small">{{ $post->location }}</div>
                                @endif
                            </div>
                        </a>
                    </div>
                    
                    @if(auth()->id() !== $post->user_id)
                        <div class="dropdown">
                            <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('users.follow', $post->user) }}" method="POST" class="follow-form" data-user-id="{{ $post->user->id }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            @if($post->user->isFollowing(auth()->user()))
                                                <i class="bi bi-person-dash me-2"></i>Unfollow
                                            @else
                                                <i class="bi bi-person-plus me-2"></i>Follow
                                            @endif
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2"></i>Report</a></li>
                            </ul>
                        </div>
                    @else
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
                
                <img src="{{ asset('storage/' . $post->image) }}" 
                     class="post-image w-100" 
                     alt="Post Image" 
                     style="aspect-ratio: 1; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/600x600?text=Image+Not+Found'">
                
                <div class="post-actions">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex">
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline like-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <button type="submit" class="action-btn like-btn {{ $post->isLikedBy(auth()->user()) ? 'text-danger liked' : 'text-dark' }}" data-post-id="{{ $post->id }}">
                                    <i class="bi bi-heart{{ $post->isLikedBy(auth()->user()) ? '-fill' : '' }}"></i>
                                </button>
                            </form>
                            <button type="button" class="action-btn text-dark comment-btn toggle-comments me-2" data-post-id="{{ $post->id }}">
                                <i class="bi bi-chat"></i>
                            </button>
                            <button class="action-btn text-dark me-2">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                        <button class="action-btn text-dark">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>
                    
                    <div class="mb-2">
                        <strong class="likes-count" data-post-id="{{ $post->id }}">{{ $post->likes_count }}</strong> likes
                    </div>
                    
                    <div class="mb-2">
                        <strong>{{ $post->user->username }}</strong> 
                        <span class="post-caption">{{ $post->caption }}</span>
                        @if($post->caption && strlen($post->caption) > 150)
                            <span class="d-none full-caption">{{ $post->caption }}</span>
                            <a href="javascript:void(0)" class="text-muted small see-more">more</a>
                        @endif
                    </div>
                    
                    @if($post->comments_count > 0)
                        <div class="mb-2">
                            <button type="button" class="btn btn-link p-0 text-muted text-decoration-none toggle-comments" data-post-id="{{ $post->id }}">
                                View all {{ $post->comments_count }} comments
                            </button>
                        </div>
                        
                        @foreach($post->comments->take(2) as $comment)
                            <div class="mb-1 comment-preview">
                                <strong>{{ $comment->user->username }}</strong> 
                                <span class="comment-text">{{ $comment->content }}</span>
                                @if(strlen($comment->content) > 100)
                                    <span class="d-none full-comment">{{ $comment->content }}</span>
                                    <a href="javascript:void(0)" class="text-muted small see-more-comment">more</a>
                                @endif
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="text-muted small mt-2">
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
                
                <div class="comments-section" data-post-id="{{ $post->id }}" id="comments-section-{{ $post->id }}">
                    <hr class="my-0">
                    <div class="p-3">
                        <div id="comments-list-{{ $post->id }}" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                            @forelse($post->comments->sortByDesc('created_at') as $comment)
                                <div class="comment-item d-flex mb-3">
                                    <div class="flex-shrink-0 me-2">
                                        <a href="{{ route('profile.show', $comment->user) }}" class="text-decoration-none">
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
                                        </a>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="bg-light rounded p-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <a href="{{ route('profile.show', $comment->user) }}" class="text-decoration-none text-dark">
                                                        <strong>{{ $comment->user->username }}</strong>
                                                    </a>
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
                                       class="form-control border-0 comment-input" 
                                       placeholder="Add a comment..." 
                                       required
                                       autocomplete="off">
                                <button type="submit" class="btn btn-link text-primary text-decoration-none">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-camera" style="font-size: 3rem; color: #8e8e8e;"></i>
            </div>
            <h4 class="text-muted">No Posts Yet</h4>
            <p class="text-muted">When people share posts, you'll see them here.</p>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3">Share Your First Post</a>
            @endauth
        </div>
    @endif
</div>

<style>
    .post-caption, .comment-text {
        word-break: break-word;
    }
    
    .see-more, .see-more-comment {
        cursor: pointer;
        color: #8e8e8e !important;
    }
    
    .see-more:hover, .see-more-comment:hover {
        color: #262626 !important;
    }
    
    .comments-section {
        border-top: 1px solid #efefef;
    }
    
    .post-card {
        background: white;
        border: 1px solid #dbdbdb;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .post-header {
        padding: 14px 16px;
        border-bottom: 1px solid #efefef;
    }
    
    .post-actions {
        padding: 8px 16px;
    }
    
    .action-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        padding: 8px;
        margin-right: 8px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .post-card {
            border-radius: 0;
            border-left: none;
            border-right: none;
            margin-bottom: 1rem;
        }
        
        .post-header {
            padding: 12px;
        }
        
        .post-actions {
            padding: 8px 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.see-more').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const captionElement = this.previousElementSibling;
                const fullCaption = this.previousElementSibling;
                const shortCaption = this.parentElement.querySelector('.post-caption');
                
                if (shortCaption) {
                    shortCaption.textContent = fullCaption.textContent;
                }
                this.style.display = 'none';
            });
        });

        document.querySelectorAll('.see-more-comment').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const commentElement = this.parentElement.querySelector('.comment-text');
                const fullComment = this.previousElementSibling;
                
                if (commentElement && fullComment) {
                    commentElement.textContent = fullComment.textContent;
                }
                this.style.display = 'none';
            });
        });

        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('follow-form')) {
                e.preventDefault();
                const form = e.target;
                const button = form.querySelector('button');
                const userId = form.dataset.userId;
                form.submit();
            }
        });

        const postCards = document.querySelectorAll('.post-card');
        postCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection