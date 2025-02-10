@extends('public-blog.layouts.main-landing')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">

                <div class="row">
                    <form method="GET" action="{{ route('public.blog.index') }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <select class="form-select w-50" name="tag" onchange="this.form.submit()">
                                <option value="">All</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->name }}"
                                        {{ request('tag') == $tag->name ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

            </div>


            <a href="{{ route('public.blog.index') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-arrow-left"></i>
                Back To All Post
            </a>
            <div class="row stats-row gy-4 mt-3" data-aos="fade-up" data-aos-delay="500">
                <h2 class="text-center">{{ $post->title }}</h2>
                <hr>
                <p>{!! $post->content !!}</p>

            </div>

        </div>

    </section>



@section('content')
