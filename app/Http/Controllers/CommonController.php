<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;


class CommonController extends Controller
{
    public function displayImage($path, $file)
    {
        $img_path = storage_path('app/' . $path . '/' . $file);
        if (!File::exists($img_path)) {
            abort(404);
        }
        $file = File::get($img_path);
        $type = File::mimeType($img_path);
        $data = Response::make($file, 200);
        $data->header("Content-Type", $type);
        return $data;
    }

    public function getDownload($path, $file)
    {
        $path = storage_path('app/' . $path . '/' . $file);
        $headers = array('Content-Type' => File::mimeType($path));
        return response()->download($path, $file, $headers);
    }
}
