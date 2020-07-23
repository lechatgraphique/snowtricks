<?php

namespace App\EntityListener;

use App\Entity\Picture;
use App\Service\FileUploader;

class PictureListener

{
    /**
     * @var string
     */
    private string $trickDir;

    private FileUploader $fileUploader;

    /**
     * PictureListener constructor.
     *
     * '
     * @param string $trickDir
     * @param FileUploader $fileUploader
     */
    public function __construct(string $trickDir, FileUploader $fileUploader) {
        $this->trickDir = $trickDir;
        $this->fileUploader = $fileUploader;
    }

    public function preRemove(Picture $picture)
    {

        $pictures = $picture->getTrick()->getPictures();

        foreach ($pictures as $colPicture) {
            $this->fileUploader->removeFile($colPicture->getPath());
        }

        $this->fileUploader->removeFile($picture->getTrick()->getMainPicture());
    }
}
