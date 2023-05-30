<?php

namespace App\Http\Controllers\Api;

use App\Models\Infos;
use App\Models\Notification;
use Illuminate\Http\Request;

class CreateFileController extends ApiController
{
    public function store(Request $request)
    {
        // dd($request);
        $notification = new Notification;
        $notification->user_id = $request->header('userid');
        $notification->create_file_id = $request->create_file_id;
        $notification->content = $request->content;
        if (isset($request->zone)) {
            $notification->zone = $request->zone;
        }
        $notification->save();
        return $this->respondSuccess('Thêm thông báo thành công');
    }

    public function storeAll(Request $request)
    {

    }

    public function updateTime(Request $request, $time)
    {
        $user_id = $request->header('userid');
        $info = Infos::where('user_id', $user_id)->first();
        if ($info) {
            $info->lansudung = $info->lansudung - $time;
            if ($info->lansudung < 0) {
                $info->lansudung = 0;
            }
            $info->save();
            return $this->respondSuccess('Sửa thành công.');
        } else {
            return $this->respondNotFound("Cập nhật thông tin thất bại.");
        }
    }
}
