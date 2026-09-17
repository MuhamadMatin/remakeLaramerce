<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia('Dashboard/Settings/index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia('Dashboard/Settings/add');
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
  public function edit(Setting $setting)
  {
    return Inertia('Dashboard/Settings/edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Setting $setting)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Setting $setting)
  {
    //
  }
}
