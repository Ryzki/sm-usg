@extends('layouts.app.main')

@section('title', 'Daftar Kunjungan ANC')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Kunjungan ANC</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if (session('message'))
                <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('message') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-important alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="card p-3 mb-3">
                <div class="row">
                    @foreach ($visits as $visit)
                        <div class="col-12 mb-2">
                            @if (!$visit->scheduleAncs->isEmpty() && $visit->scheduleAncs->first()->status == 1)
                                <div class="card bg-success-lt">
                                @elseif (
                                    !$visit->scheduleAncs->isEmpty() &&
                                        $visit->scheduleAncs->first()->schedule_date->isToday() &&
                                        $visit->scheduleAncs->first()->status == 0)
                                    <div class="card bg-primary-lt">
                                    @elseif (
                                        !$visit->scheduleAncs->isEmpty() &&
                                            !$visit->scheduleAncs->first()->schedule_date->isToday() &&
                                            $visit->scheduleAncs->first()->status == 0)
                                        <div class="card bg-danger-lt">
                                        @else
                                            <div class="card bg-danger-lt">
                            @endif
                            <div class="card-body">
                                <div class="datagrid-title">
                                    {{ $visit->name }} - Trimester {{ $visit->category_trimester }}
                                </div>
                                @if (!$visit->scheduleAncs->isEmpty())
                                    <div class="datagrid-content mb-3">
                                        <strong>{{ $visit->scheduleAncs->first()->formatted_schedule_date }}</strong>
                                    </div>
                                    @if ($visit->scheduleAncs->first()->schedule_date->isToday() && $visit->scheduleAncs->first()->status == 0)
                                        <div class="text-right">
                                            <a class="btn btn-primary"
                                                href="{{ route('user.check-anc.create', ['name_anc' => $visit->abbreviation, 'schedule_date' => $visit->scheduleAncs->first()->schedule_date->format('d-m-Y')]) }}">
                                                Masuk
                                            </a>
                                        </div>
                                    @elseif(!$visit->scheduleAncs->isEmpty() && $visit->scheduleAncs->first()->status == 1)
                                        <div class="text-right">
                                            <a class="btn btn-success"
                                                href="{{ route('user.check-anc.show', ['name_anc' => $visit->abbreviation, 'schedule_date' => $visit->scheduleAncs->first()->schedule_date->format('d-m-Y')]) }}">Detail</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="datagrid-content mb-3">
                                        <strong>Jadwal Belum di Tentukan</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>


@endsection

@push('styles')
@endpush

@push('script')
@endpush
