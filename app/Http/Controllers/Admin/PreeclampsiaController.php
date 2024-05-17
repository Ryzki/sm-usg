<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MidwifeArea;
use App\Models\PreeclampsiaScreening;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PreeclampsiaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $preeclamsia = PreeclampsiaScreening::query();

            return DataTables::eloquent($preeclamsia)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $actionButtons = '<div class="btn-list flex-nowrap text-center">
                                        <a class="btn btn-icon btn-warning" id="btnEdit" data-name="' . $data->screening_name . '" data-risk="' . $data->risk_category . '"data-id="' . $data->id . '" >
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                        </a>
                                        <a class="btn btn-icon btn-danger" id="btnDelete" data-id="' . $data->id . '" >
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
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
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->diffForHumans();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('app.admin.preeclampsia');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only(['screening_name', 'risk_category']), [
            'screening_name' => 'required',
            'risk_category' => 'required|in:1,2',
        ], [
            'screening_name.required' => 'Nama Skreaning harus diisi.',
            'risk_category.required' => 'Kategori Resiko harus diisi.',
            'risk_category.in' => 'Kategori Resiko tidak valid'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $preeclamsiaScreening = PreeclampsiaScreening::create([
            'screening_name' => $request->input('screening_name'),
            'risk_category' => $request->input('risk_category')
        ]);

        if ($preeclamsiaScreening) {
            return response()->json([
                'status' => true,
                'message' => 'Skreaning Preklamsia berhasil dibuat'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Skreaning Preklamsia gagal dibuat'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $preeclampsiaScreening = PreeclampsiaScreening::find($id);

        if (!$preeclampsiaScreening) {
            return response()->json([
                'status' => false,
                'message' => 'Skreaning Preklamsia tidak ditemukan'
            ], 404);
        }

        $preeclampsiaScreening->update([
            'screening_name' => $request->input('screening_name'),
            'risk_category' => $request->input('risk_category')
        ]);

        if ($preeclampsiaScreening->wasChanged()) {
            return response()->json([
                'status' => true,
                'message' => 'Skreaning Preklamsia berhasil terupdate'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Skreaning Preklamsia gagal terupdate'
        ], 200);
    }

    public function destroy($id)
    {
        $preeclamsiaScreening = PreeclampsiaScreening::find($id);
        if (!$preeclamsiaScreening) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Skrining Preklamsia'
            ], 404);
        }

        $preeclamsiaScreening->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus Skrining Preklamsia'
        ], 200);
    }

    public function changeStat(Request $request)
    {
        $stat = $request->input('stat');

        $preeclamsiaScreening = PreeclampsiaScreening::find($request->input('id'));

        if ($preeclamsiaScreening) {
            $preeclamsiaScreening->update([
                'status' => !$stat
            ]);

            if ($preeclamsiaScreening->wasChanged()) {
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
