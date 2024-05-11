@extends('layouts.app.main')

@section('title', 'Data Daerah')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Data Daerah</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Daerah</h3>
                        </div>
                        <div class="card-body">
                            <form id="formAreas">
                                <input type="hidden" id="id_area" name="id_area">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <select class="form-select" id="sub_district" name="sub_district">
                                        <option value="" selected>Pilih Kelurahan</option>
                                        @foreach ($subDistricts as $subDistrict)
                                            <option value="{{ $subDistrict->id }}">{{ $subDistrict->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">RW</label>
                                    <input type="number" class="form-control" id="RA" name="RA">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title">Data Daerah</h3>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive" id="table-areas">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Kelurahan</th>
                                    <th>RW</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
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
            $("#table-areas").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.areas.index') }}",
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
                        data: 'sub_district.name',
                        name: 'subDistrict.name'
                    },
                    {
                        data: 'residential_association',
                        name: 'residential_association'
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
                                                NonActive
                                        </span>`;
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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

            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                var idArea = $('#id_area').val();
                var url = idArea ?
                    "{{ route('admin.areas.update', ':id') }}".replace(':id', idArea) :
                    "{{ route('admin.areas.store') }}";
                var data = {
                    subdistrict: $('#sub_district').val(),
                    RA: $('#RA').val()
                }

                if (idArea) {
                    data.id = idArea;
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
                                $('.card-title').html('Tambah Daerah');
                                $('#id_area').val('');
                                $('#formAreas').trigger('reset');
                                $('#table-areas').DataTable().ajax.reload();
                            });
                        } else if (!response.status) {
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
                            $('#sub_district').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.subdistrict[0] + '</small></div>';
                            $('#sub_district').after(invalidFeedback);
                        }

                        if (response.RA) {
                            $('#RA').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.RA[0] + '</small></div>';
                            $('#RA').after(invalidFeedback);
                        }
                    }
                });
            });

            $(document).on('click', '#btnEdit', function(e) {
                e.preventDefault();

                $('#formAreas').trigger('reset');

                const id = $(this).data('id');
                const subdistrict = $(this).data('subdistrict');
                const ra = $(this).data('ra');

                $('.card-title').html('Edit Daerah');
                $('#id_area').val(id);
                $('#sub_district').val(subdistrict);
                $('#RA').val(ra);
            })

            $(document).on('click', '#btnChangeStat', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const stat = $(this).data('stat');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.areas.change_stat') }}",
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
                                $('#table-areas').DataTable().ajax.reload();
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
