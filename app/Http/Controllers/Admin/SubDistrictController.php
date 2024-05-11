<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubDistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubDistrictController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $subDistricts = SubDistrict::query();

            return DataTables::eloquent($subDistricts)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionButtons = '<div class="btn-list flex-nowrap text-center">
                                        <a class="btn btn-icon btn-warning" id="btnEdit" data-name="' . $data->name . '" data-id="' . $data->id . '" >
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                        </a>';

                    if (!$data->status) {
                        $actionButtons .= '<a class="btn btn-icon btn-success" id="btnChangeStat" data-stat="' . $data->status . '" data-id="' . $data->id . '" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            </a>';
                    } else {
                        $actionButtons .= '<a class="btn btn-icon btn-danger" id="btnChangeStat" data-stat="' . $data->status . '" data-id="' . $data->id . '" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                            </a>';
                    }

                    $actionButtons .= '</div>';

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

        return view('app.admin.sub-district');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('subdistrict'), [
            'subdistrict' => 'required|string',
        ], [
            'subdistrict.required' => 'Nama Kelurahan harus diisi.',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $user = SubDistrict::create([
            'name' => $request->input('subdistrict'),
        ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Pengguna berhasil dibuat'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pengguna gagal dibuat'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $subDistrict = SubDistrict::find($id);

        if (!$subDistrict) {
            return response()->json([
                'status' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $subDistrict->update([
            'name' => $request->input('subdistrict')
        ]);

        if ($subDistrict->wasChanged()) {
            return response()->json([
                'status' => true,
                'message' => 'Data Kelurahan berhasil terupdate'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data Kelurahan gagal terupdate'
        ], 200);
    }

    public function changeStat(Request $request)
    {
        $stat = $request->input('stat');

        $subDistrict = SubDistrict::find($request->input('id'));

        if ($subDistrict) {
            $subDistrict->update([
                'status' => !$stat
            ]);

            if ($subDistrict->wasChanged()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Status berhasil terupdate'
                ], 200);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Data gagal terupdate'
        ], 200);
    }
}
