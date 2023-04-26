<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{

    public function handleUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            if (File::exists('uploads/' . $fileName)) {
                return response()->json([
                    'success' => false,
                    'message' => 'A file with the same name already exists.'
                ], 400);
            }

            $file->move(public_path('uploads'), $fileName);
            return response([
                'success' => true,
                'message' => 'File uploaded successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);
        }
    }
}
