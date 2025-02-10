@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Hello, {{ Auth::user()->name }}! 🎉</h5>
                                <p>
                                    Selamat Datang di Medinote - App
                                </p>

                                <a href="{{ route('public.blog.index') }}" class="btn btn-md btn-outline-primary">
                                    Visit Blog
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('') }}assets/img/illustrations/man-with-laptop-light.png"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bx-hdd text-danger fs-1'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Post Draft</span>
                                <h3 class="card-title mb-2">{{ $draftCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bxs-cloud-upload text-success fs-1'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Post Published</span>
                                <h3 class="card-title mb-2">{{ $publishedCount }} </h3>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-md-12 col-lg-12 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Jumlah Suka & Komentar</h5>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>❤️ Suka</th>
                                    <th>🌐 Komentar</th>
                                </tr>
                            </thead>
                            <tbody>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
