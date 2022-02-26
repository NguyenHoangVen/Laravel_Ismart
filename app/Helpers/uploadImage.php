<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function uploadImage($file, $folderName) {
    $fileNameOriginal = $file->getClientOriginalName();
    //Chuyển file vừa lấy vào public/uploads/folderName/Auth:id() có tên fileName
    $filePath = $file->move('public/uploads/' . $folderName . '/' . Auth::id(), $fileNameOriginal);
    $dataUploadTraits = [
        'file_name' => $fileNameOriginal,
        //Thay thế public/$folderName thành storage/$folderName
        'file_path' => $filePath
    ];
    return $dataUploadTraits;
}

