<?php

namespace App\Libraries;

use Image;

class CustomImageLib
{
    /**
     * Create a new CustomImageLib instance.
     *
     * @param array $data
     */
    public function __construct()
    {
    }

    /**
     * Resize and save image.
     *
     * @param object $image
     * @param string $path
     * @param array  $size
     *
     * @return mixed
     */
    public function resize($image, $path, array $size)
    {
        try {
            $fileName = generateFileName($image->getClientOriginalExtension());
            $imageRealPath = $image->getRealPath();

            $width = isset($size['width']) ? intval($size['width']) : null;
            $height = isset($size['height']) ? intval($size['height']) : null;

            // Resize
            $img = Image::make($imageRealPath)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save
            return $img->save(public_path($path).'/'.$fileName);
        } catch (\Exception $e) {
            return false;
        }
    }
}
