@extends('layouts.auth.main')

@section('title', 'Login')

@section('content')
    <div class="text-center">
        <a href="{{ route('login') }}" class="navbar-brand navbar-brand-autodark">
            <img src="{{ asset('assets/main/img/logo/health_care.svg') }}" alt="" width="300">
        </a>
    </div>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="card-title h2 text-center mb-4 font-weight-bold" id="titleLogin">Login</h2>
            <form autocomplete="off" novalidate>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                </div>
                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" autocomplete="off" id="password" name="password">
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
                <div class="form-footer">
                    <button type="button" class="btn btn-primary w-100" id="btnLogin">Masuk</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-secondary mt-3">
        Sudah punya akun belum? <a href="{{ route('registration') }}" tabindex="-1">Daftar</a>
    </div>
@endsection

@push('styles')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            togglePasswordVisibility('#showPassword', '#password');

            $('#btnLogin').on('click', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $('#alert').remove();

                const data = {
                    'email': $('#email').val(),
                    'password': $('#password').val()
                }

                $.ajax({
                    type: "POST",
                    url: '{{ route('login') }}',
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            window.location.href = response.url;
                        } else {
                            $('#titleLogin').after(`<div class="alert alert-important alert-danger alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                            <path d="M12 8v4"></path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        ` + response.message + `
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON.errors
                        if (response.email) {
                            $('#email').addClass('is-invalid');
                            $('#email').after(
                                '<div class="invalid-feedback">' + response
                                .email[0] +
                                '</div>');
                        }
                        if (response.password) {
                            var invalidFeedback = $('<div class="invalid-feedback">' +
                                response.password[0] + '</div>');
                            $('#password').addClass('is-invalid').parent('.input-group')
                                .append(invalidFeedback);
                        }
                    }
                });
            });
        });
    </script>
@endpush
