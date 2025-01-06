<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageUploader
{
    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct(ParameterBagInterface $parameterBag, SluggerInterface $slugger)
    {

        $this->targetDirectory = $parameterBag->get('images_directory');
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $newFilename);

        // Retourner le chemin relatif pour stocker dans la BDD
        return 'uploads/movies_images/' . $newFilename;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
