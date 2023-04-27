<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneReplace;

class PhoneReplaceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user_id = $request->user_id;
        $phone = new PhoneReplace;
        $phone->user_id = $user_id;
        $phone->dong_may = $request->dong_may;
        $phone->dong_may_thay = $request->dong_may_thay;
        $phone->note = $request->note;
        if($phone->save()){
            return $this->respondSuccess("Thêm mới thành công");
        }
        else{
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
        $phones = PhoneReplace::where('user_id', $id)->orderBy('dong_may')->get();
        if(count($phones) > 0) {
            return $this->respondSuccess([$phones]);
        } else {
            return $this->respondUnprocessableEntity('Not Found Item');
        }
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
        $phone = PhoneReplace::find($id);
        if($phone){
            $phone->dong_may = $request->dong_may;
            $phone->dong_may_thay = $request->dong_may_thay;
            $phone->note = $request->note;
            if($phone->save()){
                return $this->respondSuccess("Cập nhật thành công");
            }
            else{
                return $this->respondError('Cập nhật thất bại');
            }
        }else{
            return $this->respondError('Không tìm thấy đối tượng cần cập nhật',400);
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
        $status = PhoneReplace::destroy($id);
        if ($status){
            return $this->respondSuccess("Xóa thành công");
        }else{
            return $this->respondError('Xóa thất bại',400);
        }
    }
}