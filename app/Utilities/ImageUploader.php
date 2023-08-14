<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Storage;

class ImageUploader
{

    private String $url;

    public function handler($base64, $path, $prefix)
    {

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $fileName = $prefix. '-' . uniqid() . '.jpg';

        Storage::disk('public')->put($path . $fileName, $imageData);

        $this->url =  asset('storage/' . $path . $fileName);

    }
    public function getURL(){
        return $this->url;
    }
}
