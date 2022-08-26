<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Validator;
use DB;

class StudentController extends Controller
{
    
   //API to store student record
public function store(Request $request)
    {
      $validator = array(
      //  'name' => 'required',
      //  'email' => 'required|email',
      //  "mobile" => "required |regex:/^([0-9\s\-\+\(\)])*$/|max:10|min:10",
      //  'address'=>'required',
       'emp_name'=>'required',
       'emp_email'=>'required',
       'emp_mobile'=>'required',
       'pincode'=>'required'
      );
      $validator = Validator::make($request->all(), $validator, ['mobile.regex' => 'Mobile must be numeric']);
     if ($validator->fails())
     {
        return response()->json($validator->errors(), 404);
     }
     else
     {
      $input=$request->all();
      $id=DB::connection('mysql2')->table('employee_details')
      ->insert(['emp_name'=>$input['emp_name'],'emp_email'=>$input['emp_email'],'emp_mobile'=>$input['emp_mobile'],'pincode'=>$input['pincode'],'city'=>$input['city'],'state'=>$input['state']]);
      //   $student = Student::create($request->all());
        return response()->json([
        "data" => $id,
        "success" => true,
        "message" =>"Student record has been created successfully.",
     
       ]);
     }
      /*
       $this->validate($request, [
         'name' => 'required|min:4',
         'email' => 'required|email',
         'mobile'=>'required|numeric|max:10',
         'address'=>'required'
     ]);
         $student = New Student;
         $student->name=$request->name;
         $student->email= $request->email;
         $student->mobile=$request->mobile;
         $student->address=$request->address;
         $result=$student->save();
         if($result)
         {
            return ["Status" => 200, "Data" => $result, "Message" => "Data has been saved Successfully"];
         }
         else
         {
            return ["Status" => 400, "Data" => $result, "Message" => "Saved Operation failed"];
         }*/
        // $input = $request->all();

        /* $validator = Validator::make($input, [
           'name' => 'required',
           'email' => 'required|email',
           'mobile'=>'required|numeric|max:10',
           'address'=>'required'
          ]);
           if($validator->fails())
           {
               return $this->sendError('Validation Error.', $validator->errors());       
            }
            else
            {
               $student = Student::create($input);
               return response()->json([
               "success" => true,
               "message" => "Student created successfully.",
               "data" => $student
             ]);
            }
            */
    }

    // Api view the student record
public function view($id=null)
    {
      $employee=DB::connection('mysql2')->table('employee_details')->find($id);
      if($employee)
      {
         return DB::connection('mysql2')->table('employee_details')->find($id);
        
      }
      else if($id)
      {
         return ["Status"=>400,"Message"=>"Data not Found"];
      }
      else
      {
         return DB::connection('mysql2')->table('employee_details')->all();
      }
      // $student=Student::find($id);
      // if($student)
      // {
      //    return Student::find($id);
        
      // }
      // else if($id)
      // {
      //    return ["Status"=>400,"Message"=>"Data not Found"];
      // }
      // else
      // {
      //    return Student::all();
      // }
    }
    
//Api pincode get city and state name
public function pinsearch(Request $request)
    {
      $validator = array(
          'pincode'=>'required|min:6|max:6'
         );
  
   $validator = Validator::make($request->all(), $validator, ['pincode.regex' => 'pincode must be numeric']);
   if ($validator->fails())
   {
      return response()->json($validator->errors(), 404);
   }
   else
   {
      $input = $request->all();
      $pincode = $input['pincode'];

      $count = DB::connection('mysql2')->table('employee_details')->where('pincode','=',$pincode)->count();
      if($count>0)
      {
         
         $get_data = DB::connection('mysql2')->table('employee_details')->where('pincode','=',$pincode)->select('city','state')->first();
         // echo $get_data->city;
         // echo "<br/>";
         // echo $get_data->state;
         //print_r($get_data['city']);
         return response()->json([
                  "data" => $get_data,
                  "success" => true,
                  "message" => "Show data City And State  "
               ]);
      }
      else
      {
         return ['Status'=>400,'Message'=>'Pincode not found'];
      }

   
   }
}

