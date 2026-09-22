<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = Brand::query();

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

    $per_page = $request->per_page ?? 10;
    $brands   = $query->paginate($per_page)->withQueryString();

    return Inertia('Dashboard/Brands/index', [
      'brands'  => $brands,
      'filters' => $request->only(['search', 'sort', 'direction', 'per_page', 'date_from', 'date_to']),
    ]);
  }

/**
 * Show the form for creating a new resource.
 */
  public function create()
  {
    return Inertia('Dashboard/Brands/add');
  }

/**
 * Store a newly created resource in storage.
 */
  public function store(Request $request)
  {
    $validate = Validator::make($request->all(), [
      'name'        => 'required',
      'slug'        => 'required|unique:brands,slug',
      'description' => 'sometimes|nullable',
      'image'       => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validate->fails()) {
      return redirect()->route('dashboard.brands.create')->withErrors($validate)->withInput();
    }

    DB::beginTransaction();
    try {
      $image_path = null;
      if ($request->image) {
        $image_path = $request->file('image')->store('brands', 'public');
      }

      $brand = Brand::create([
        'id_brand'    => strtotime(now()) . uniqid(),
        'name'        => $request->name,
        'slug'        => Str::slug($request->slug),
        'description' => $request->description,
        'image_path'  => $image_path,
        'created_by'  => Auth::id(),
        'created_at'  => now(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.brands.index');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('dashboard.brands.create')->with('err', 'Failed create brand');
    }
  }

/**
 * Show the form for editing the specified resource.
 */
  public function edit(Brand $brand)
  {
    return Inertia('Dashboard/Brands/edit', compact('brand'));
  }

/**
 * Update the specified resource in storage.
 */
  public function update(Request $request, Brand $brand)
  {
    $validate = Validator::make($request->all(), [
      'name'        => 'required',
      'slug'        => 'required|unique:brands,slug,' . $brand->id_brand . ',id_brand',
      'description' => 'sometimes|nullable',
      'image'       => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validate->fails()) {
      return redirect()->route('dashboard.brands.edit', $brand->slug)->withErrors($validate)->withInput();
    }

    DB::beginTransaction();
    try {
      $image_path = $brand->image_path;
      if ($request->image && Storage::disk('public')->exists($image_path)) {
          Storage::disk('public')->delete($image_path);

        $image_path = $request->file('image')->store('brands', 'public');
      }

      $brand->update([
        'name'        => $request->name,
        'slug'        => Str::slug($request->slug),
        'description' => $request->description,
        'image_path'  => $image_path,
        'updated_by'  => Auth::id(),
        'updated_at'  => now(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.brands.index');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('dashboard.brands.edit', $brand->slug)->with('err', 'Failed update brand');
    }
  }

/**
 * Remove the specified resource from storage.
 */
  public function destroy(Brand $brand)
  {
    DB::beginTransaction();
    try {
      $brand->deleted_at = now();
      $brand->deleted_by = Auth::id();
      $brand->save();
      $brand->delete();

      DB::commit();
      return redirect()->route('dashboard.brands.index')->withSuccess('Success delete brand')->withInput();
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('dashboard.brands.index')->withErrors(['error' => 'Gagal delete brand'])->withInput();
    }
  }

  public function bulkDestroy(Request $request)
  {
    $validate = Validator::make($request->all(), ['ids' => 'required|array']);

    if ($validate->fails()) {
      return redirect()->route('dashboard.brands.index')->withErrors($validate)->withInput();
    }

    try {
      $brands = Brand::whereIn('id_brand', $request->ids)->update([
        "deleted_at" => now(),
        "deleted_by" => Auth::id(),
      ]);

      DB::commit();
      return redirect()->route('dashboard.brands.index')->withSuccess('Success delete brand')->withInput();
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('dashboard.brands.index')->withErrors(['error' => 'Gagal delete brand'])->withInput();
    }
  }
}
