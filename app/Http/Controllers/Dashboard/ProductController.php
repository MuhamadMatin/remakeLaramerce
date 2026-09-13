<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia('Dashboard/Products/index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia('Dashboard/Products/add');
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
  public function edit(Product $product)
  {
    return Inertia('Dashboard/Products/edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    //
  }
}
