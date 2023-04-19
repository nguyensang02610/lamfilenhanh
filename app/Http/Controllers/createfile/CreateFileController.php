<?php

namespace App\Http\Controllers\createfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\FacadesFile;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

use App\Models\Infos;
use App\Models\Storage;
use App\Models\CreateFileHistory;
use App\Models\Notification;
use App\Models\PhoneReplace;

class CreateFileController extends Controller
{
    public function create_exsit_file($dest){
        $info = pathinfo($dest);
        $i = 1;
        while (File::exists($info['dirname'] . '\\' . $info['filename'] . " ($i)." . $info['extension'])) {
            $i++;
        }
        $dest = $info['dirname'] . '\\' . $info['filename'] . " ($i)." . $info['extension'];
        return $dest;
    }

    

    public function create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder, $user_id, $log_id){
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
                $notification = new Notification;
                $notification->user_id = $user_id;
                $notification->create_file_id = $log_id;
                $notification->content = "Không xác định đc mã hình : ".$ma_hinh."--. Dòng máy : ".$dong_may;
                $notification->zone = 'danger';
                $notification->save();
            }
        }
    }

    public function excel(Request $request){
        $user_id = $request->user()->id;
        $files = $request->file('excel');
        $info = Infos::where('user_id', $user_id)->first();

        $history = new CreateFileHistory;
        $history->user_id = $user_id;
        $history->save();

        $log_id = $history->id;

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
                CreateFileHistory::where('id', $log_id)->update(['tong_don' => count($data)-1]);

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
                        $dong_may_replace = PhoneReplace::where('user_id', $user_id)
                                                        ->where('dong_may','LIKE', $dong_may)
                                                        ->first();
                        // dd( $dong_may_replace);
                        if(optional($dong_may_replace)->count() > 0){
                            $dong_may = $dong_may_replace->dong_may_thay;
                        }
                        // $dong_may = replace_dongmay($dong_may);
                        $dong_may = str_replace("/", "-", $dong_may);
                        $dong_may = strtoupper($dong_may);

                        $check_kho = Storage::where('user_id', $user_id)
                                            ->where('ma_hinh', $ma_hinh)
                                            ->where('dong_may', 'LIKE', '%' . str_replace(['-'], '%', $dong_may) . '%')
                                            ->get();

                        // dd($check_kho);
                        $kho_lenght = $check_kho -> count();

                        if ($check_kho->count()) {//Nếu phát hiện ra đã có hàng tồn // kho có 3 cái
                            for ($i = 0; $i < intval($quantity); $i++) { // lặp theo số lượng gồm 2 cái có nghĩa là chỉ lắp 2 lần
                                if ($kho_lenght > 0){           
                                    $notification = new Notification;

                                    $notification->user_id = $user_id;
                                    $notification->create_file_id = $log_id;
                                    $notification->content = "Tìm thấy : ".$dong_may."-- mã :".$ma_hinh."--"."Ghi chú : ".$check_kho[$i]->note;
                                    $notification->save();
                                    Storage::destroy($check_kho[$i]->id);
                                    $kho_lenght = $kho_lenght - 1;
                                }
                                else{
                                    $this->create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder, $user_id, $log_id);
                                }
                            }
                        } else {
                            if ($quantity > 1){
                                for ($i = 0; $i < intval($quantity); $i++) {
                                    $this->create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder, $user_id, $log_id);
                                }
                            }
                            else{
                                $this->create_file($dong_may, $ma_hinh, $sourcefolder, $exportfolder, $user_id, $log_id);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->back();
    }
}