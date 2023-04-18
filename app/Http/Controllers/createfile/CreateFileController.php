<?php

namespace App\Http\Controllers\createfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infos;
use Illuminate\Support\FacadesFile;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RealRashid\SweetAlert\Facades\Alert;
// use File;
use Illuminate\Support\Facades\File;

class CreateFileController extends Controller
{

    
    public function replace_dongmay($dong_may) {
        $listmay = [
            [
                "may1" => "ip 7 / 8",
                "may2" => "ip 7",
            ],
            [
                "may1" => "ip 7 / 8 plus",
                "may2" => "ip 7 plus",
            ],
            [
                "may1" => "ip 7 / 8 plus",
                "may2" => "ip 7 plus",
            ],
            [
                "may1" => "ip 6 / 6s",
                "may2" => "ip 6",
            ],
            [
                "may1" => "ip 6 / 6 plus",
                "may2" => "ip 6 plus",
            ],
            [
                "may1" => "ip x / xs",
                "may2" => "ip x",
            ],
            [
                "may1" => "OPPO A33",
                "may2" => "oppo neo 7",
            ],
            [
                "may1" => "OPPO A33 / NEO 7",
                "may2" => "oppo neo 7",
            ],
            [
                "may1" => "Note 6 / Note 6 Pro",
                "may2" => "Redmi note 6",
            ],
            [
                "may1" => "Note 5 / Note 5 Pro",
                "may2" => "redmi note 5",
            ],
            [
                "may1" => "Note 5 / Note 5 Pro",
                "may2" => "redmi note 5",
            ],
            [
                "may1" => "SS J6+ (Plus)",
                "may2" => "SS J6 PLUS",
            ],
            [
                "may1" => "SS A6+ (Plus)",
                "may2" => "SS A6 PLUS",
            ],
            [
                "may1" => "SS A32 (4G)",
                "may2" => "SS A32",
            ],
        ];
    
        foreach ($listmay as $item) {
            if ($dong_may == $item["may1"]) {
                $dong_may = $item["may2"];
                break;
            }
        }
    
        return $dong_may;
    }

    public function create_exsit_file($dest){
        $info = pathinfo($dest);
        $i = 1;
        while (File::exists($info['dirname'] . '\\' . $info['filename'] . " ($i)." . $info['extension'])) {
            $i++;
        }
        $dest = $info['dirname'] . '\\' . $info['filename'] . " ($i)." . $info['extension'];
        return $dest;
    }

    

    public function create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder){
        if ($dong_may == "") {
            return;
        } else {
            // $files = File::files($sourcefolder);
            $file_jpg = File::glob($sourcefolder .'\\'.$ma_hinh.'.jpg');
            $file_png = File::glob($sourcefolder .'\\'.$ma_hinh.'.png');
            if (count($file_jpg) > 0){
                $source = $file_jpg[0];
                $dest = $exportfolder . '\\' . $dong_may . ".jpg";
                if (File::exists($dest)){
                    $dest = $this->create_exsit_file($dest);
                }
                File::copy($source, $dest);
            }
            elseif (count($file_png) > 0){
                $source = $file_png[0];
                $dest = $exportfolder . '\\' . $dong_may . ".png";
                if (File::exists($dest)){
                    $dest = $this->create_exsit_file($dest);
                }
                File::copy($source, $dest);
            }
            else{
                return;
            }
        }
    }

    public function excel(Request $request){
        $files = $request->file('excel');
        $info = Infos::where('user_id', $request->user()->id)->first();

        $sourcefolder = $info->sourcefolder;
        $exportfolder = $info->exportfolder;
        $exportname = $info->exportname;
        
        $now = Carbon::now();
        $exportfolder = $exportfolder. '\\'. $exportname . " " . $now->day."-".$now->month;

        // dd($exportfolder);
        
        if (!file_exists($exportfolder)) {
            mkdir($exportfolder, 0777, true);
        }
        
        if($info){
            foreach ($files as $file) {
                $inputFileType = IOFactory::identify($file);
                $reader  = IOFactory::createReader($inputFileType);
                $spreadsheet = $reader->load($file);
                $worksheet = $spreadsheet->getSheetByName('orders');
                $data = $worksheet->toArray();
                //Convert data ecxel to array
                foreach (array_slice($data, 1) as $row) {
                    //Slit data from column product_info ( col number 2)
                    $split_string = explode("\n", $row[2]);
                    foreach ($split_string as $item){
                        //Find product name and quanity
                        $product_name = preg_match('/Tên phân loại hàng:(.*?);/', $item, $matches) ? $matches[1] : ""; // Lấy tên sản phẩm
                        $quantity = preg_match('/Số lượng: (.*?);/', $item, $matches) ? $matches[1] : ""; // Lấy số lượng
                        $product_slip = explode(",", $product_name);
                        $ma_hinh = trim($product_slip[0]);
                        $dong_may = count($product_slip) > 1 ? trim($product_slip[1]) : "";
                        // $dong_may = replace_dongmay($dong_may);
                        $dong_may = str_replace("/", "-", $dong_may);
                        $dong_may = strtoupper($dong_may);
                        // dd($dong_may, $ma_hinh, $sourcefolder, $exportfolder);
                        for ($i = 0; $i < intval($quantity); $i++) {
                            $this->create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder);
                        }
                    }
                    
                }
            }
        }

        return redirect()->back();
    }
}