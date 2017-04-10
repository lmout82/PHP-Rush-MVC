<?php
//**********************************************************************************************
//                                     Photo.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Photo
{
    /*
    ** Sauvegarde l'image de l'article dans img/articles après soumission d'un formulaire
    ** et retourne le nom de l'image pour sauvgearde dans la bdd si ok.
    ** $field_name est le nom du champ <input type="file"> du formulaire. 
    */
    public static function storeUploadedImage($field_name)
    {
        if(!is_string($field_name))
            return false;

        if(isset($_FILES[$field_name]["name"]))
        {
            if($_FILES[$field_name]["error"] == UPLOAD_ERR_OK)
            {
                $file_name = explode(".", $_FILES[$field_name]["name"]);
                $new_file_name = time().".".end($file_name);
                if($_FILES[$field_name]["size"] < 4096000) // octets
                {
                    $info = getimagesize($_FILES[$field_name]["tmp_name"]);
                    if ($info !== false)
                    {
                        $ret = move_uploaded_file($_FILES[$field_name]["tmp_name"], WEBSITE_FULL_DIR."/Webroot/img/articles/".$new_file_name);
                        if (self::makeThumb(WEBSITE_FULL_DIR."/Webroot/img/articles/".$new_file_name, WEBSITE_FULL_DIR."/Webroot/img/articles/thumb/".$new_file_name, 200))
                             if($ret == true)
                                return $new_file_name;
                    }
                }
                else
                    return false;
            }
            else
                return false;
        }
        else
            return false;    
    }

    public static function thumbnailUploadedImage($file_name, $maxWidth, $maxHeight)
    {
        $imagick = new Imagick(WEBSITE_ROOT."/img/products/".$file_name);
        $imagick->setbackgroundcolor("rgb(255, 255, 255)");
        $imagick->thumbnailImage($maxWidth, $maxHeight, true, true);
        $imagick->writeImage(WEBSITE_ROOT."/img/products/".$file_name);
        $imagick->destroy();
    }

    public static function makeThumb($source, $destination, $thumb_width)
    {
        $size   = getimagesize($source);
        $width  = $size[0];
        $height = $size[1];
        $x      = 0;
        $y      = 0;

        $status  = false;

        if ($width > $height)
        {
            $x      = ceil(($width - $height) / 2);
            $width  = $height;
        }
        else if ($height > $width)
        {
            $y      = ceil(($height - $width) / 2);
            $height = $width;
        }

        $new_image = imagecreatetruecolor($thumb_width,$thumb_width);
        $extension = new SplFileInfo($source);
        $extension = $extension->getExtension();
        if ($extension == 'jpg' || $extension == 'jpeg')
            $image = imagecreatefromjpeg($source);
        if ($extension == 'gif')
            $image = imagecreatefromgif($source);
        if ($extension == 'png')
            $image = imagecreatefrompng($source);

        imagecopyresampled($new_image,$image,0,0,$x,$y,$thumb_width,$thumb_width,$width,$height);

        if ($extension == 'jpg' || $extension == 'jpeg')
            $status = @imagejpeg($new_image, $destination);
        if ($extension == 'gif')
            $status = @imagegif($new_image, $destination);  
        if ($extension == 'png')
            $status = @imagepng($new_image, $destination);      

        imagedestroy($image);

        return $status;
    }
}
?>
