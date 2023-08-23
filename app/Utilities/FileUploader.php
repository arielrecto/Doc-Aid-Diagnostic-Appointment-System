<?php

namespace App\Utilities;


class FileUploader
{

    private $path;

    public function handler($file, $dir, $prefix) : void
    {
        $file_data = $file;
        $file_name = $prefix . uniqid() . '.' . $file_data->extension();
        $_path = $file_data->storeAs($dir, $file_name, 'public');
        $this->path = '/storage/' . $_path;
    }
    public function getPath(){
        return $this->path;
    }
}
