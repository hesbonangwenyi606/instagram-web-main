<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Instagram</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --instagram-blue: #0095f6;
            --instagram-dark: #262626;
            --instagram-gray: #8e8e8e;
            --instagram-light-gray: #dbdbdb;
            --instagram-bg: #fafafa;
        }
        
        body {
            background-color: var(--instagram-bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-top: 60px;
        }
        
        .navbar {
            background-color: white;
            border-bottom: 1px solid var(--instagram-light-gray);
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Billabong', cursive;
            font-size: 1.5rem;
            color: var(--instagram-dark) !important;
        }
        
        .nav-link {
            color: var(--instagram-dark) !important;
            padding: 0.5rem !important;
        }
        
        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .nav-profile-image {
            width: 24px;
            height: 24px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .post-card {
            background: white;
            border: 1px solid var(--instagram-light-gray);
            border-radius: 3px;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .post-header {
            padding: 1rem;
            border-bottom: 1px solid #efefef;
        }
        
        .post-image {
            width: 100%;
            object-fit: cover;
        }
        
        .post-actions {
            padding: 0.5rem 1rem;
        }
        
        .action-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            padding: 0.5rem;
            margin-right: 0.5rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .like-btn.liked {
            color: #ed4956 !important;
            animation: likeAnimation 0.45s ease-in-out;
        }

        @keyframes likeAnimation {
            0% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        .comments-section {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out;
        }

        .comments-section.show {
            max-height: 500px;
        }

        .comment-item {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .follow-btn {
            min-width: 100px;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 50px;
            }
            
            .navbar {
                height: 50px;
                padding: 0 1rem;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .post-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
                margin-bottom: 1rem;
            }
            
            .profile-image {
                width: 120px;
                height: 120px;
            }

            .action-btn {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                height: 45px;
            }
            
            .profile-image {
                width: 100px;
                height: 100px;
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <style>
        @font-face {
            font-family: 'Billabong';
            src: local('Billabong'), url('https://fonts.cdnfonts.com/s/13949/Billabong.woff') format('woff');
        }
    </style>
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('posts.index') }}">
                    Instagram
                </a>
                
                <div class="navbar-nav ms-auto flex-row">
                    <a class="nav-link" href="{{ route('posts.index') }}" title="Home">
                        <i class="bi bi-house-door-fill"></i>
                    </a>
                    <a class="nav-link" href="{{ route('posts.create') }}" title="Create">
                        <i class="bi bi-plus-square"></i>
                    </a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->image)
                                <img src="{{ asset('storage/' . Auth::user()->image) }}" class="nav-profile-image" alt="Profile">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('profile.show', Auth::user()) }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()) }}">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Log Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <main class="container py-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <script>
        class InstagramApp {
            constructor() {
                this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.initEventListeners();
            }

            initEventListeners() {
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.like-btn') || e.target.closest('.like-form')) {
                        this.handleLike(e);
                    }
                });

                document.addEventListener('click', (e) => {
                    if (e.target.closest('.comment-btn') || e.target.closest('.toggle-comments')) {
                        this.toggleComments(e);
                    }
                });

                document.addEventListener('click', (e) => {
                    if (e.target.closest('.follow-btn') || e.target.closest('.follow-form')) {
                        this.handleFollow(e);
                    }
                });

                document.addEventListener('submit', (e) => {
                    if (e.target.classList.contains('comment-form-ajax')) {
                        e.preventDefault();
                        this.submitComment(e.target);
                    }
                });
            }

            async handleLike(e) {
                e.preventDefault();
                const form = e.target.closest('form');
                const button = form.querySelector('.like-btn') || form;
                
                if (!form) return;

                const postId = form.dataset.postId;
                const isLiked = button.classList.contains('liked');
                
                try {
                    button.classList.add('loading');
                    
                    const response = await fetch(`/posts/${postId}/like-ajax`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        button.classList.toggle('liked', data.liked);
                        button.classList.toggle('text-danger', data.liked);
                        button.classList.toggle('text-dark', !data.liked);
                        
                        const icon = button.querySelector('i');
                        if (icon) {
                            icon.className = data.liked ? 'bi bi-heart-fill' : 'bi bi-heart';
                        }
                        
                        const likesCountElement = document.querySelector(`.likes-count[data-post-id="${postId}"]`);
                        if (likesCountElement) {
                            likesCountElement.textContent = data.likes_count;
                        }
                        
                        if (data.liked) {
                            button.classList.add('liked');
                            setTimeout(() => button.classList.remove('liked'), 450);
                        }
                    }
                } catch (error) {
                    console.error('Error liking post:', error);
                    form.submit();
                } finally {
                    button.classList.remove('loading');
                }
            }

            toggleComments(e) {
                e.preventDefault();
                const target = e.target.closest('.toggle-comments') || e.target.closest('.comment-btn');
                const postId = target.dataset.postId;
                const commentsSection = document.querySelector(`.comments-section[data-post-id="${postId}"]`);
                
                if (commentsSection) {
                    commentsSection.classList.toggle('show');
                    
                    if (commentsSection.classList.contains('show')) {
                        const commentInput = commentsSection.querySelector('.comment-input');
                        setTimeout(() => commentInput?.focus(), 300);
                    }
                }
            }

            async handleFollow(e) {
                e.preventDefault();
                const form = e.target.closest('form');
                const button = form.querySelector('.follow-btn') || form;
                
                if (!form) return;

                const userId = form.dataset.userId;
                
                try {
                    button.classList.add('btn-loading', 'loading');
                    
                    const response = await fetch(`/users/${userId}/follow-ajax`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        if (data.following) {
                            button.textContent = 'Following';
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-outline-secondary');
                        } else {
                            button.textContent = 'Follow';
                            button.classList.remove('btn-outline-secondary');
                            button.classList.add('btn-primary');
                        }
                        
                        const followersCountElement = document.querySelector('.followers-count');
                        if (followersCountElement) {
                            followersCountElement.textContent = data.followers_count;
                        }
                    }
                } catch (error) {
                    console.error('Error following user:', error);
                    form.submit();
                } finally {
                    button.classList.remove('btn-loading', 'loading');
                }
            }

            async submitComment(form) {
                const postId = form.dataset.postId;
                const input = form.querySelector('.comment-input');
                const content = input.value.trim();
                
                if (!content) return;

                try {
                    form.classList.add('loading');
                    input.disabled = true;
                    
                    const response = await fetch(`/posts/${postId}/comments-ajax`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ content: content })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        this.addCommentToDOM(data.comment, postId);
                        
                        input.value = '';
                        
                        this.updateCommentsCount(postId, data.comments_count);
                    }
                } catch (error) {
                    console.error('Error submitting comment:', error);
                    form.submit();
                } finally {
                    form.classList.remove('loading');
                    input.disabled = false;
                }
            }

            addCommentToDOM(comment, postId) {
                const commentsList = document.querySelector(`#comments-list-${postId}`);
                const commentsCountText = document.querySelector(`.comments-count-text-${postId}`);
                
                if (!commentsList) return;

                const commentElement = document.createElement('div');
                commentElement.className = 'comment-item d-flex mb-3';
                commentElement.innerHTML = `
                    <div class="flex-shrink-0 me-2">
                        ${comment.user.image ? 
                            `<img src="${comment.user.image}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" alt="${comment.user.username}">` :
                            `<div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                ${comment.user.name_initial}
                            </div>`
                        }
                    </div>
                    <div class="flex-grow-1">
                        <div class="bg-light rounded p-2">
                            <div class="d-flex justify-content-between">
                                <strong>${comment.user.username}</strong>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 delete-comment" data-comment-id="${comment.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <p class="mb-1">${comment.content}</p>
                            <small class="text-muted">${comment.created_at}</small>
                        </div>
                    </div>
                `;

                commentsList.insertBefore(commentElement, commentsList.firstChild);
                
                commentElement.querySelector('.delete-comment').addEventListener('click', (e) => {
                    this.deleteComment(e, comment.id);
                });

                const noCommentsMsg = commentsList.querySelector('.no-comments');
                if (noCommentsMsg) {
                    noCommentsMsg.remove();
                }

                if (commentsCountText) {
                    commentsCountText.textContent = data.comments_count === 1 ? 'comment' : 'comments';
                }
            }

            async deleteComment(e, commentId) {
                e.preventDefault();
                
                if (!confirm('Are you sure you want to delete this comment?')) {
                    return;
                }

                try {
                    const response = await fetch(`/comments/${commentId}/ajax`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                        },
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        e.target.closest('.comment-item').remove();
                        
                        this.updateCommentsCount(null, data.comments_count);
                    }
                } catch (error) {
                    console.error('Error deleting comment:', error);
                    location.reload();
                }
            }

            updateCommentsCount(postId, count) {
                const commentsCountElement = document.querySelector(`.comments-count-${postId}`) || document.querySelector('.comments-count');
                const commentsCountTextElement = document.querySelector(`.comments-count-text-${postId}`) || document.querySelector('.comments-count-text');
                
                if (commentsCountElement) {
                    commentsCountElement.textContent = count;
                }
                
                if (commentsCountTextElement) {
                    commentsCountTextElement.textContent = count === 1 ? 'comment' : 'comments';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new InstagramApp();
        });
    </script>

    @yield('scripts')
</body>
</html>