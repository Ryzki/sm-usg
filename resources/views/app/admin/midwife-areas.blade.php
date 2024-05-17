@extends('layouts.app.main')

@section('title', 'Data Penempatan Bidan')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Data Penempatan Bidan</div>
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
                            <h3 class="card-title" id="titleMidwifeArea">Tambah Penempatan Bidan</h3>
                        </div>
                        <div class="card-body">
                            <form id="formAreas">
                                <input type="hidden" id="id_midwife_area" name="id_midwife_area">
                                <div class="mb-3">
                                    <label class="form-label">Nama Bidan</label>
                                    <select class="form-select" id="midwife" name="midwife">
                                        <option value="" selected>Pilih Bidan</option>
                                        @foreach ($midwifes as $midwife)
                                            <option value="{{ $midwife->id }}">Bidan {{ $midwife->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Kelurahan</div>
                                    <select class="form-select" name="subDistrict" id="subDistrict">
                                        <option value="" selected>Pilih Kelurahan</option>
                                        @foreach ($subDistrcits as $subDistrcit)
                                            <option value="{{ $subDistrcit->id }}">{{ $subDistrcit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">RW</div>
                                    <select class="form-select" name="area" id="area">
                                        <option value="" selected>Pilih RW</option>
                                    </select>
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
                            <h3 class="card-title">Data Penempatan Bidan</h3>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive" id="table-areas">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Nama</th>
                                    <th>Kelurahan</th>
                                    <th>RW</th>
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
                ajax: "{{ route('admin.midwife_areas.index') }}",
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
                        data: 'user.full_name',
                        name: 'user.full_name'
                    },
                    {
                        data: 'areas.sub_district.name',
                        name: 'areas.subDistrict.name'
                    },
                    {
                        data: 'areas.residential_association',
                        name: 'areas.residential_association'
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

                var idMidwifeArea = $('#id_midwife_area').val();

                var url = "{{ route('admin.midwife_areas.store') }}";

                var data = {
                    midwife: $('#midwife').val(),
                    subDistrict: $('#subDistrict').val(),
                    area: $('#area').val(),
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

                                $('#titleMidwifeArea').html('Tambah Penempatan Bidan');
                                $('#id_midwife_area').val('');
                                $('#formAreas').trigger('reset');
                                $('#area').empty().append($('<option>', {
                                    value: '',
                                    text: 'Pilih RW'
                                }));
                                $('#table-areas').DataTable().ajax.reload();
                            });
                        } else if (!response.status) {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                timer: 1500,
                                showConfirmButton: false,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON.errors
                        if (response.midwife) {
                            $('#midwife').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.midwife[0] + '</small></div>';
                            $('#midwife').after(invalidFeedback);
                        }

                        if (response.subDistrict) {
                            $('#subDistrict').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.subDistrict[0] + '</small></div>';
                            $('#subDistrict').after(invalidFeedback);
                        }

                        if (response.residential_association) {
                            $('#residential_association').addClass('is-invalid');
                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.residential_association[0] + '</small></div>';
                            $('#residential_association').after(invalidFeedback);
                        }
                    }
                });
            });

            $(document).on('click', '#btnDelete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const url = "{{ route('admin.midwife_areas.destroy', ':id') }}".replace(':id', id);

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
                                $('#table-areas').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });

            $('#subDistrict').on('change', function(e) {
                e.preventDefault();

                const data = {
                    id: $(this).val()
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.midwife_areas.get_ra') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        const selectElement = $('#area');
                        selectElement.empty();
                        if (response.status && response.data.length > 0) {
                            response.data.forEach(option => {
                                const optionElement = $('<option></option>')
                                    .val(option.id)
                                    .text(option.residential_association);
                                selectElement.append(optionElement);
                            });
                        } else {
                            const defaultOption = $('<option></option>')
                                .val('')
                                .text('Pilih RW');
                            selectElement.append(defaultOption);
                        }
                    },
                });
            });
        });
    </script>
@endpush
