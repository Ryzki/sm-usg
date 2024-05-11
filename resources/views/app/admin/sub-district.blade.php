@extends('layouts.app.main')

@section('title', 'Data Kelurahan')

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
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Kelurahan</h3>
                        </div>
                        <div class="card-body">
                            <form id="formSubDistrict">
                                <input type="hidden" id="id_subdistrict" name="id_subdistrict">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control" id="name_subdistrict"
                                        name="name_subdistrict">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title">Data Kelurahan</h3>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive"
                            id="table-subdistricts">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Kelurahan</th>
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
            $("#table-subdistricts").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.sub-district.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data === 1) {
                                return `<span class="status status-success mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Active
                                        </span>`;
                            } else if (data === 0) {
                                return `<span class="status status-danger mt-2 fs-6">
                                            <span class="status-dot status-dot-animated"></span>
                                                Non-Active
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

            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();
                // Pastikan Anda mendapatkan nilai dari input dengan ID 'id_subdistrict'
                var idSubDistrict = $('#id_subdistrict').val();
                var url = idSubDistrict ?
                    "{{ route('admin.sub-district.update', ':id') }}".replace(':id', idSubDistrict) :
                    "{{ route('admin.sub-district.store') }}";
                var data = {
                    subdistrict: $('#name_subdistrict').val(),
                }

                if (idSubDistrict) {
                    data.id = idSubDistrict;
                    data._method = 'PUT';
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('.card-title').html('Tambah Kelurahan');
                                $('#id_subdistrict').val('');
                                $('#formSubDistrict').trigger('reset');
                                $('#table-subdistricts').DataTable().ajax.reload();
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
                        if (response.subdistrict) {
                            $('#name_subdistrict').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.subdistrict[0] + '</small></div>';
                            $('#name_subdistrict').after(invalidFeedback);
                        }
                    }
                });
            });

            $(document).on('click', '#btnEdit', function(e) {
                e.preventDefault();

                $('#formSubDistrict').trigger('reset');

                const id = $(this).data('id');
                const name = $(this).data('name');

                $('.card-title').html('Edit Kelurahan');
                $('#id_subdistrict').val(id);
                $('#name_subdistrict').val(name);
            })

            $(document).on('click', '#btnChangeStat', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const stat = $(this).data('stat');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.sub-district.change_stat') }}",
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
                                $('#table-subdistricts').DataTable().ajax.reload();
                            });
                        } else if (!response.status) {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            })
        });
    </script>
@endpush
