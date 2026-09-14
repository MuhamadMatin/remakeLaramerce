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

    $validate = Validator($request->all(), [
      'name'        => 'required',
      'slug'        => 'required|unique:categories,slug',
      'description' => 'sometimes|nullable',
    ]);

    if ($validate->fails()) {
      return redirect()->route('dashboard.categories.create')->withErrors($validate)->withInput();
    }
    // dd($request->all());

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
      return redirect()->route('/dashboard/categories');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('/dashboard/categories/add')->with('err', 'Failed create category');
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Category $category)
  {
    return Inertia('Dashboard/Categories/edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Category $category)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    //
  }

  /**
   * Bulk delete categories.
   */
  public function bulkDestroy(Request $request)
  {
    $request->validate(['ids' => 'required|array']);
    Category::whereIn('id_category', $request->ids)->delete();
    return back();
  }
}
