<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infos;

class Analytics extends Controller
{
  public function index(Request $request)
  {
    $user_id = $request->user()->id;
    $info = Infos::where('user_id', $user_id)->first();
    // dd($info);
    return view('content.dashboard.dashboards-analytics', ['info' => $info]);
  }
}