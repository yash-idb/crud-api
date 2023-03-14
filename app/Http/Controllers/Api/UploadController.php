<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
          $file = $request->file('file');
    
          // File Details 
          $filename = $file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();
          $tempPath = $file->getRealPath();
          $fileSize = $file->getSize();
          $mimeType = $file->getMimeType();
    
          // Valid File Extensions
          $valid_extension = array("csv","xls","xlsx");
    
          // 2MB in Bytes
          $maxFileSize = 2097152; 
    
          // Check file extension
          if(in_array(strtolower($extension),$valid_extension)){
    
            // Check file size
            if($fileSize <= $maxFileSize){
    
              // File upload location
              $location = 'uploads';
    
              // Upload file
              $file->move($location,$filename);
    
              // Import CSV to Database
              $filepath = public_path($location."/".$filename);
    
              // Reading file
              $file = fopen($filepath,"r");
    
              $importData_arr = array();
              $i = 0;
    
              while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
               //  $num = count($filedata );
                
                // $file1= fopen($filedata, "r");
                $filedata1 = fgetcsv($file);
                $colcount = count($filedata1);
                // print_r($colcount);
                // die();
                $linecount = count(file($filepath));
                //   print_r($linecount);
                // die();
                 // Skip first row (Remove below comment if you want to skip the first row)
                 if($i == 0){
                    $i++;
                    continue; 
                 }
                //  for ($c=0; $c < $colcount; $c++) {
                //     $importData_arr[$i][] = $filedata [$c];
                //  }

                for ($c = 0; $c < $linecount; $c++) {
                  for ($j = 0; $j < $colcount; $j++) {
                      $importData_arr[$i][] = $filedata[$c][$j];
                  }
              }
                 $i++;
              }
              fclose($file);
    
              // Insert to MySQL database
              foreach($importData_arr as $importData){
    
                $insertData = array(
                   "username"=>$importData[0],
                   "name"=>$importData[1],
                   "gender"=>$importData[2],
                   "email"=>$importData[3]);
                \DB::table('origindata')->insert($insertData);
    
              }
              return ('Import Successful.');
              
            }else{
                return ('File too large. File must be less than 2MB.');
            }
    
          }else{
            return ('Invalid File Extension.');
          }
      }
    
    
}
