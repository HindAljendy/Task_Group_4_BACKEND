<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait ImageTrait
{
    //this function get the uploaded image and store it in a directory
    public function storeImage($requestedImage, $directory)
    {
        try {
            $img = $requestedImage;
            $extention = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $extention;
            $path = $directory . $imageName;
            $img->move(public_path() . $directory, $imageName);
            return $path;
        } catch (\Throwable $th) {
            Log::error('Error storing image: ' . $th->getMessage());
            return 'An error occurred while storing the image.';
        }
    }

    // this function delete image from directory
    public function deleteImage($image, $directory)
    {
        $old_image =$directory . $image;
        unlink($old_image);
    }
}
