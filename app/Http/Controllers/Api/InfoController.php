<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infos;
class InfoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Infos::where('user_id', $id)->first();
        if ($info) {
            return $this->respondSuccess([$info]);
        } else {
            return $this->respondNotFound(['Không tìm thấy dữ liệu.']);
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
        // dd($request);
        $existingInfo = Infos::where('user_id',$id)->first();
        if ($existingInfo) {
            $existingInfo->sourcefolder = $request->sourcefolder;
            $existingInfo->exportfolder = $request->exportfolder;
            $existingInfo->exportname = $request->exportname;
            if($existingInfo->save()){
                return $this->respondSuccess(["Cập nhật thông tin thành công."]);
            }else{
                return $this->respondNotFound(["Cập nhật thông tin thất bại."]);
            }
        } else {
            $info = new Infos;
            $info->user_id = $id;
            $info->sourcefolder = $request->sourcefolder;
            $info->exportfolder = $request->exportfolder;
            $info->exportname = $request->exportname;
            if($info->save()){
                return $this->respondSuccess(["Cập nhật thông tin thành công."]);
            }else{
                return $this->respondNotFound(["Cập nhật thông tin thất bại."]);
            }
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
        //
    }
}