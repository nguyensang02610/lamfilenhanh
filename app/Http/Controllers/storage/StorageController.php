<?php

namespace App\Http\Controllers\storage;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        return view('content.tables.tables-datatables-advanced', compact('user_id'));
    }

    public function getStorageByUserId($user_id)
    {
        $storage = Storage::where('user_id', $user_id)->orderBy('ma_hinh')->get();
        if ($storage) {
            return response()->json(['data' => $storage], 200);
        } else {
            return response()->json(['error' => 'Storage not found'], 404);
        }
    }

    public function excelsave(Request $request)
    {
        $user_id = $request->user()->id;
        $file = $request->file('excelfile');
        $inputFileType = IOFactory::identify($file);
        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getSheetByName('sheet');
        $data = $worksheet->toArray();
        foreach (array_slice($data, 1) as $row) {
            try {
                $storage = new Storage;
                $storage->user_id = $user_id;
                $storage->ma_hinh = $row[0];
                $storage->dong_may = $row[1];
                $storage->note = $row[2];
                $storage->save();
            } catch (\Exception $e) {
                // Xử lý ngoại lệ khi thiếu thông tin
                return;
            }
        }

        return redirect()->back();
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
        $kho->save();
        return redirect()->back()->with('success', 'Info saved successfully.');
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
        $kho = Storage::findorFail($id);
        $kho->ma_hinh = $request->ma_hinh;
        $kho->dong_may = $request->dong_may;
        $kho->note = $request->note;
        $kho->save();

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Storage::destroy($id);
    }
}
