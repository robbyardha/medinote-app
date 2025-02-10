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

        <!-- Edit Form -->
        <div class="card">
            <h5 class="card-header">Edit</h5>

            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="/exam/registration-examination" class="btn btn-sm color-slate-500 text-white"> <i
                        class='bx bx-arrow-back'></i>
                    Back</a>
            </div>

            <div class="card-body">
                <form method="POST" action="/exam/registration-examination/update/{{ Crypt::encrypt($appointment->id) }}"
                    enctype="multipart/form-data" id="edit-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">{!! requiredFieldLabel('Pasien') !!}</label>
                        <br>
                        <select class="form-control select2" name="patient_id" id="patient_id">
                            <option value="">Pilih Pasien</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" @if ($patient->id == old('patient_id', $appointment->patient_id)) selected @endif>
                                    {{ $patient->name . '( ' . $patient->number_phone . ' )' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">{!! requiredFieldLabel('Dokter') !!}</label>
                        <br>
                        <select class="form-control select2" name="user_id" id="user_id">
                            <option value="">Pilih Dokter</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @if ($doctor->id == old('user_id', $appointment->user_id)) selected @endif>
                                    {{ $doctor->name . '( ' . $doctor->username . ' )' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">{!! requiredFieldLabel('Tanggal') !!}</label>
                        <input type="date"
                            class="form-control defaultDatePickrResponsiveWithTime @error('appointment_time') is-invalid @enderror"
                            name="appointment_time" id="appointment_time"
                            value="{{ old('appointment_time', $appointment->appointment_time) }}">
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{!! requiredFieldLabel('Deskripsi') !!}</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            name="description" id="description"
                            value="{{ old('description', $appointment->description) }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="text-muted">Contoh : Ke Poli Umum / Keluhan Pasien</span>
                    </div>


                    <button type="submit" class="btn btn-primary btn-save-add">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Update
                    </button>
                </form>
            </div>
        </div>
        <!--/ Edit Form -->

    </div>
@endsection
