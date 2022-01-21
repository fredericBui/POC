<?php

// Le dossier à créer
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    //@ Michael N. : "Le slugger crée un slug. Un slug est "un petit bout de texte" permettant d'identifier un fichier, une page d'un site, tout en fait (on appelle cela une ressource). Un slug c'est comme un id, mais au format petit texte"
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }


    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            // @ Michael N. : "... le stockage est fait par l'appel à la méthode move ..."
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    // Récupère l'adresse de destination des fichiers
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}