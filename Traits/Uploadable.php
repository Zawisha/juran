<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Uploadable
{
    public function upload($file, $storage = 'public', $folder = 'uploads')
    {
        $filename = 'test_1';
        $path = Storage::disk($storage)->putFileAs($folder, $file, $filename);

        if (Storage::disk($storage)->exists($path)) {
            return $path;
        }

        return null;
    }
}
