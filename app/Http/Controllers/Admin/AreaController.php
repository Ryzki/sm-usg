<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubDistrict;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subDistricts = Area::with(['subDistrict' => function ($query) {
                return $query->select('id', 'name');
            }]);

            return DataTables::eloquent($subDistricts)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionButtons = '<div class="btn-list flex-nowrap text-center">
                                        <a class="btn btn-icon btn-warning" id="btnEdit" data-ra="' . $data->residential_association . '" data-subdistrict="' . $data->sub_district_id . '" data-id="' . $data->id . '" >
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

        $subDistricts = SubDistrict::where('status', 1)->get();

        return view('app.admin.areas', [
            'subDistricts' => $subDistricts
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('subdistrict', 'RA'), [
            'subdistrict' => 'required|string',
            'RA' => 'required'
        ], [
            'subdistrict.required' => 'Nama Kelurahan harus diisi.',
            'RA.required' => 'RW harus diisi.'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $checkArea = Area::where('sub_district_id', $request->input('subdistrict'))
            ->where('residential_association',  $request->input('RA'))
            ->first();

        if ($checkArea) {
            return response()->json([
                'status' => false,
                'message' => 'Daerah sudah tersedia'
            ], 200);
        }

        $area = Area::create([
            'sub_district_id' => $request->input('subdistrict'),
            'residential_association' => $request->input('RA')
        ]);

        if ($area) {
            return response()->json([
                'status' => true,
                'message' => 'Daerah berhasil dibuat'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daerah gagal dibuat'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json([
                'status' => false,
                'message' => 'Daerah tidak ditemukan'
            ], 404);
        }

        $area->update([
            'sub_district_id' => $request->input('subdistrict'),
            'residential_association' => $request->input('RA')
        ]);

        if ($area->wasChanged()) {
            return response()->json([
                'status' => true,
                'message' => 'Daerah berhasil terupdate'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Daerah gagal terupdate'
        ], 200);
    }

    public function destroy($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Daerah'
            ], 404);
        }

        $area->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus Daerah'
        ], 200);
    }

    public function changeStat(Request $request)
    {
        $stat = $request->input('stat');

        $area = Area::find($request->input('id'));

        if ($area) {
            $area->update([
                'status' => !$stat // Toggle status
            ]);

            if ($area->wasChanged()) { // Periksa apakah ada perubahan pada model
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
