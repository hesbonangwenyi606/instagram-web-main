@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Create New Post</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Post Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption</label>
                        <textarea class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" rows="3" placeholder="What's on your mind?">{{ old('caption') }}</textarea>
                        @error('caption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Share Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection