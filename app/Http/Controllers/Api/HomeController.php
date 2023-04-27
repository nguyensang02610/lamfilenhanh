<?php

namespace App\Http\Controllers\Api;

use App\Models\CreateFileHistory;
use App\Models\Infos;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    public function index(Request $request)
    {
        // dd($request->user());
        $user_id = $request->user()->id;
        $info = Infos::where('user_id', $user_id)->first();
        $history = CreateFileHistory::where('user_id', $user_id)->with('notifications')->orderBy('created_at', 'DESC')->paginate(10);
        return $this->respondSuccess(['info' => $info, 'history' => $history]);
    }
}
