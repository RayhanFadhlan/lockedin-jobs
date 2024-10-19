<?php
namespace helpers;

class Storage
{
    private $uploadDir;
    private $allowedTypes;

    public function __construct($uploadDir = 'public/uploads/', $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'])
    {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = $allowedTypes;
    }

    public function store($files)
    {
        if (!isset($files['attachment'])) {
            throw new \Exception('No file uploaded.');
        }

        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0755, true)) {
                throw new \Exception("Failed to create upload directory.");
            }
        }

        return $this->handleUpload($files['attachment']);
    }

    private function handleUpload($file)
    {
        if (is_array($file['name'])) {
            return $this->handleMultipleFiles($file);
        } else {
            return [$this->handleSingleFile($file)];
        }
    }

    private function handleMultipleFiles($file)
    {
        $paths = [];
        foreach ($file['name'] as $key => $name) {
            $paths[] = $this->processSingleFile(
                $name,
                $file['tmp_name'][$key],
                $file['type'][$key]
            );
        }
        return $paths;
    }

    private function handleSingleFile($file)
    {
        return $this->processSingleFile(
            $file['name'],
            $file['tmp_name'],
            $file['type']
        );
    }

    private function processSingleFile($name, $tmpName, $type)
    {
        $this->validateFileType($type, $name);

        $fileName = $this->generateFileName($name);
        $filePath = $this->uploadDir . $fileName;

        if (!move_uploaded_file($tmpName, $filePath)) {
            throw new \Exception("Failed to upload file: $name");
        }

        return '/' . $filePath;
    }

    private function validateFileType($type, $name)
    {
        if (!in_array($type, $this->allowedTypes)) {
            throw new \Exception("Invalid file type for $name. Only " . implode(', ', $this->allowedTypes) . " are allowed.");
        }
    }

    private function delete($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    private function generateFileName($originalName)
    {
        return uniqid() . '_' . $originalName;
    }
}