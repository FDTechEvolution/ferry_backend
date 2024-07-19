<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FilesProcessing;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use FilesProcessing;

    public function download(Request $request)
    {

        // Get the URL of the file to download.
        $url = $request->url;

        // Get the name of the storage to use.
        $storageName = $request->storageName;

        // Download the file from the URL.
        $urlToDownload = $this->downloadFileFromUrl($url, $storageName, $request->subfolder);

        // Return a success response with the file url.
        return response()->json([
            'success' => true,
            'url' => $urlToDownload,
        ]);
    }
}
