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
        if (count($storage) > 0) {
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
        $kho = new Storage;
        $kho->user_id = $user_id;
        $kho->ma_hinh = $request->ma_hinh;
        $kho->dong_may = $request->dong_may;
        $kho->note = $request->note;
        if ($kho->save()) {
            return $this->respondSuccess("Thêm mới thành công");
        } else {
            return $this->respondUnprocessableEntity('Thêm mới thất bại');
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