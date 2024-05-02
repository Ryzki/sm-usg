@extends('layouts.app.main')

@section('title', 'Jadwal ANC')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Penjadwalan ANC</div>
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
                            <h3 class="card-title">Penjadwalan ANC</h3>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal-schedules">
                                Tambah Artikel
                            </button>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-mobile-md table-responsive "
                            id="table-schedules">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kunjungan</th>
                                    <th>Trimester</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
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
    <div class="modal modal-blur fade" id="modal-schedules">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal ANC</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu Hamil</label>
                        <select class="form-select" id="pregnant_mother" name="pregnant_mother">
                            <option value="">Pilih Ibu Hamil</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kunjungan</label>
                        <select class="form-select" id="visit" name="visit">
                            <option value="">Pilih Kunjungan</option>
                            @foreach ($visits as $visit)
                                <option value="{{ $visit->id }}">{{ $visit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="schedule_date">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                    </path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M11 15h1"></path>
                                    <path d="M12 15v3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSubmit" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/css/libs/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="{{ asset('assets/main/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/main/libs/sweetalert2/sweetalert2.min.css') }}">
    <style>
        @media (max-width: 768px) {
            .search-coloumn-count .d-flex {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('assets/main/js/libs/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/main/js/libs/datepicker/locale/bootstrap-datepicker.id.min.js') }}"></script>
    <script src="{{ asset('assets/main/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/main/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#schedule_date').datepicker({
                language: "id",
                clearBtn: true
            });

            $("#table-schedules").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('midwife.schedule-users.index') }}",
                order: [
                    [5, 'desc']
                ],
                columns: [{
                        data: "user.full_name",
                        name: "user.full_name",
                    },
                    {
                        data: "visit.name",
                        name: "visit.name",
                    },
                    {
                        data: "visit.category_trimester",
                        name: "visit.category_trimester",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "schedule_date",
                        name: "schedule_date",
                        render: function(data) {
                            const options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                weekday: 'long'
                            };
                            return new Date(data).toLocaleDateString('id-ID', options);
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "status",
                        name: "status",
                        render: function(data) {
                            if (data === 1) {
                                return `<span class="status status-success mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Sudah Berkunjung
                                    </span>`;
                            } else {
                                return `<span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Belum Berkunjung
                                    </span>`;
                            }
                        },
                        searchable: false
                    },
                    {
                        data: "created_at_humans",
                        name: "schedule_ancs.created_at",
                    },
                    {
                        data: "action",
                        name: "status",
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function(colIndex) {
                        switch (colIndex) {
                            case 0:
                                $(this).attr('data-label', 'Nama');
                                break;
                            case 1:
                                $(this).attr('data-label', 'Kunjungan');
                                break;
                            case 2:
                                $(this).attr('data-label', 'Trimester');
                                break;
                            case 3:
                                $(this).attr('data-label', 'Tanggal');
                                break;
                            case 4:
                                $(this).attr('data-label', 'Status');
                                break;
                            case 5:
                                $(this).attr('class', 'text-secondary');
                                $(this).attr('data-label', 'Dibuat');
                                break;
                            case 5:
                                $(this).attr('data-label', 'Aksi');
                                break;
                        }
                    });
                },
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

            $(document).on('click', '#btnDelete', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const url = "{{ route('midwife.schedule-users.destroy', ':id') }}".replace(':id', id)

                Swal.fire({
                    icon: "warning",
                    title: "Apakah anda yakin ingin menghapus?",
                    showCancelButton: true,
                    confirmButtonText: "Iya",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            data: {
                                id: id
                            },
                            dataType: "JSON",
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: "success",
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                } else if (response.status) {
                                    Swal.fire({
                                        icon: "error",
                                        title: response.message,
                                        timer: 1500
                                    });
                                }
                                $('#table-schedules').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        console.log("CANCEL");
                    }
                })
            });

            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                const data = {
                    'user_id': $('#pregnant_mother').val(),
                    'visit_id': $('#visit').val(),
                    'schedule_date': $('#schedule_date').val()
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('midwife.schedule-users.store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('#visit').val('');
                                $('#pregnant_mother').val('');
                                $('#schedule_date').val('');
                                $('#table-schedules').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('#visit').val('');
                                $('#pregnant_mother').val('');
                                $('#schedule_date').val('');
                                $('#table-schedules').DataTable().ajax.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {

                        var response = xhr.responseJSON.errors
                        if (response.user_id) {
                            $('#pregnant_mother').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.user_id[0] + '</small></div>';
                            $('#pregnant_mother').after(invalidFeedback);
                        }

                        if (response.visit_id) {
                            $('#visit').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.visit_id[0] + '</small></div>';
                            $('#visit').after(invalidFeedback);
                        }

                        if (response.schedule_date) {
                            $('#schedule_date').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.schedule_date[0] + '</small></div>';
                            $('#schedule_date').closest('.input-group').after(invalidFeedback);
                        }
                    }
                });
            })
        });
    </script>
@endpush
