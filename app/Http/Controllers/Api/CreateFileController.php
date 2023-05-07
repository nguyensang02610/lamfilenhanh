<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\Request;

class CreateFileController extends ApiController
{
    public function store(Request $request)
    {
        // dd($request);
        $notification = new Notification;
        $notification->user_id = $request->user_id;
        $notification->create_file_id = $request->create_file_id;
        $notification->content = $request->content;
        $notification->save();
        return $this->respondSuccess('Thêm thông báo thành công');
    }
}
