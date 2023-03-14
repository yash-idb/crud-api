<?php

namespace App\Http\Controllers\Api;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\EmployeeImport;
use Excel;

class EmployeeController extends Controller
{
 
public function fileImportExport()
    {
       return view('file-import');
    }
   
    public function fileImport(Request $request) 
    {
        $file=$request->file('file');
        //Excel::import(new EmployeeImport, $file);
        $var=Excel::import(new EmployeeImport,$file);
      // return redirect()->back();
        return response()->json([
            'data'=>$var,
            'Success'=>200,
            'Message'=>'Success'
        ]);
    }

    public function fileExport(Request $request) 
    {        
        $Transaction_Type = 'fileImport';
        $var= Excel::download(new EmployeeExport,$Transaction_Type);
        return response()->json([
            'data'=>$var,
            'Success'=>200,
            'Message'=>'Success'
        ]);
    }


    public function Password()
    {       
        $msda = \DB::table('updated_dealer')->where(['status' => '0'])->limit(100)->get();        
        foreach ($msda as $value) 
        {
            $key12 = $value->password;
            $password = bcrypt($key12);
            $data = \DB::table('updated_dealer')->where(['id' => $value->id])->update(['encrypt_password' => $password,'status' => '1']);
        }
    }

    public function export()
{
    $chunkSize = 10000;
    $usersCount =  \DB::table('updated_dealer')->count();
    $numberOfChunks = ceil($usersCount / $chunkSize);

    $folder = now()->toDateString() . '-' . str_replace(':', '-', now()->toTimeString());

    $batches = [
        new CreateUsersExportFile($chunkSize, $folder)
    ];

    if ($usersCount > $chunkSize) {
        $numberOfChunks = $numberOfChunks - 1;
        for ($numberOfChunks; $numberOfChunks > 0; $numberOfChunks--) {
            $batches[] = new AppendMoreUsers($numberOfChunks, $chunkSize, $folder);
        }
    }

    Bus::batch($batches)
        ->name('Export Users')
        ->then(function (Batch $batch) use ($folder) {
            $path = "exports/{$folder}/users.csv";
            // upload file to s3
            $file = storage_path("app/{$folder}/users.csv");
            Storage::disk('s3')->put($path, file_get_contents($file));
            // send email to admin
        })
        ->catch(function (Batch $batch, Throwable $e) {
            // send email to admin or log error
        })
        ->finally(function (Batch $batch) use ($folder) {
            // delete local file
            Storage::disk('local')->deleteDirectory($folder);
        })
        ->dispatch();

    return redirect()->back();
}
}
