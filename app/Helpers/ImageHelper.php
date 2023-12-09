<?php
namespace App\Helpers;

use App\Models\Image;


class ImageHelper
{
    //public static $DefaultPath = '/uploads';

    public static function upload($file,$subFolder = '',$isrename ='Y'){
        $storePath = '/uploads';

        if(!is_null($subFolder) && $subFolder !=''){
            $storePath .= '/'.$subFolder;
        }

        $imageName = date('YmdHi').$file->getClientOriginalName();
        

        $file->move(public_path($storePath), $imageName);

        $fullPath = $storePath.'/'.$imageName;
        $image = Image::create([
            'path' => $fullPath,
            'name' => $imageName
        ]);

        return $image;
    }

    public function delete($imageId){
        
    }
}