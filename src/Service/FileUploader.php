<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function removeFile($fileName)
    {
        if(!file_exists($this->getTargetDirectory() . '/' . $fileName)){
            return;
        }

        try {
            unlink($this->getTargetDirectory() . '/' . $fileName);
        } catch (FileException $e) {
            // Exception si une erreur pendant la supression du fichier
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}