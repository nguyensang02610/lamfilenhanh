<?php

namespace App\Http\Controllers\info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infos;
use Illuminate\Support\FacadesFile;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use File;

class InfoController extends Controller
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
        $existingInfo = Infos::where('user_id', $request->user()->id)->first();
        if ($existingInfo) {
            $existingInfo->sourcefolder = $request->sourcefolder;
            $existingInfo->exportfolder = $request->exportfolder;
            $existingInfo->exportname = $request->exportname;
            $existingInfo->save();
            return redirect()->back()->with('success', 'Info updated successfully.');
        } else {
            $info = new Infos;
            $info->user_id = $request->user()->id;
            $info->sourcefolder = $request->sourcefolder;
            $info->exportfolder = $request->exportfolder;
            $info->exportname = $request->exportname;
            $info->save();
            return redirect()->back()->with('success', 'Info saved successfully.');
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
        //
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
        //
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