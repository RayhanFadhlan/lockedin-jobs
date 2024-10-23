<?php

namespace controllers;
use core\Request;
use helpers\Redirect;
use helpers\Storage;
use models\LamaranModel;
use models\LowonganModel;
class StorageController extends Controller
{
    protected $storage;

    public function __construct()
    {
        $this->storage = new Storage();
    }

    // serve CV and Video for file owner (jobseeker) and company he applied to
    public function servePrivate(Request $request, $name){
        $file = ltrim($request->getUri(), '/');

        $lamaranModel = new LamaranModel();
        $lamaran = $lamaranModel->getLamaranByFile($file);

        if(!$lamaran){
            echo 'File not found';
            return;
        }
        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lamaran['lowongan_id']);

        $companyId  = $lowongan['company_id'];
        $userId = $lamaran['user_id'];
        
        if(!isset($_SESSION['user'])){
            echo 'You are not authorized to access this file';
            return;
        }
        
        $currentUser = $_SESSION['user']['id'];


        if($currentUser != $companyId && $currentUser != $userId){
            echo 'You are not authorized to access this file';
            return;
        }


        // read file
        $filePath = __DIR__ . '/../' . ltrim($request->getUri(), '/');

        $mimeType = mime_content_type($filePath);

        // Set the headers
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');

        // // Output the file
        readfile($filePath);

    }
}