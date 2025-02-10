@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{ $title }}</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header"> {{ $title }}</h5>

            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="/cms/post" class="btn btn-sm color-slate-500 text-white"> <i class='bx bx-arrow-back'></i> Back</a>
            </div>

            <div class="card-body">
                <form method="POST" action="/cms/post/create" enctype="multipart/form-data" id="add-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">{!! requiredFieldLabel('Judul Post') !!}</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            id="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">{!! requiredFieldLabel('Slug') !!}</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug"
                            id="slug" value="{{ old('slug') }}">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select id="tags" class="form-control" name="tags[]" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="content" class="form-label">{!! requiredFieldLabel('Post') !!}</label>
                        <textarea name="content" id="editor">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-save-add">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </form>
            </div>

        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
    <!-- / Content -->


    <script>
        document.getElementById('title').addEventListener('input', function(e) {
            let title = e.target.value;

            let slug = title
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');

            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
