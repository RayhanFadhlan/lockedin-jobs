<?php
namespace controllers;
use core\Request;
use core\Response;
use helpers\Redirect;
use helpers\Storage;
use models\LowonganModel;
class JobController extends Controller
{

    public function viewJobDetail($id){
        return $this->views('company/job-detail' );
    }
    public function viewCreateJob()
    {
        return $this->views('company/create-job');
        
    }


    public function createJob(Request $request)
    {
        try {
            $request->validate([
                'jobPosition' => ['required'],
                'jobType' => ['required'],
                'jobLocation' => ['required'],
                'jobDescription' => ['required'],
            ]);

            $jobPosition = $request->getBody('jobPosition');
            $jobType = $request->getBody('jobType');
            $jobLocation = $request->getBody('jobLocation');
            $jobDescription = $request->getBody('jobDescription');
            
            
            $user_id = $_SESSION['user']['id'];

            $storage = new Storage();
            $lowonganModel = new LowonganModel();

            
            
            $lowonganId = $lowonganModel->insertLowongan($user_id, $jobPosition, $jobType, $jobLocation, $jobDescription);
            
            $attachmentPaths = $storage->store($_FILES);

            $lowonganModel->insertAttachmentLowongan($lowonganId, $attachmentPaths);

            
            Response::json([
                'success' => true,
                'message' => 'Job created successfully',
            ])
            ->send();

        } catch (\Exception $e) {
            
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400)
            ->send();

        }
        
    }
  
}