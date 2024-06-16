<?php

namespace App\Http\Controllers\User;

use DOMDocument;
use App\Models\Education;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class EducationController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $educations = Education::with(['user']);

            return DataTables::eloquent($educations)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionButtons = '<div class="btn-list flex-nowrap text-center">
                                        <a class="btn btn-icon btn-warning" id="btnEdit" data-id="" >
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                        </a>
                                        ';
                    $actionButtons .= '</div>';

                    return $actionButtons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('app.admin.education.index');
    }

    public function create()
    {
        return view('app.admin.education.store');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('title', 'slug', 'thumbnail', 'content'), [
            'title' => 'required|unique:education,title',
            'slug' => 'required|unique:education,slug',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:2024',
            'content' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ],  [
            'title.required' => 'Judul harus diisi.',
            'title.unique' => 'Judul sudah ada, silakan pilih judul lain.',
            'slug.required' => 'Slug harus diisi.',
            'slug.unique' => 'Slug sudah ada, silakan pilih slug lain.',
            'thumbnail.required' => 'Thumbnail harus diunggah.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat png, jpg, atau jpeg.',
            'thumbnail.max' => 'Ukuran thumbnail tidak boleh lebih dari 2MB.',
            'content.required' => 'Konten harus diunggah.',
            'content.image' => 'Konten harus berupa gambar.',
            'content.mimes' => 'Konten harus berformat png, jpg, atau jpeg.',
            'content.max' => 'Ukuran konten tidak boleh lebih dari 2MB.'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 400);
        }

        $nameThumbnail = Str::random(30) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
        $request->file('thumbnail')->storeAs('public/edu_thumb', $nameThumbnail);

        $nameContent = Str::random(30) . '.' . $request->file('content')->getClientOriginalExtension();
        $request->file('content')->storeAs('public/edu_content', $nameContent);

        $education = Education::create([
            'author_id' => Auth::user()->id,
            'category_id' => 1,
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'thumbnail' => $nameThumbnail,
            'content_img' => $nameContent,
        ]);

        if ($education) {
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil disimpan'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data Gagal disimpan'
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
    }

    public function indexForUser()
    {
        $educations = Education::where('category_id', 1)->paginate(5);
        return view('app.user.education.index', compact('educations'));
    }

    public function showForUser($slug)
    {
        $education = Education::where('slug', $slug)->first();
        if (!$education) {
            return redirect()->route('user.education.index')->with('message', 'Halaman tidak ditemukan!!');
        }
        return view('app.user.education.show', compact('education'));
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Education::class, 'slug', $request->title);
        return response()->json([
            'slug' => $slug
        ]);
    }

    public function confirmTask(Request $request)
    {
        // $slugExistOnTask = Education::where('slug', $request->input('slug'))->first();
        // if ($slugExistOnTask) {
        // }
    }
}
