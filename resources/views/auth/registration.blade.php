@extends('layouts.auth.main')

@section('content')
    <div class="text-center">
        <a href="{{ route('login') }}" class="navbar-brand navbar-brand-autodark">
            <img src="{{ asset('assets/main/img/logo/health_care.svg') }}" alt="" width="300">
        </a>
    </div>
    <form class="card card-md" action="#" autocomplete="off" novalidate id="formRegistration">
        <div class="card-body">
            <h2 class="card-title text-center mb-4" id="titleRegistrasi">Pendaftaran Akun Baru</h2>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group mb-2">
                    <input type="password" class="form-control " autocomplete="off" id="password" name="password">
                    <span class="input-group-text">
                        <a href="#" class="link-secondary" id="showPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group mb-2">
                    <input type="password" class="form-control" autocomplete="off" id="password_confirmation"
                        name="password_confirmation">
                    <span class="input-group-text">
                        <a href="#" class="link-secondary" id="showPasswordConfirmation">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
            <div class="form-footer">
                <button type="button" class="btn btn-primary w-100" id="btnRegistrasi">Daftar Akun</button>
            </div>
        </div>
    </form>
    <div class="text-center text-secondary mt-3">
        Yuk login kalau sudah punya akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script>
        togglePasswordVisibility('#showPassword', '#password');
        togglePasswordVisibility('#showPasswordConfirmation', '#password_confirmation');

        $('#btnRegistrasi').click(function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('.custon-invalid-feedback').empty();

            const data = {
                'full_name': $('#full_name').val(),
                'email': $('#email').val(),
                'password': $('#password').val(),
                'password_confirmation': $('#password_confirmation').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{ route('registration') }}",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#formRegistration')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON.message
                    if (response.full_name) {
                        $('#full_name').addClass('is-invalid');
                        $('#full_name').after(
                            '<div class="invalid-feedback">' + response
                            .full_name[0] +
                            '</div>');
                    }
                    if (response.email) {
                        $('#email').addClass('is-invalid');
                        $('#email').after(
                            '<div class="invalid-feedback">' + response
                            .email[0] +
                            '</div>');
                    }
                    if (response.password) {
                        $('#password').addClass('is-invalid');
                        var invalidFeedback =
                            '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                            response.password[0] + '</small></div>';
                        $('#password').closest('.input-group').after(invalidFeedback);
                    }
                }
            });
        });
    </script>
@endpush
