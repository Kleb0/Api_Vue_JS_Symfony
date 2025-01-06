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

    public function uploadFromUrl(string $imageUrl): string
    {
        $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
        $safeFilename = pathinfo($imageUrl, PATHINFO_FILENAME);
        $newFilename = $this->slugger->slug($safeFilename) . '.' . $extension;
    
        $imageContent = file_get_contents($imageUrl);
        if ($imageContent === false) {
            throw new \Exception('Unable to download image from URL.');
        }
    
        $filePath = $this->getTargetDirectory() . '/' . $newFilename;
        file_put_contents($filePath, $imageContent);
    
        return 'uploads/movies_images/' . $newFilename;
    }


    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
