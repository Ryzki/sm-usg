@extends('layouts.app.main')

@section('title', 'Verifikasi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Otorisasi</div>
                    <div class="page-title">Verifikasi Pengguna</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Form Verifikasi</h3>
                        </div>
                        <form action="{{ route('user.verified') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row row-cards">
                                    <input type="hidden" class="form-control" id="id" name="id"
                                        value="{{ $user->id }}">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Nomer Induk Kependudukan (NIK)</label>
                                            <input type="number" class="form-control @error('nik') is-invalid @enderror"
                                                id="nik" name="nik" value="{{ old('nik') }}">
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class=" col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                                name="full_name" value="{{ $user->full_name }}" readonly>
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ $user->email }}" readonly>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Tanggal Lahir</label>
                                            <input type="text"
                                                class="form-control @error('place_of_birth') is-invalid @enderror"
                                                id="place_of_birth" name="place_of_birth"
                                                value="{{ old('place_of_birth') }}">
                                            @error('place_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                                id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <label class="form-label">No Handphone</label>
                                                </div>
                                                <div class="col-auto ">
                                                    <span class="form-help" data-bs-toggle="popover" data-bs-placement="top"
                                                        data-bs-content="<p></p>" data-bs-html="true">
                                                        ?
                                                    </span>
                                                </div>
                                            </div>
                                            <input class="form-control @error('phone_number') is-invalid @enderror"
                                                id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Domisili</label>
                                            <input type="text"
                                                class="form-control @error('home_address') is-invalid @enderror"
                                                id="home_address" name="home_address" value="{{ old('home_address') }}">
                                            @error('home_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">RT</label>
                                                    <input type="number"
                                                        class="form-control  @error('NA') is-invalid @enderror"
                                                        id="NA" name="NA" value="{{ old('NA') }}">
                                                    @error('NA')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">RW</label>
                                                    <input type="number"
                                                        class="form-control @error('RA') is-invalid @enderror"
                                                        id="RA" name="RA" value="{{ old('RA') }}">
                                                    @error('RA')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kelurahan</label>
                                            <select
                                                class="form-control form-select @error('sub_district') is-invalid @enderror"
                                                id="sub_district" name="sub_district">
                                                <option>Pilih Kelurahan</option>
                                                @foreach ($subDistricts as $subDistrict)
                                                    <option value="{{ $subDistrict->name }}"
                                                        data-id="{{ $subDistrict->id }}">
                                                        {{ $subDistrict->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sub_district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kecamatan</label>
                                            <input type="text"
                                                class="form-control @error('district') is-invalid @enderror"
                                                value="Tembalang" id="district" name="district" readonly>
                                            @error('district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kota/Kabupaten</label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="Kota Semarang" id="city" name="city" readonly>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Penanggung Jawab</label>
                                            <div>
                                                <div class="input-group mb-2" id="midwife_area">
                                                    <span class="input-group-text">
                                                        Bidan
                                                    </span>
                                                    <input type="hidden" id="midwife_id" name="midwife">
                                                    <input type="text" class="form-control" id="midwife" readonly>
                                                </div>
                                                <div id="alert-midwife-area">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/css/libs/bootstrap-datepicker3.min.css">
@endpush

@push('script')
    <script src="/assets/main/js/libs/bootstrap-datepicker.min.js"></script>
    <script src="/assets/main/js/libs/locale/bootstrap-datepicker.id.min.js"></script>
    <script>
        $(document).ready(function() {


            $('#date_of_birth').datepicker({
                language: "id",
                clearBtn: true
            });

            $('#RA').on('change', function() {
                getMidWife();
            });

            $('#sub_district').on('change', function() {
                getMidWife();
            });

            function getMidWife() {
                $('#alert-midwife-area .form-hint').remove();

                $.ajax({
                    url: '{{ route('user.get-bidan') }}',
                    method: 'POST',
                    data: {
                        NA: $('#RA').val(),
                        subDistrict: $('#sub_district option:selected').data('id')
                    },
                    success: function(response) {
                        $('#alert-midwife-area .form-hint').remove();

                        if (response.status) {
                            $('#midwife').val(response.data.full_name);
                            $('#midwife_id').val(response.data.id);
                            $('#alert-midwife-area').append('<small class="form-hint text-success">' +
                                response
                                .message + '</small>');
                        } else {
                            $('#midwife').val('-');
                            $('#midwife_id').val('');
                            $('#alert-midwife-area').append('<small class="form-hint text-danger">' +
                                response
                                .message + '</small>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan saat mengirim data ke backend:', error);
                    }
                });
            }
        });
    </script>
@endpush
