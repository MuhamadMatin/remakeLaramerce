<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = Category::query();

    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('slug', 'like', "%{$request->search}%");
      });
    }

    if ($request->date_from) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->date_to) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    $query->orderBy($request->sort ?? 'name', $request->direction ?? 'asc');

    $per_page   = $request->per_page ?? 10;
    $categories = $query->paginate($per_page)->withQueryString();

    return Inertia('Dashboard/Categories/index', [
      'categories' => $categories,
      'filters'    => $request->only(['search', 'sort', 'direction', 'per_page', 'date_from', 'date_to']),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia('Dashboard/Categories/add');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validate = Validator::make($request->all(), [
      'name'        => 'required',
      'slug'        => 'required|unique:categories,slug',
      'description' => 'sometimes|nullable',
    ]);

    if ($validate->fails()) {
      return redirect()->route('dashboard.categories.create')->withErrors($validate)->withInput();
    }

    DB::beginTransaction();
    try {
      $category = Category::create([
        'id_category' => strtotime(now()) . uniqid(),
        'name'        => $request->name,
        'slug'        => Str::slug($request->slug),
        'description' => $request->description,
        'created_by'  => Auth::id(),
        'created_at'  => now(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.categories.index');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('dashboard.categories.create')->with('err', 'Failed create category');
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Category $category)
  {
    return Inertia('Dashboard/Categories/edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Category $category)
  {
    $validate = Validator::make($request->all(), [
      'name'        => 'required',
      'slug'        => 'required|unique:categories,slug,' . $category->id_category . ',id_category',
      'description' => 'sometimes|nullable',
    ]);

    if ($validate->fails()) {
      return redirect()->route('dashboard.categories.edit', $category->slug)->withErrors($validate)->withInput();
    }

    DB::beginTransaction();
    try {
      $category->update([
        'name'        => $request->name,
        'slug'        => Str::slug($request->slug),
        'description' => $request->description,
        'created_by'  => Auth::id(),
        'created_at'  => now(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.categories.index');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('dashboard.categories.edit', $category->slug)->with('err', 'Failed create category');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    DB::beginTransaction();
    try {
      $category->deleted_at = now();
      $category->deleted_by = Auth::id();
      $category->save();
      $category->delete();

      DB::commit();
      return redirect()->route('dashboard.categories.index')->withSuccess('Success delete category')->withInput();
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('dashboard.categories.index')->withErrors(['error' => 'Gagal delete category'])->withInput();
    }
  }

  /**
   * Bulk delete categories.
   */
  public function bulkDestroy(Request $request)
  {
    $validate = Validator::make($request->all(), ['ids' => 'required|array']);

    if ($validate->fails()) {
      return redirect()->route('dashboard.categories.index')->withErrors($validate)->withInput();
    }

    try {
      $categories = Category::whereIn('id_category', $request->ids)->update([
        "deleted_at" => now(),
        "deleted_by" => Auth::id(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.categories.index')->withSuccess('Success delete category')->withInput();
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('dashboard.categories.index')->withErrors(['error' => 'Gagal delete category'])->withInput();
    }
  }
}
