<?php

namespace App\Services;

//use App\Models\File;
//use App\Models\ProductFiles;

class TestService
{
    public static function handleUploadedCover($image)
    {
        return $image->store('covers');
    }

//    public static function handleUploadedFiles($files, $productId)
//    {
//        if (isset($files)) {
//            foreach ($files as $file) {
//                $filename = $file->store('files');
//                $file = File::create([
//                    'path'       => $filename,
//                ]);
//                self::linkProductFiles($productId, $file->id);
//            }
//        }
//    }
//
//    public static function linkProductFiles($productId, $fileId)
//    {
//        ProductFiles::create([
//            'product_id' => $productId,
//            'file_id' => $fileId,
//        ]);
//    }
}
