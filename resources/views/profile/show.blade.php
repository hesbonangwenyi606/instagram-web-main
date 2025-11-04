@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 bg-transparent">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto text-center text-md-start mb-4 mb-md-0">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" class="profile-image d-block mx-auto mx-md-0" alt="Profile" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div class="profile-image bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto mx-md-0" style="width: 150px; height: 150px; font-size: 3.5rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-12 col-md">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-center mb-3">
                                    <h2 class="mb-2 mb-md-0 me-3 fs-4">{{ $user->username }}</h2>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('users.follow', $user) }}" method="POST" class="d-inline follow-form" data-user-id="{{ $user->id }}">
                                                @csrf
                                                <button type="submit" class="btn {{ $isFollowing ? 'btn-outline-secondary' : 'btn-primary' }} follow-btn px-4" data-user-id="{{ $user->id }}">
                                                    {{ $isFollowing ? 'Following' : 'Follow' }}
                                                </button>
                                            </form>
                                            <button class="btn btn-outline-secondary">
                                                <i class="bi bi-envelope"></i> Message
                                            </button>
                                        @else
                                            <a href="{{ route('profile.edit', $user) }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-pencil-square"></i> Edit Profile
                                            </a>
                                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                                <i class="bi bi-plus-circle"></i> New Post
                                            </a>
                                        @endif
                                        <button class="btn btn-outline-secondary">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-around justify-content-md-start mb-3">
                                    <div class="text-center me-4">
                                        <span class="d-block fw-bold">{{ $user->posts_count }}</span>
                                        <span class="text-muted">posts</span>
                                    </div>
                                    <div class="text-center me-4">
                                        <span class="d-block fw-bold followers-count">{{ $user->followers_count }}</span>
                                        <span class="text-muted">followers</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="d-block fw-bold">{{ $user->following_count }}</span>
                                        <span class="text-muted">following</span>
                                    </div>
                                </div>
                                
                                @if($user->bio)
                                    <div class="mb-3">
                                        <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                                        <p class="mb-0">{{ $user->bio }}</p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row g-2">
                @if($user->posts->count() > 0)
                    @foreach($user->posts as $post)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('posts.show', $post) }}" class="position-relative d-block text-decoration-none">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     class="img-fluid w-100 rounded" 
                                     style="height: 300px; object-fit: cover;" 
                                     alt="Post"
                                     onerror="this.src='https://via.placeholder.com/300x300?text=Image+Not+Found'">
                                <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center rounded hover-overlay" style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s ease;">
                                    <div class="text-white text-center">
                                        <div class="d-flex justify-content-center gap-3">
                                            <span>
                                                <i class="bi bi-heart-fill"></i> 
                                                <span class="ms-1">{{ $post->likes_count }}</span>
                                            </span>
                                            <span>
                                                <i class="bi bi-chat-fill"></i> 
                                                <span class="ms-1">{{ $post->comments_count }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted py-5">
                        <div class="mb-4">
                            <i class="bi bi-camera" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mb-3">No Posts Yet</h4>
                        @if(auth()->id() === $user->id)
                            <p class="mb-4">Share your first photo and start connecting with others.</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">Share Your First Post</a>
                        @else
                            <p class="mb-0">When {{ $user->username }} shares photos and videos, you'll see them here.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .hover-overlay:hover {
        opacity: 1 !important;
    }
    
    .profile-stats {
        border-top: 1px solid #dbdbdb;
        border-bottom: 1px solid #dbdbdb;
    }
    
    @media (max-width: 768px) {
        .profile-image {
            width: 120px !important;
            height: 120px !important;
            font-size: 2.5rem !important;
        }
        
        .profile-stats .col {
            padding: 0.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .profile-image {
            width: 100px !important;
            height: 100px !important;
            font-size: 2rem !important;
        }
        
        .btn-group-profile .btn {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postLinks = document.querySelectorAll('.hover-overlay').forEach(overlay => {
            overlay.parentElement.addEventListener('mouseenter', function() {
                overlay.style.opacity = '1';
            });
            
            overlay.parentElement.addEventListener('mouseleave', function() {
                overlay.style.opacity = '0';
            });
        });
    });
</script>
@endsection