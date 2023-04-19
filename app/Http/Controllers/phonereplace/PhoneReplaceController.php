<?php

namespace App\Http\Controllers\phonereplace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\PhoneReplace;

class PhoneReplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        return view('content.phone-replace.phone-replace')->with('user_id', $user_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
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
        $phone = new PhoneReplace;
        $phone->user_id = $user_id;
        $phone->dong_may = $request->dong_may;
        $phone->dong_may_thay = $request->dong_may_thay;
        $phone->note = $request->note;
        $phone->save();
        return redirect()->back();
    }


    public function excelsave(Request $request){
        $user_id = $request->user()->id;
        $file = $request->file('excelfile');
        $inputFileType = IOFactory::identify($file);
        $reader  = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getSheetByName('sheet');
        $data = $worksheet->toArray();
        foreach (array_slice($data, 1) as $row){
            try {
                $phone = new PhoneReplace;
                $phone->user_id = $user_id;
                $phone->dong_may = $row[0];
                $phone->dong_may_thay = $row[1];
                $phone->note = $row[2];
                $phone->save();
            } catch (\Exception $e) {
                // Xử lý ngoại lệ khi thiếu thông tin
                return;
            }
        }

        return redirect()->back();
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
        if($phones) {
            return response()->json(['data' => $phones], 200);
        } else {
            return response()->json(['error' => 'Storage not found'], 404);
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