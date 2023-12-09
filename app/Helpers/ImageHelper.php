<?php
namespace App\Helpers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ImageHelper
{
    //public static $DefaultPath = '/uploads';

    public static function upload($file, $subFolder = '', $isrename = 'Y')
    {
        $storePath = 'uploads';

        if (!is_null($subFolder) && $subFolder != '') {
            $storePath .= '/' . $subFolder;
        }

        $imageName = date('YmdHi') . $file->getClientOriginalName();

        /*
        $path = $file->storeAs(
            $storePath, $imageName
        );
        */

        $file->move(public_path($storePath), $imageName);

        $fullPath = $storePath . '/' . $imageName;
        $image = Image::create([
            'path' => $fullPath,
            'name' => $imageName,
        ]);

        return $image;
    }

    public static function delete($imageId)
    {
        $image = Image::where('id', $imageId)->first();

        //dd($image);
        if ($image != null) {
            //Storage::delete($image->path);
            //unlink(public_path().$image->path);
            if (file_exists($image->path)) {
                @unlink($image->path);
            }
        }
        $image->delete();

    }
}