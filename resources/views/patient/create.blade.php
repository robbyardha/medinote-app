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
                <a href="/master/patient" class="btn btn-sm color-slate-500 text-white"> <i class='bx bx-arrow-back'></i>
                    Back</a>
            </div>

            <div class="card-body">
                <form method="POST" action="/master/patient/create" enctype="multipart/form-data" id="add-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{!! requiredFieldLabel('Nama Pasien') !!}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">{!! requiredFieldLabel('Jenis Kelamin') !!}</label>

                        <div class="form-check">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender_laki_laki" value="Laki-laki"
                                {{ old('gender') == 'Laki-laki' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_laki_laki">
                                Laki-laki
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender_perempuan" value="Perempuan"
                                {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_perempuan">
                                Perempuan
                            </label>
                        </div>

                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">{!! requiredFieldLabel('Tempat Lahir') !!}</label>
                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                            name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}">
                        @error('place_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">{!! requiredFieldLabel('Tanggal Lahir') !!}</label>
                        <input type="date"
                            class="form-control defaultDatePickrResponsive @error('date_of_birth') is-invalid @enderror"
                            name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">{!! requiredFieldLabel('Alamat') !!}</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="number_phone" class="form-label">{!! requiredFieldLabel('Nomor Telepon') !!}</label>
                        <input type="text" class="form-control @error('number_phone') is-invalid @enderror"
                            name="number_phone" id="number_phone" value="{{ old('number_phone') }}">
                        @error('number_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"></label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="blood_type" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control " name="blood_type" id="blood_type"
                            value="{{ old('blood_type') }}">
                    </div>

                    <div class="mb-3">
                        <label for="blood_type" class="form-label">Golongan Darah</label>
                        <select name="blood_type" id="blood_type" class="form-control select2">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                            <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="work" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="work" id="work"
                            value="{{ old('work') }}">

                    </div>

                    <div class="mb-3">
                        <label for="marital_status" class="form-label">Status Perkawinan</label>
                        <select name="marital_status" id="marital_status" class="form-control select2">
                            <option value="">Pilih Status Perkawinan</option>
                            <option value="Menikah" {{ old('marital_status') == 'Menikah' ? 'selected' : '' }}>Menikah
                            </option>
                            <option value="Belum Menikah"
                                {{ old('marital_status') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Janda" {{ old('marital_status') == 'Janda' ? 'selected' : '' }}>Janda</option>
                            <option value="Duda" {{ old('marital_status') == 'Duda' ? 'selected' : '' }}>Duda</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{!! requiredFieldLabel('Status') !!}</label>

                        <div class="form-check">
                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                name="status" id="status_active" value="Active"
                                {{ old('status', 'Active') == 'Active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">
                                Active
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                name="status" id="status_disactive" value="Disactive"
                                {{ old('status') == 'Disactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_disactive">
                                Disactive
                            </label>
                        </div>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="registration_date" class="form-label">{!! requiredFieldLabel('Tanggal Pendaftaran') !!}</label>
                        <input type="date"
                            class="form-control defaultDatePickrResponsiveWithTime @error('registration_date') is-invalid @enderror"
                            name="registration_date" id="registration_date" value="{{ old('registration_date') }}">
                        @error('registration_date')
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
