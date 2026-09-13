<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia('Dashboard/Brands/index');
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
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Brand $brand)
  {
    return Inertia('Dashboard/Brands/edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Brand $brand)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Brand $brand)
  {
    //
  }
}
