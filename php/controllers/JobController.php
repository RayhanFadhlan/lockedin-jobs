<?php
namespace controllers;
use core\Request;
use core\Response;
use helpers\Redirect;
use helpers\Storage;
use models\LowonganModel;
use models\UserModel;
class JobController extends Controller
{

    public function viewJobDetail($id){
        $id = (int) $id;
        $userId = $_SESSION['user']['id'];
        
        $lowonganModel = new LowonganModel();
        $userModel = new UserModel();

        $job = $lowonganModel->getLowonganById($id);
        if (!$job) {
            echo $job;
        }
        $company = $userModel->find($job['company_id']);
        if($job['company_id']!=$userId){
            Redirect::withToast('/', 'You are not authorized to view this job');
        }

        $attachments = $lowonganModel->getAttachments($id);

        $imgPaths = array_map(function($attachment) {
            return $attachment['file_path'];
        }, $attachments);


        


        return $this->views('company/job-detail', [
            'company_name' => $company['nama'],
            'position' => $job['posisi'],
            'description' => $job['deskripsi'],
            'jobType' => $job['jenis_pekerjaan'],
            'locationType' => $job['jenis_lokasi'],
            'is_open' => $job['is_open'],
            'created_at' => $job['created_at'],
            'images' => $imgPaths
        ] );
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