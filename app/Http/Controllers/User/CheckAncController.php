<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\ScheduleANC;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\HistoryANC;
use App\Models\PatientPreeclamsiaScreenings;
use Illuminate\Support\Facades\Auth;
use App\Models\PreeclampsiaScreening;
use Illuminate\Support\Facades\Validator;

class CheckAncController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $visits = Visit::with('scheduleAncs')
            ->with(['scheduleAncs' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return view('app.user.anc-visit', compact('visits'));
    }

    public function create($name_anc, $schedule_date)
    {
        $user = Auth::user();
        $formatDate = Carbon::createFromFormat('d-m-Y', $schedule_date)->format('Y-m-d');
        $checkVisit = ScheduleANC::with(['visit', 'user'])
            ->whereHas('visit', function ($query) use ($name_anc) {
                $query->where('abbreviation', $name_anc);
            })
            ->where('schedule_date', '=', $formatDate)
            ->where('user_id', '=', $user->id)
            ->where('status', 0)
            ->first();

        $categoriesPreeclamsia = PreeclampsiaScreening::get();

        // return response()->json($checkVisit);
        if (!empty($checkVisit)) {
            return view('app.user.create-anc-visit', compact('checkVisit', 'categoriesPreeclamsia'));
        }

        return redirect()->route('user.check-anc.index')->with('message', 'Terdapat kesalahan!! Tolong masuk kembali');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'visit_abbreviation' => 'required',
            'schedule_date' => 'required',
            'age' => 'required',
            'gestational_age' => 'required',
            'weight' => 'required',
            'height' => 'required',
            'lila' => 'required',
            'sistolik_diastolik' => 'required',
            'hemoglobin_level' => 'required',
            'category_preeclamsia' => Rule::in(PreeclampsiaScreening::pluck('id')->toArray()),
            'usg_image' => 'required|image|mimes:jpg,jpeg,png|max:3048',
            'note' => 'max:200'
        ]);

        if ($request->input('visit_id') && $request->input('schedule_id')) {
            $idVisit = $request->input('visit_id');
            $idSchedule = $request->input('schedule_id');
            $sistolik_diastolik = explode('/', $request->input('sistolik_diastolik'));

            $dataHistoryAnc = [
                'user_id' => Auth::user()->id,
                'visit_id' => $idVisit,
                'inspection_date' => Carbon::parse($request->input('schedule_date'))->format('Y-m-d'),
                'age' => $request->input('age'),
                'gestational_age' => $request->input('gestational_age'),
                'weight' => $request->input('weight'),
                'height' => $request->input('height'),
                'lila' => $request->input('lila'),
                'sistolik' => $sistolik_diastolik[0],
                'diastolik' => $sistolik_diastolik[1],
                'hemoglobin_level' => $request->input('hemoglobin_level'),
                'note' => $request->input('note')
            ];

            if ($request->file('usg_image')) {
                $nameImage = Str::random(30) . '.' . $request->file('usg_image')->getClientOriginalExtension();
                $request->file('usg_image')->storeAs('public/usg', $nameImage);

                $dataHistoryAnc['usg_img'] = $nameImage;
            }

            if (!empty($request->input('category_preeclamsia'))) {
                $codeUnique = Str::random(5);

                foreach ($request->input('category_preeclamsia') as $value) {
                    PatientPreeclamsiaScreenings::create([
                        'code_history' => $codeUnique,
                        'preeclampsia_screenings_id' => $value
                    ]);
                }

                $dataHistoryAnc['history_skrining_preklampsia_code'] = $codeUnique;
                $dataHistoryAnc['stat_skrining_preklampsia'] = $this->statPreeclamsia($request->input('category_preeclamsia'));
            } else {
                $dataHistoryAnc['history_skrining_preklampsia_code'] = null;
                $dataHistoryAnc['stat_skrining_preklampsia'] = 0;
            }

            // dd($dataHistoryAnc);

            $historyAnc = HistoryANC::create($dataHistoryAnc);
            $scheduleANC  = ScheduleANC::find($idSchedule);

            if ($historyAnc && $scheduleANC) {
                $scheduleANC->update([
                    'status' => 1
                ]);

                return redirect()->route('user.check-anc.index')->with('success', 'Data Berhasil tersimpan');
            } else {
                return redirect()->route('user.check-anc.index')->with('message', 'Data Gagal tersimpan');
            }
        }

        return redirect()->route('user.check-anc.index')->with('message', 'Data Gagal tersimpan');
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
    }

    private function statPreeclamsia($request)
    {
        $categories = $request;
        $lowRiskCount = 0;
        $highRiskCount = 0;

        foreach ($categories as $categoryId) {
            $preeclampsiaScreening = PreeclampsiaScreening::find($categoryId);
            if ($preeclampsiaScreening) {
                if ($preeclampsiaScreening->risk_category == 1) {
                    $lowRiskCount++;
                } elseif ($preeclampsiaScreening->risk_category == 2) {
                    $highRiskCount++;
                }
            }
        }

        if ($lowRiskCount < 2 && $highRiskCount == 0) {
            $riskCategory = 1;
        } else if ($lowRiskCount == 0 && $highRiskCount == 1) {
            $riskCategory = 2;
        } else {
            $riskCategory = 2;
        }

        return $riskCategory;
    }
}