    //Api update the student record
   public function update(Request $request)
    {   
      $validator = array
      (
      //   'name' => 'required',
      //   'email' => 'required|email',
      //   'mobile' => 'required |regex:/^([0-9\s\-\+\(\)])*$/|max:10|min:10',
      //   'address'=>'required'
        'emp_name'=>'required',
       'emp_email'=>'required',
       'emp_mobile'=>'required',
       'pincode'=>'required'
      );
      $validator = Validator::make($request->all(), $validator, ['mobile.regex' => 'Mobile must be numeric']);
    if ($validator->fails())
    {
        return response()->json($validator->errors(), 404);
    }
    else
    {
      $input=$request->all();
      $student=DB::connection('mysql2')->table('employee_details')
      ->where(['id'=>$input['id']])
      ->update(['emp_name'=>$input['emp_name'],'emp_email'=>$input['emp_email'],'emp_mobile'=>$input['emp_mobile'],'pincode'=>$input['pincode'],'city'=>$input['city'],'state'=>$input['state']]);
      //->update('name'=>$input['name'],'email'=>$input['email'],'mobile'=>$input['mobile'],'address'=>$input['address']);
      //   $student = Student::find($request->id);
      //   $student->name=$request->name;
      //   $student->email= $request->email;
      //   $student->mobile=$request->mobile;
      //   $student->address=$request->address;
      //   $result=$student->save();
        return response()->json([
        "data" => $student,
        "success" => true,
        "message" => "Student record has been updated successfully.",
  
      ]);
    }
   //    $this->validate($request, [
   //       'name' => 'required|min:4',
   //       'email' => 'required|email',
   //       'mobile'=>'required|numeric|max:10',
   //       'address'=>'required'
   //   ]);
 /*
        $student=Student::find($request->id);
        $student->name=$request->name;
        $student->email= $request->email;
        $student->mobile=$request->mobile;
        $student->address=$request->address;
        $result=$student->save();
         
         if($result)
            {
               return ["Status" => 200, "Data" => $result, "Message" => "Data has been Updated Successfully"];
            }
            else
            {
               return ["Status" => 400, "Data" => $result, "Message" => "Updated operation failed"];
            }
            */
       
     }

//Delete Student record
 public function delete($id)
    {  
      $student=DB::connection('mysql2')->table('employee_details')->where('id', '=', $id)->first();
      $student->delete();

    if($student)
      {
         return response()->json([
            "data" => $student,
            "success" => true,
            "message" => "Student record has been deleted successfully."
         ]);
      }
      else if($id)
      {
         return ["Status"=>400,"Message"=>"Data not found"];
      }
     else
      {
         return response()->json([
            "data" => $student,
            "success" => true,
            "message" => "Student record has been delete operation failed."
         ]);
      } 
      // $student=DB::connection('mysql2')->table('employee_details')->find($id);
      // if($student)
      // {
      //     $student->delete();
      //     return ["Status" => 200, "Data" => $student, "Message" =>"Student record has been deleted Successfully"];
      
      // }
      // else if($id)
      // {
      //   return ["Status"=>404,"Data" => $id, "Message"=>"Data not found"];
      // }
      // else
      // {
      //     return ["Status" => 400, "Data" => $student, "Message" =>"Delete Operation failed"];
         
      // }
      // $student=Student::find($id);
      //   if($student)
      //   {
      //       $student->delete();
      //       return ["Status" => 200, "Data" => $student, "Message" =>"Student record has been deleted Successfully"];
        
      //   }
      //   else if($id)
      //   {
      //     return ["Status"=>404,"Data" => $id, "Message"=>"Data not found"];
      //   }
      //   {
      //       return ["Status" => 400, "Data" => $student, "Message" =>"Delete Operation failed"];
           
      //   }
        
      //     $student=Student::find($id);
      //     $result=$student->delete();

      // if($student)
      // {
      //    return response()->json([
      //       "data" => $student,
      //       "success" => true,
      //       "message" => "Student deleted successfully."
      //    ]);
      // }
      // else if($id)
      // {
      //    return ["Status"=>400,"Message"=>"Page not found"];
      // }
     // else
      // {
      //    return response()->json([
      //       "data" => $student,
      //       "success" => true,
      //       "message" => "Student delete operation failed"
      //    ]);
      // }
      
    }
}
