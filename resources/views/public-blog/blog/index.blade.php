@extends('public-blog.layouts.main')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4">Public Blog</h1>

        <!-- Filter by Tags -->
        <div class="mb-4">
            <form method="GET" action="{{ route('public.blog.index') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <select class="form-select w-50" name="tag" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Posts List -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('public.blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>


                            <!-- Like Button -->
                            <form action="{{ route('public.blog.like', $post->id) }}"
                                method="POST"onsubmit="return {{ Auth::check() ? '' : 'window.location.href=\'/login\'; return false;' }}">
                                @csrf

                                <button type="submit"
                                    class="btn {{ Auth::check() && Auth::user()->hasLiked($post) ? 'btn-danger' : 'btn-outline-primary' }}">
                                    <i class="bi bi-heart"></i> Like ({{ $post->likes->count() }})
                                </button>
                            </form>


                            <hr>

                            <!-- Comments Section -->
                            <h6>Comments</h6>
                            @foreach ($post->comments as $comment)
                                <div class="mb-3">
                                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                                </div>
                            @endforeach

                            @auth
                                <!-- Comment Form -->
                                <form action="{{ route('public.blog.comment', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="content" class="form-control" rows="3" placeholder="Add a comment"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                </form>
                            @else
                                <p class="text-muted">Please log in to comment.</p>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
