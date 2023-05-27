<?php

namespace App\Http\Controllers\Api;

use App\Models\CreateFileHistory;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    public function index(Request $request)
    {
        // dd($request->user());
        $user_id = $request->header('userid');
        $history = CreateFileHistory::where('user_id', $user_id)->with('notifications')->orderBy('created_at', 'DESC')->take(50)->paginate(5);
        return $this->respondSuccess($history);
    }
}
