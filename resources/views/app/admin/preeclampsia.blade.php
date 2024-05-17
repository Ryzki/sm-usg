@extends('layouts.app.main')

@section('title', 'Data Preklamsia')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Data Preklamsia</div>
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
                            <h3 class="card-title">Data Kategori Preklamsia</h3>
                            <button type="button" class="btn btn-primary" id="btnModal">
                                Tambah Kategori
                            </button>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive"
                            id="table-preeclamsias">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Nama Screening</th>
                                    <th>Resiko</th>
                                    <th>Status</th>
                                    <th>Diubah</th>
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

    {{-- Modal Create Category Preeclamsia --}}
    <div class="modal modal-blur fade" id="modal-create-categories" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Tambah Kategori Preklamsia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCategoriesPreeclamsia">
                        <input type="hidden" id="id_screen_preeclampsia" name="id_screen_preeclampsia" value="">
                        <div class="mb-3">
                            <label class="form-label">Nama Skreaning</label>
                            <input type="text" class="form-control" id="screening_name" name="screening_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori Resiko</label>
                            <select class="form-select" id="risk_category" name="risk_category">
                                <option value="" selected>Pilih Resiko</option>
                                <option value="1">Resiko Rendah</option>
                                <option value="2">Resiko Tinggi</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
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
            $("#table-preeclamsias").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.preeclampsia.index') }}",
                order: [
                    [4, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'screening_name',
                        name: 'screening_name'
                    },
                    {
                        data: 'risk_category',
                        name: 'risk_category',
                        render: function(data) {
                            if (data == 1) {
                                return `<span class="status status-yellow mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Resiko Sedang
                                        </span>`;
                            } else if (data == 2) {
                                return `<span class="status status-danger mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Resiko Tinggi
                                        </span>`;
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data == 1) {
                                return `<span class="status status-success mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Active
                                        </span>`;
                            } else if (data == 0) {
                                return `<span class="status status-danger mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                NonActive
                                        </span>`;
                            }
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
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

            $('#btnModal').on('click', function(e) {
                e.preventDefault();
                $('#formCategoriesPreeclamsia').trigger('reset');
                $('#modal-create-categories').modal('show');
                $('#modal-title').html('Tambah Kategori Preklamsia');

                $('#id_screen_preeclampsia').val('');
            });

            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                var idScreenPreeclampsia = $('#id_screen_preeclampsia').val();
                var url = idScreenPreeclampsia ?
                    "{{ route('admin.preeclampsia.update', ':id') }}".replace(':id', idScreenPreeclampsia) :
                    "{{ route('admin.preeclampsia.store') }}";

                const data = {
                    'screening_name': $('#screening_name').val(),
                    'risk_category': $('#risk_category').val(),
                }

                if (idScreenPreeclampsia) {
                    data.id = idScreenPreeclampsia;
                    data._method = 'PUT';
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            $('#modal-create-categories').modal('hide');
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#formCategoriesPreeclamsia').trigger('reset');
                                $('#table-preeclamsias').DataTable().ajax.reload();
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
                        if (response.screening_name) {
                            $('#screening_name').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.screening_name[0] + '</small></div>';
                            $('#screening_name').after(invalidFeedback);
                        }

                        if (response.risk_category) {
                            $('#risk_category').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.risk_category[0] + '</small></div>';
                            $('#risk_category').after(invalidFeedback);
                        }
                    }
                });
            });

            $(document).on('click', '#btnDelete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const url = "{{ route('admin.preeclampsia.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    icon: "warning",
                    title: "Apakah anda yakin ingin menghapus?",
                    showCancelButton: true,
                    confirmButtonText: "Iya",
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
                                $('#table-preeclamsias').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#btnEdit', function(e) {
                e.preventDefault();
                $('#modal-create-categories').modal('show');
                $('#modal-title').html('Edit Kategori Preklamsia');
                $('#formCategoriesPreeclamsia').trigger('reset');

                const id = $(this).data('id');
                const name = $(this).data('name');
                const risk = $(this).data('risk');

                $('#id_screen_preeclampsia').val(id);
                $('#screening_name').val(name);
                $('#risk_category').val(risk);
            });

            $(document).on('click', '#btnChangeStat', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const stat = $(this).data('stat');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.preeclampsia.change_stat') }}",
                    data: {
                        id: id,
                        stat: stat
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#table-preeclamsias').DataTable().ajax.reload();
                            });
                        } else if (!response.status) {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                timer: 1500
                            });
                        }
                    }
                });
            })
        });
    </script>
@endpush
