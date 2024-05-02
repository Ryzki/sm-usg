@extends('layouts.app.main')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Kontrol Ibu Hamil</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="row g-2 mb-3">
                <form action="{{ route('midwife.control-users.index') }}" method="GET">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari by Nama atau NIK"
                                value="{{ request()->query('search') }}">
                            <button type="submit" class="btn btn-icon" aria-label="Button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-mobile-md table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Nama</th>
                                <th>Alamat Domisili</th>
                                <th>No Handphone</th>
                                <th>Jadwal ANC</th>
                                <th>Status Kesehatan</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td data-label="Nama">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar avatar-md me-2">
                                                {{ implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', $user->full_name))) }}
                                            </span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $user->full_name }}</div>
                                                <div class="text-secondary">
                                                    {{ $user->nik }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-secondary" data-label="Alamat Domisili">
                                        <div>{{ $user->full_adress }}</div>
                                    </td>
                                    <td data-label="No Handphone">
                                        <div>{{ $user->formatted_phone }}</div>
                                    </td>
                                    <td class="text-secondary" data-label="Jadwal ANC">
                                        <button class="btn btn-sm px-2 rounded btn-primary d-inline-block"
                                            id="btnScheduleAnc" data-bs-toggle="modal" data-bs-target="#modal-simple"
                                            data-id="{{ $user->id }}">
                                            Lihat Jadwal
                                        </button>
                                    </td>
                                    <td class="text-secondary" data-label="Status Kesehatan">
                                        @if ($user->historyAncs && $user->latestHistoryAncs->stat_skrining_preklampsia === 1)
                                            <span class="status status-success mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                {{ $user->latestHistoryAncs->stat_skrining_preklampsia_label }}
                                            </span>
                                        @elseif ($user->historyAncs && $user->latestHistoryAncs->stat_skrining_preklampsia === 2)
                                            <span class="status status-warning mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                {{ $user->latestHistoryAncs->stat_skrining_preklampsia_label }}
                                            </span>
                                        @elseif ($user->historyAncs && $user->latestHistoryAncs->stat_skrining_preklampsia === 3)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                {{ $user->latestHistoryAncs->stat_skrining_preklampsia_label }}
                                            </span>
                                        @elseif(empty($user->historyAncs))
                                            <span class="status status-success mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Sehat
                                            </span>
                                        @endif

                                        @if ($user->latestHistoryAncs->stat_risk_pregnancy_of_ced)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Resiko Kehamilan KEK
                                            </span>
                                        @endif

                                        @if ($user->latestHistoryAncs->stat_risk_preeclamsia)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Resiko Preklamsia
                                            </span>
                                        @endif

                                        @if ($user->latestHistoryAncs->stat_risk_anemia)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Resiko Anemia
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a class="btn" href="https://wa.me/{{ $user->phone_number }}"
                                                target="_blank">
                                                Chat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>




            @if ($users->lastPage() > 1)
                <div class="card align-items-center mt-2">
                    <ul class="pagination mt-3">
                        {{ $users->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Jadwal ANC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Kunjungan</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="schedule-anc">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btnScheduleAnc', function() {
                const id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: '{{ route('midwife.get_schedule_user') }}',
                    data: {
                        'id': id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#schedule-anc').empty();

                        // Iterasi melalui data dan tambahkan baris ke tbody
                        $.each(response, function(index, schedule) {
                            $html = `
                                <tr>
                                    <td> ` + schedule.visit.abbreviation + ` </td>
                                    <td> ` + formatDate(schedule.schedule_date) + ` </td>
                                    <td>` + (schedule.status === 1 ?
                                `<span class="badge bg-green text-green-fg">Sukses</span>` :
                                `<span class="badge bg-primary text-green-fg">Menunggu</span>`
                            ) + `</td>
                                `;
                            $('#schedule-anc').append(
                                $html
                            );
                        });
                    }
                });
            });

            function formatDate(isoDateString) {
                // Membuat objek Date dari string tanggal
                var date = new Date(isoDateString);

                // Array nama bulan
                var monthNames = [
                    "Januari", "Februari", "Maret",
                    "April", "Mei", "Juni", "Juli",
                    "Agustus", "September", "Oktober",
                    "November", "Desember"
                ];

                // Mendapatkan tanggal, bulan, dan tahun dari objek Date
                var day = date.getDate();
                var monthIndex = date.getMonth();
                var year = date.getFullYear();

                // Menggabungkan tanggal dengan nama bulan dan tahun
                var formattedDate = day + ' ' + monthNames[monthIndex] + ' ' + year;

                return formattedDate;
            }

        });
    </script>
@endpush
