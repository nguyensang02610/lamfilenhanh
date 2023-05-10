<?php

namespace App\Http\Controllers\Api;

use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $storage = Storage::where('user_id', $user_id)->orderBy('ma_hinh')->get();
        // dd($storage);
        if ($storage) {
            return $this->respondSuccess($storage);
        } else {
            return $this->respondUnprocessableEntity('Not Found Item');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;

        if ($request->so_luong == null) {
            $so_luong = 1;
        } else {
            $so_luong = $request->so_luong;
        }

        if ($request->ma_hinh == null || $request->dong_may == null) {
            return $this->respondUnprocessableEntity('Thêm mới thất bại');
        }

        $check_kho = Storage::where('user_id', $user_id)
            ->where('ma_hinh', $request->ma_hinh)
            ->where('dong_may', 'LIKE', $request->dong_may)
            ->first();

        if ($check_kho) {
            $check_kho->so_luong = $check_kho->so_luong + $so_luong;
            if ($check_kho->save()) {
                $noti = "Thêm số lượng : " . $so_luong . " vào mã: " . $request->ma_hinh . ", dòng máy: " . $request->dong_may;
                return $this->respondSuccess($noti);
            } else {
                return $this->respondUnprocessableEntity('Thêm mới thất bại');
            }
        }

        $kho = new Storage;
        $kho->user_id = $user_id;
        $kho->ma_hinh = $request->ma_hinh;
        $kho->dong_may = $request->dong_may;
        $kho->so_luong = $so_luong;
        $kho->note = $request->note;
        if ($kho->save()) {
            return $this->respondSuccess("Thêm mới thành công");
        } else {
            return $this->respondUnprocessableEntity('Thêm mới thất bại');
        }
    }

    public function ExcelUpload(Request $request)
    {
        $user_id = $request->user()->id;
        $data = $request->data;
        foreach ($data as $item) {
            if ($item['dong_may'] == null || $item['ma_hinh'] == null) {
                continue;
            }
            $check_kho = Storage::where('user_id', $user_id)
                ->where('ma_hinh', $item['ma_hinh'])
                ->where('dong_may', 'LIKE', $item['dong_may'])
                ->first();

            if ($check_kho) {
                $check_kho->so_luong = $check_kho->so_luong + $item['so_luong'];
                $check_kho->note = $check_kho->note . $item['note'];
                if ($check_kho->save()) {
                    $noti = "Thêm số lượng : " . $item['so_luong'] . " vào mã: " . $item['ma_hinh'] . ", dòng máy: " . $item['dong_may'];
                    continue;
                } else {
                    continue;
                }
            }

            $kho = new Storage;
            $kho->user_id = $user_id;
            $kho->ma_hinh = $item['ma_hinh'];
            $kho->dong_may = $item['dong_may'];
            $kho->so_luong = $item['so_luong'];
            $kho->note = $item['note'];
            if ($kho->save()) {
                continue;
            } else {
                continue;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kho = Storage::find($id);
        if ($kho) {
            $kho->ma_hinh = $request->ma_hinh;
            $kho->dong_may = $request->dong_may;
            $kho->so_luong = $request->so_luong;
            $kho->note = $request->note;
            if ($kho->save()) {
                return $this->respondSuccess("Cập nhật thành công");
            } else {
                return $this->respondError('Cập nhật thất bại');
            }
        } else {
            return $this->respondError('Không tìm thấy đối tượng cần cập nhật', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Storage::destroy($id);
        if ($status) {
            return $this->respondSuccess("Xóa thành công");
        } else {
            return $this->respondError('Xóa thất bại', 400);
        }
    }

    public function findByType(Request $request)
    {
        // dd($request);
        $user_id = $request->user()->id;
        $storage = Storage::where('user_id', $user_id)->get();

        if (count($storage) > 0) {
            return $this->respondSuccess($storage);
        } else {
            return null;
        }
    }
}
