<?php

namespace App\Clases;

use Intervention\Image\ImageManagerStatic as ImageMS;

//
class Image
{
  //
  public function store(\Illuminate\Http\UploadedFile $image, string $path) : string
  {
    if (!is_dir($path)) {
      mkdir($path);
    }

    $uniqueName = uniqid() . '.png';
    ImageMS::make($image->getRealPath())
              ->resize(200,200)
              ->save($path . $uniqueName, 0, 'png');

    return $uniqueName;
  }
}