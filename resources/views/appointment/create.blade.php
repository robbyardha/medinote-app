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
                <a href="/exam/registration-examination" class="btn btn-sm color-slate-500 text-white"> <i
                        class='bx bx-arrow-back'></i>
                    Back</a>
            </div>

            <div class="card-body">
                <form method="POST" action="/exam/registration-examination/create" enctype="multipart/form-data"
                    id="add-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">{!! requiredFieldLabel('Pasien') !!}</label>
                        <br>
                        <select class="form-control" name="patient_id" id="patient-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">{!! requiredFieldLabel('Dokter') !!}</label>
                        <br>
                        <select class="form-control" name="user_id" id="doctor-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">{!! requiredFieldLabel('Tanggal') !!}</label>
                        <input type="date"
                            class="form-control defaultDatePickrResponsiveWithTime @error('appointment_time') is-invalid @enderror"
                            name="appointment_time" id="appointment_time" value="{{ old('appointment_time') }}">
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{!! requiredFieldLabel('Deskripsi') !!}</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            name="description" id="description" value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="text-muted">Contoh : Ke Poli Umum / Keluhan Pasien</span>
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
