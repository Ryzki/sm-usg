<?php

namespace App\Http\Controllers\Midwife;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Visit;
use App\Models\ScheduleANC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{

    public function index(Request $request)
    {
        $idMidwife = Auth::user()->id;
        if ($request->ajax()) {
            $schedules = ScheduleANC::with(['visit' => function ($query) {
                return $query->select('id', 'name', 'abbreviation', 'category_trimester',  'status');
            }])
                ->withWhereHas('user', function ($query) use ($idMidwife) {
                    return $query->select('id', 'full_name', 'midwife_id', 'email', 'phone_number')
                        ->where('midwife_id', $idMidwife);
                })
                ->select('schedule_ancs.*');

            return DataTables::eloquent($schedules)
                ->addColumn('action', function ($data) {
                    if ($data->status === 1) {
                        return '-';
                    } else {
                        return '
                            <div class="btn-list flex-nowrap text-center">
                                <a class="btn btn-danger" id="btnDelete" data-id="' . $data->id . '" >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    Hapus
                                </a>
                            </div>
                        ';
                    }
                })
                ->editColumn('created_at_humans', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('user.full_name', function ($data) {
                    return $data->user->full_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $users = User::select('id', 'full_name')
            ->where('midwife_id', $idMidwife)
            ->get();

        $visits =  Visit::get();

        return view('app.midwife.schedule-anc.index', [
            'users' => $users,
            'visits' => $visits
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('user_id', 'visit_id', 'schedule_date'), [
            'user_id' => 'required',
            'visit_id' => 'required',
            'schedule_date' => 'required|after_or_equal:' . Carbon::today()->format('Y-m-d')
        ], [
            'user_id.required' => 'Ibu Hamil wajib diisi',
            'visit_id.required' => 'Kunjungan wajib diisi',
            'schedule_date.required' => 'Tanggal ANC wajib diisi',
            'schedule_date.after_or_equal' => 'Tanggal ANC harus setelah atau sama dengan hari ini',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 400);
        }

        $checkScheduleAlready = ScheduleANC::where('user_id', $request->input('user_id'))
            ->where('visit_id', $request->input('visit_id'))
            ->exists();

        if ($checkScheduleAlready) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal sudah pernah di tetapkan pada Ibu Hamil itu'
            ], 200);
        }

        $schedule = ScheduleANC::create([
            'user_id' => $request->input('user_id'),
            'visit_id' => $request->input('visit_id'),
            'schedule_date' => Carbon::createFromFormat('d-m-Y', $request->input('schedule_date'))->format('Y-m-d')
        ]);

        if ($schedule) {
            return response()->json([
                'status' => true,
                'message' => 'Jadwal berhasil ditetapkan'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Jadwal berhasil ditetapkan'
        ], 200);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $schedules = ScheduleANC::find($id);
        if (!$schedules) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Jadwal ANC'
            ], 404);
        }
        $schedules->delete();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus Jadwal ANC'
        ], 200);
    }
}
