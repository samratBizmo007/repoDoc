<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;

/**
 * App Model
 */
class AppTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    /**
     * Get Unique Image Name
     */
    public function getImageName($image_name)
    {
        $extension = strripos($image_name,".");
        $extension = substr($image_name,strripos($image_name,"."));
        $name = !empty($image_name) ? uniqid().$extension : "";
        return $name;
    }

    public function _uploadImage($image,$path,$allowed_exntentions,$uploads_thumb_path,$old_image)
    {
        $image_path = "";
        if(!empty($image))
        {
            if(in_array($image['type'], $allowed_exntentions))
            {
                $tmp_name = $image['tmp_name'];
                $name = $this->getImageName($image['name']);
                if (!file_exists($path))
                    mkdir($path, 0777, true);
    
                    if(move_uploaded_file($tmp_name, $path.$name))
                    {
                        $image_path = $name;
    
                        /* Resize Logic */
                        $resize_path = $uploads_thumb_path . $name;
                        $this->_smartResizImage($path.$name, null, 160, 160, true, $resize_path, false, false, 100);
    
                        if(!empty($old_image) && file_exists($path.$old_image)){
                            unlink($path.$old_image);
                            unlink($uploads_thumb_path.$old_image);
                        }
                    }
            }
        }
        return $image_path;
    }
    
    public function _smartResizImage($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100) {
        //https://github.com/Nimrod007/PHP_image_resize
        
        if ($height <= 0 && $width <= 0)
            return false;
        if ($file === null && $string === null)
            return false;
        # Setting defaults and meta
        $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image = '';
        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        # Calculating proportionality
        if ($proportional) {
            if ($width == 0)
                $factor = $height / $height_old;
            elseif ($height == 0)
                $factor = $width / $width_old;
            else
                $factor = min($width / $width_old, $height / $height_old);
            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;

            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        
        # Loading image to memory according to type
        switch ($info[2]) {
            case IMAGETYPE_JPEG: $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_GIF: $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_PNG: $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
                break;
            default: return false;
        }


        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


        # Taking care of original, if needed
        if ($delete_original) {
            if ($use_linux_commands)
                exec('rm ' . $file);
            else
                @unlink($file);
        }
        # Preparing a method of providing result
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        # Writing image according to type to the output destination and image quality
        switch ($info[2]) {
            case IMAGETYPE_GIF: imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG: imagejpeg($image_resized, $output, $quality);
                break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int) ((0.9 * $quality) / 10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }
        return true;
    }
    
    /*
     * Upload Video file and also generate its thumbnail
     */
    public function video($file, $destination, $is_thumb = 0) {
        $fileName = "";
        if (!empty($file)) {
            $destination = $destination;
            $time = time();
    
            $fileName = $file['name'];
            $fileExtention = pathinfo($file["name"], PATHINFO_EXTENSION);
    
            $fileName = $time . rand(111, 999) . "." . $fileExtention;
            $full_video_path = $destination . $fileName;
    
            if (!file_exists($destination))
                mkdir($destination, 0777, true);
    
                move_uploaded_file($file['tmp_name'], $full_video_path);
    
                $image_name = "";
                if ($is_thumb == 1) {
                    //video dir
                    $video = $full_video_path;
    
                    //where to save the image
                    $image_name = $time . '.jpg';
    
                    if (!file_exists($destination . 'thumbs/'))
                        mkdir($destination . 'thumbs/', 0777, true);
                    
                    if (!file_exists($destination . 'original/'))
                        mkdir($destination . 'original/', 0777, true);
    
                        $image = $destination . 'thumbs/' . $image_name;
                        $original_image = $destination . 'original/' . $image_name;
                        //time to take screenshot at
                        $interval = 5;
    
                        //screenshot size
                        $size = '320x240';
    
                        //ffmpeg command
                        $cmd = "ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $image";
                        exec($cmd);
                        
                        $cmd1 = "ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $original_image";
                        exec($cmd1);
                }
        }
        return ["name" => $fileName, "thumb" => $image_name];
    }
    
    /*
     * Upload Any File
     */
    public function file($file, $destination) {
        $fileName = "";
        if (!empty($file)) {
            $destination = $destination;
            $time = time();
    
            $fileName = $file['name'];
            $fileExtention = pathinfo($file["name"], PATHINFO_EXTENSION);
    
            $fileName = $time . rand(111, 999) ."." . $fileExtention;
            $full_path = $destination . $fileName;
    
            if (!file_exists($destination))
                mkdir($destination, 0777, true);
            
            move_uploaded_file($file['tmp_name'], $full_path);
    
        }
        return $fileName;
    }

    public function getAgeFromBirthDate($birth_date = '',$format = 'Y-m-d'){
        if(!empty($birth_date)){
            
            $then = new Time($birth_date);
            $diff = $then->diff(Time::now());
            
            return ($diff->y > 0) ? $diff->y : 0;
        } else {
            return 0;
        }
    }
    
    function array_sort($array, $on, $order=SORT_ASC){
    
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
    
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        
        return $new_array;
    }
    
    function array_multi_unique($multiArray){
    
        $uniqueArray = array();
    
        foreach($multiArray as $subArray){
    
            if(!in_array($subArray, $uniqueArray)){
                $uniqueArray[] = $subArray;
            }
        }
        return $uniqueArray;
    }
}
