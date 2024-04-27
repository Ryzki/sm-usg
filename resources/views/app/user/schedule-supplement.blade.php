@extends('layouts.app.main')

@section('title', 'Jadwal TTD')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Jadwal TTD</div>
                </div>
            </div>
        </div>
    </div>


    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    @if ($permissionBloodSupplement['minggu'] >= 16)
                        <div id="calendar"></div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9v4"></path>
                                        <path
                                            d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                        </path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="alert-title">Fitur ini di Non-Aktifkan Sementara</h4>
                                    <div class="text-secondary">
                                        <p>Fitur akan Aktif ketika <strong>Usia Kandungan > 16 Minggu</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalAbsen" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">
                        {{ date('d M Y') }}
                    </div>
                    <div>
                        Apakah kamu sudah meminum Obat Penambah Darah?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary text-decoration-none me-auto"
                        data-bs-dismiss="modal" id="btnCancel">Belum</button>
                    <button type="button" class="btn btn-success" id="btnConfirm" data-bs-dismiss="modal">Sudah</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/css/custom-fullcalendar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
@endpush

@push('script')
    <script src="/assets/main/js/libs/fullcalender/index.global.min.js"></script>
    <script src="/assets/main/js/libs/fullcalender/locale/id.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    @if ($permissionBloodSupplement)
        <script>
            $(document).ready(function() {
                var calendarEl = $('#calendar');
                var calendar = new FullCalendar.Calendar(calendarEl[0], {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    showNonCurrentDates: false,
                    titleFormat: {
                        month: 'long',
                        year: 'numeric',
                    },
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next btnAbsen'
                    },
                    customButtons: {
                        btnAbsen: {
                            text: 'Yuk Minum',
                            click: function(start) {
                                $('#modalAbsen').modal('show');
                            }
                        }
                    },
                    events: function(info, successCallback, failureCallback) {
                        // Lakukan permintaan Ajax ke endpoint server-side Anda
                        $.ajax({
                            url: "{{ route('user.schedule-supplement.index') }}",
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                start: formateDate(info.startStr),
                                end: formateDate(info.endStr)
                            },
                            success: function(response) {
                                // Proses data acara dari respons server
                                var events = response.datas.map(function(event) {
                                    return {
                                        title: event.status === 1 ? 'MINUM' :
                                            'TERLEWAT',
                                        start: event.start_end,
                                        end: event.start_end,
                                        color: event.status === 1 ? '#2FB344' :
                                            '#D63939'
                                    };
                                });
                                // Panggil successCallback dengan data acara yang diterima
                                successCallback(events);
                            },
                            error: function(xhr, status, error) {
                                // Panggil failureCallback jika terjadi kesalahan
                                failureCallback(error);
                            }
                        });
                    }
                });

                calendar.render();

                $('#btnConfirm').click(function() {
                    const data = {
                        'date': "{{ date('Y-m-d') }}"
                    }

                    $.ajax({
                        url: "{{ route('user.schedule-supplement.store') }}",
                        method: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            $('#modalAbsen').modal('hide');
                            if (response.status) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                calendar.refetchEvents();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        },
                        error: function(xhr, status, error) {

                        }
                    });
                });

                function formateDate(date) {
                    var startDate = new Date(date);
                    var day = startDate.getDate();
                    var month = startDate.getMonth() + 1; // Ingat bahwa bulan dimulai dari 0, sehingga perlu ditambah 1
                    var year = startDate.getFullYear();
                    var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day :
                        day);
                    return formattedDate;
                }
            });
        </script>
    @endif
@endpush
