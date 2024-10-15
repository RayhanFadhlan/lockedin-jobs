<?php
namespace controllers;
class JobController extends Controller
{
    public function viewCreateJob()
    {
        return $this->views('create-job', );
    }
}