<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function index ()
    {
        return view('cropieimage');
    }

    public function upload(Request $request)
    {
        if($request->ajax())
        {
            if($request->upload_image)
            {
                $data = $request->upload_image;
    
                $image_array_1 = explode(";", $data);
    
                $image_array_2 = explode(",", $image_array_1[1]);
    
                $data = base64_decode($image_array_2[1]);
    
                $imageName = time() . '.png';
                $path = public_path('upload/'.$imageName);
    
                file_put_contents($path, $data);
    
                
                return response()->json(['uploaded_image' => '<img src="upload/'.$imageName.'" class="img-thumbnail" />']);
            }
        }
    }
}