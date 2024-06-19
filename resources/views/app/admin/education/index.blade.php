@extends('layouts.app.main')

@section('title', 'Data Materi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Data Materi</div>
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
                            <h3 class="card-title">Data Materi</h3>
                            <a href="{{ route('education.create') }}" type="button" class="btn btn-primary">
                                Tambah Materi
                            </a>
                        </div>
                        <table class="table table-striped card-table table-vcenter table-responsive" id="table-educations">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Judul</th>
                                    <th>Slug</th>
                                    <th>Kategori</th>
                                    <th>Pembuat</th>
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
            $("#table-educations").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('education.index') }}",
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
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id',
                        render: function(data) {
                            if (data == 1) {
                                return 'Edukasi';
                            }
                        }
                    },
                    {
                        data: 'user.full_name',
                        name: 'author_id',
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
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
        });
    </script>
@endpush
