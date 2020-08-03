<?php

namespace App\Service;

use App\Entity\Picture;

class FileUploader
{

    /**
     * @param Picture $picture
     * @return Picture $picture
     */
    public function saveImage(Picture $picture): Picture
    {
        $file = $picture->getFile();
        $name = md5(uniqid()) . '.' . $file->guessExtension();
        $path = 'img/tricks';
        $file->move($path, $name);

        $picture->setPath($path);
        $picture->setName($name);

        return $picture;
    }

}