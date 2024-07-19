<?php
namespace App\Traits;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FilesProcessing{

    public function makeDirectory($path){
        // Check if the directory already exists.
        if (!File::isDirectory($path)) {

            // Create the directory.
            File::makeDirectory($path);
        }
    }

    function downloadFileFromUrl($url, $storageName, $subfolder = '') {

        //To add subdirectory to the filename
        $addSubFolder = '';

        if($subfolder){
            //Check if the directory exists
            $path =  Storage::disk($storageName)->path($subfolder);
            $this->makeDirectory($path);
            $addSubFolder = $subfolder.'/';
        }
        // Get the current date and time.
        $dateTime = now();

        // Generate a unique filename.
        $filename = $addSubFolder.$dateTime->format('YmdHis') . '_' . basename($url);

        // Download the file from the URL.
        Storage::disk($storageName)->put( $filename, file_get_contents($url));

        // Get the file url to download
        return Storage::disk($storageName)->url($filename);
    }
}
