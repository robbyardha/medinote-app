<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        $CKEditorFuncNum = $request->get('CKEditorFuncNum');

        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:5120', // Maks 5MB
        ]);

        $file = $request->file('upload');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();

        // directory di public (langsung ke public/ckeditor_upload)
        $directory = public_path('ckeditor_upload');

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $file->move($directory, $filename);

        $url = asset('ckeditor_upload/' . $filename);
        $message = 'Image uploaded successfully';
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')</script>";
        @header('Content-type: text/html; charset=utf-8');
        echo $response;
    }
}
