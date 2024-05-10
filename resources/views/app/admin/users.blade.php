@extends('layouts.app.main')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Data Pengguna</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title">Data Pengguna</h3>
                            <button type="button" class="btn btn-primary" id="btnModalCreateUsers">
                                Tambah Pengguna
                            </button>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive" id="table-users">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Handphone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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

    {{-- Modal Change ROLE --}}
    <div class="modal modal-blur fade" id="modal-change-role" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formChangeRole">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" @readonly(true)>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            {{-- <div class="form-selectgroup">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="icons" value="1" class="form-selectgroup-input"
                                        checked="">
                                    <span class="form-selectgroup-label">
                                        <i class="fa-solid fa-person-pregnant fa-xl"></i>
                                        Ibu Hamil
                                    </span>
                                </label>
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="icons" value="user" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label">
                                        <i class="fa-solid fa-user-nurse"></i>
                                        Bidan
                                    </span>
                                </label>
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="icons" value="circle" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label">
                                        <i class="fa-solid fa-user-doctor"></i>
                                        Doctor
                                    </span>
                                </label>
                            </div> --}}
                            <select class="form-select" name="user_role" id="user_role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnChangeRole">Submit</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create USER --}}
    <div class="modal modal-blur fade" id="modal-create-users" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreateUser">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                            <small class="form-hint">
                                Harap password dicopy terlebih dahulu sebelum menekan Submit
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" id="role">
                                <option selected>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnCreateUser">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/libs/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/main/libs/sweetalert2/sweetalert2.min.css">
    <style>
        @media (max-width: 768px) {
            .search-coloumn-count .d-flex {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('script')
    <script src="/assets/main/libs/datatables/datatables.min.js"></script>
    <script src="/assets/main/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#table-users").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.index') }}",
                order: [
                    [5, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'role.name',
                        name: 'role.name'
                    },
                    {
                        data: 'verified',
                        name: 'verified',
                        render: function(data) {
                            if (data === 1) {
                                return `<span class="status status-success mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Verified
                                        </span>`;
                            } else {
                                return `<span class="status status-danger mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Unverified
                                        </span>`;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                language: {
                    lengthMenu: "Tampil _MENU_ data",
                    search: "Cari",
                    emptyTable: "Tidak ada data",
                    info: "Tampilkan _START_ ke _END_ dari _TOTAL_ data",
                },
                dom: `<"card-body border-bottom py-3 search-coloumn-count"<"d-flex"<"text-secondary mb-2"l><"ms-auto text-secondary"<"ms-2 d-inline-block"f>>>><"table-responsive"t><"card-footer d-flex align-items-center"<"m-0 text-secondary"i><"pagination m-0 ms-auto"p>>
                `
            });

            $('#dt-length-1').removeClass('form-select-sm').addClass('form-select-md');
            $('#dt-search-1').removeClass('form-control-sm').addClass('form-control-md');

            // Show Modal
            $(document).on('click', '#btnChangeRole', function(e) {
                e.preventDefault();

                $('#formChangeRole').trigger('reset');

                var id = $(this).data('id');
                var fullName = $(this).data('name');
                var role = $(this).data('role');

                $('#modal-change-role').modal('show');
                $('#user_id').val(id);
                $('#full_name').val(fullName);
                $('#user_role').val(role);
            });

            $(document).on('click', '#btnChangeRole', function(e) {
                const data = {
                    id: $('#user_id').val(),
                    role: $('#user_role').val()
                }

                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.changeRole') }}',
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            $('#modal-change-role').modal('hide');
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#formChangeRole').trigger('reset');
                                $('#table-users').DataTable().ajax.reload();
                            });
                        } else if (response.status) {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                timer: 1500
                            });
                        }
                    },
                });
            });

            $('#btnModalCreateUsers').on('click', function(e) {
                e.preventDefault();
                $('#formCreateUser').trigger('reset');
                $('#modal-create-users').modal('show');
            });

            $('#btnCreateUser').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                const data = {
                    'full_name': $('#name').val(),
                    'email': $('#email').val(),
                    'password': $('#password').val(),
                    'role': $('#role').val()
                }

                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.users.store') }}',
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            $('#modal-create-users').modal('hide');
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#formCreateUser').trigger('reset');
                                $('#table-users').DataTable().ajax.reload();
                            });
                        } else if (response.status) {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON.errors
                        if (response.full_name) {
                            $('#name').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.full_name[0] + '</small></div>';
                            $('#name').after(invalidFeedback);
                        }

                        if (response.email) {
                            $('#email').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.email[0] + '</small></div>';
                            $('#email').after(invalidFeedback);
                        }

                        if (response.password) {
                            $('#password').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.password[0] + '</small></div>';
                            $('#password').after(invalidFeedback);
                        }

                        if (response.role) {
                            $('#role').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.role[0] + '</small></div>';
                            $('#role').after(invalidFeedback);
                        }
                    }
                });
            });
        });
    </script>
@endpush
