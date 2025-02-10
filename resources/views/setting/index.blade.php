@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12 col-lg-12 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Setting Aplikasi</h5>
                    </div>
                    <div class="card-body">
                        <form action="/setting" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name_app" class="form-label">Nama Aplikasi</label>
                                <input type="text" class="form-control" id="name_app" name="name_app"
                                    value="{{ old('name_app', $setting ? $setting->name_app : '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $setting ? $setting->email : '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="number_phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="number_phone" name="number_phone"
                                    value="{{ old('number_phone', $setting ? $setting->number_phone : '') }}" required>
                            </div>
                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">
                                    @if ($setting)
                                        Update Setting
                                    @else
                                        Create Setting
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
