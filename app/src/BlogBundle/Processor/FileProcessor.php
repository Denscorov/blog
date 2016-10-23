<?php

namespace BlogBundle\Processor;

class FileProcessor
{

    const DIR = 'upload';

    public function upload($file)
    {
        if (!file_exists(self::DIR)) {
            mkdir(self::DIR, 0777, true);
        }
        $fileName = md5(uniqid()) . '.' . pathinfo($file->getClientOriginalName())['extension'];
        $result = $file->move(self::DIR, $fileName);
        if ($result) {
            return $result->getFileName();
        }
        return false;
    }

    public function remove($file)
    {
        if (unlink(self::DIR . $file))
            return true;
        else
            return false;

    }

//    public function cropImage($file, $rectangle)
//    {
//        $ini_filename = 'upload/' . $file;
//        $type = getimagesize($ini_filename)['mime'];
//        $to_crop_array = array('x' => $rectangle[0], 'y' => $rectangle[1], 'width' => $rectangle[2], 'height' => $rectangle[3]);
//
//        switch ($type) {
//            case 'image/png':
//                $im = imagecreatefrompng($ini_filename);
//                $thumb_im = imagecrop($im, $to_crop_array);
//                if (!imagepng($thumb_im, $ini_filename))
//                    return;
//                break;
//            case 'image/jpeg':
//                $im = imagecreatefromjpeg($ini_filename);
//                $thumb_im = imagecrop($im, $to_crop_array);
//                if(!imagejpeg($thumb_im, $ini_filename))
//                    return;
//                break;
//        }
//    }
}