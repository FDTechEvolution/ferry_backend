<?php 

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    //public $DefaultUploadPath = 'uploads/';

    // Your file upload methods will be defined here.
    //$location is sub folder in public/uploads, when variable is empty will set to default in root of uploads folder
    public function uploadFile($file,$name = '',$location = ''){
        if(empty($name)){
            //$name = $file->getClientOriginalName();
            $name = Str::random(20) . '.' . $file->getClientOriginalExtension(); 
        }
        $path = 'uploads/';
        if(!empty($location)){
            $path = $path.$location.'/';
        }
        
        // Store the file in the 'public' disk (you can configure other disks as needed)
        Storage::disk('public')->putFileAs($path, $file, $name);

        return ['filename'=>$name,'path'=>$path.$name];

    }
}