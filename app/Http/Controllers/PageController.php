<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Menampilkan semua halaman
    // public function index()
    // {
    //     $pages = Page::orderBy('created_at', 'DESC')->get();
    //     return view('pages.index', compact('pages'));
    // }

    public function index()
    {
        if (request()->ajax()) {
            $requestData = request();
            $start = (int) $requestData->input('start', 0);
            $length = (int) $requestData->input('length', 10);
            $search = $requestData->input('search.value');

            $baseQuery = Page::query();

            if ($requestData->filled('month')) {
                $baseQuery->whereMonth('created_at', $requestData->input('month'));
            }

            if ($requestData->filled('year')) {
                $baseQuery->whereYear('created_at', $requestData->input('year'));
            }

            $recordsTotal = (clone $baseQuery)->count();

            if (!empty($search)) {
                $baseQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%");
                });
            }

            $recordsFiltered = (clone $baseQuery)->count();

            $items = $baseQuery
                ->latest('created_at')
                ->skip($start)
                ->take($length == -1 ? $recordsFiltered : $length)
                ->get();

            $data = [];
            foreach ($items as $index => $row) {
                $previewUrl = url('/preview/' . $row->id);
                $editUrl = route('pages.edit', $row->id);
                $updatedRaw = $row->getRawOriginal('updated_at');
                $updatedAt = $updatedRaw ? Carbon::parse($updatedRaw)->format('d M Y H:i') : '-';

                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'title' => e($row->title),
                    'short_description' => e(Str::limit($row->short_description, 120)),
                    'updated_at' => $updatedAt,
                    'aksi' => '<div class="btn-group" role="group">
                                <a href="' . $previewUrl . '" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary" title="Pratinjau (by ID)"><i class="fas fa-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-warning edit-btn" 
                                        title="Ubah"
                                        data-id="' . $row->id . '"
                                        data-title="' . e($row->title) . '"
                                        data-short_description="' . e($row->short_description) . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="' . route('pages.landing', ['slug' => Str::slug($row->title)]) . '" target="_blank" rel="noopener" class="btn btn-sm btn-outline-info" title="Pratinjau (by Slug)"><i class="fas fa-link"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="' . $row->id . '" title="Hapus"><i class="fas fa-trash"></i></button>
                              </div>',
                ];
            }

            return response()->json([
                'draw' => (int) $requestData->input('draw'),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }

        return view('pages.admin.pageBuilder.index', [
            'title' => 'Page Builder',
            'heading' => 'Page Builder',
            'months' => monthOption(),
            'years' => getAvailableYears(Page::class, 'created_at'),
        ]);
    }

    // Preview by slug (title-based URL)
    public function landingBySlug(string $slug)
    {
        $page = Page::select(['id','title','short_description','content','updated_at'])->get()
            ->first(function ($p) use ($slug) {
                return Str::slug($p->title) === $slug;
            });

        abort_if(!$page, 404);

        return view('pages.landingPagePreview', compact('page'));
    }

    // Menampilkan formulir untuk membuat halaman baru
    public function create()
    {
        return view('pages.create');
    }

    // Menyimpan halaman baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required'
        ]);
        $jsonFilePath = storage_path('app/public/default.json');
        $jsonContent = file_get_contents($jsonFilePath);

        $requestData = $request->all();
        $requestData['content'] = $jsonContent;

        Page::create($requestData);

        return redirect()->route('pages.index')->with('success', 'Page created successfully');
    }

    // Menampilkan halaman tertentu
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.preview', compact('page'));
    }

    // Menampilkan formulir untuk mengedit halaman
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    // Memperbarui halaman dalam database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required'
        ]);

        $page = Page::findOrFail($id);
        $page->update($request->only(['title', 'short_description']));

        if ($request->ajax()) {
            return response()->json(['message' => 'Page updated successfully']);
        }

        return redirect()->route('pages.index')->with('success', 'Page updated successfully');
    }

    // Menghapus halaman dari database
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Page deleted successfully']);
        }

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully');
    }

}
