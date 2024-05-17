<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\User;
use App\Models\MidwifeArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubDistrict;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MidwifeAreaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $midwifeArea = MidwifeArea::with(['areas.subDistrict', 'user' => function ($query) {
                return $query->select('id', 'full_name');
            }])->select('midwife_areas.*');

            return DataTables::eloquent($midwifeArea)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionButtons = '<div class="btn-list flex-nowrap text-center">
                                            <a class="btn btn-icon btn-danger" id="btnDelete" data-id="' . $data->id . '" >
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                            </a>
                                        </div>';
                    return $actionButtons;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->diffForHumans();
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $midwifes = User::where('role_id', 2)->get();

        $areas = Area::with('subDistrict')
            ->latest()
            ->get();

        $subDistrcits = SubDistrict::where('status', true)->get();

        return view('app.admin.midwife-areas', [
            'midwifes' => $midwifes,
            'areas' => $areas,
            'subDistrcits' => $subDistrcits
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('midwife', 'subDistrict', 'area'), [
            'midwife' => 'required|in:' . implode(',', User::pluck('id')->toArray()),
            'subDistrict' => 'required|in:' . implode(',', SubDistrict::pluck('id')->toArray()),
            'area' => 'required|in:' . implode(',', Area::pluck('id')->toArray())
        ], [
            'midwife.required' => 'Nama Bidan harus diisi.',
            'midwife.in' => 'Bidan tidak valid.',
            'subDistrict.required' => 'Kelurahan harus diisi.',
            'subDistrict.in' => 'Kelurahan tidak valid.',
            'area.required' => 'RW harus diisi.',
            'area.in' => 'RW tidak valid.'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $area = MidwifeArea::create([
            'midwife_id' => $request->input('midwife'),
            'area_id' => $request->input('area')
        ]);

        if ($area) {
            return response()->json([
                'status' => true,
                'message' => 'Penempatan Bidan berhasil dibuat'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Penempatan Bidan gagal dibuat'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $midwifeArea = MidwifeArea::find($id);

        if (!$midwifeArea) {
            return response()->json([
                'status' => false,
                'message' => 'Penempatan Bidan tidak ditemukan'
            ], 404);
        }

        $checkArea = MidwifeArea::where('area_id', $request->input('area'))
            ->exists();

        if ($checkArea) {
            return response()->json([
                'status' => false,
                'message' => 'Bidan sudah ditetapkan'
            ], 200);
        }

        $midwifeArea->update([
            'midwife_id' => $request->input('midwife'),
            'area_id' => $request->input('area')
        ]);

        if ($midwifeArea->wasChanged()) {
            return response()->json([
                'status' => true,
                'message' => 'Penempatan Bidan berhasil terupdate'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Penempatan Bidan gagal terupdate'
        ], 200);
    }

    public function destroy($id)
    {
        $midwifeArea = MidwifeArea::find($id);
        if (!$midwifeArea) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Penempatan Bidan'
            ], 404);
        }

        $midwifeArea->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus Penempatan Bidan'
        ], 200);
    }

    public function getRa(Request $request)
    {
        $idSubDistrict = $request->input('id');
        $midwifeArea = Area::where('sub_district_id', $idSubDistrict)
            ->whereDoesntHave('midwifeAreas')
            ->get();

        if (!$midwifeArea) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $midwifeArea
        ], 200);
    }
}
