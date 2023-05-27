<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\CreateFileHistory;
use App\Models\Infos;
use Illuminate\Http\Request;

class Analytics extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $info = Infos::where('user_id', $user_id)->first();
        $history = CreateFileHistory::where('user_id', $user_id)->with('notifications')->orderBy('created_at', 'DESC')->paginate(10);
        // dd($history);
        return view('content.dashboard.dashboards-analytics')
            ->with('info', $info)
            ->with('history', $history);
    }
}
