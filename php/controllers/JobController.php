<?php
namespace controllers;
use core\Request;
use core\Response;
use helpers\HTMLSanitizer;
use helpers\Redirect;
use helpers\Storage;
use models\LowonganModel;
use models\UserModel;
class JobController extends Controller
{

    public function viewJobDetail(Request $request, $id){
  
        $userId = $_SESSION['user']['id'];
        
    
        $lowonganModel = new LowonganModel();
        $userModel = new UserModel();

        $job = $lowonganModel->getLowonganById($id);
        if (!$job) {
            Redirect::withToast('/', 'Job not found');
        }
        $company = $userModel->find($job['company_id']);
        if($job['company_id']!=$userId){
            Redirect::withToast('/', 'You are not authorized to view this page');
        }

        $attachments = $lowonganModel->getAttachments($id);

        


        $imgPaths = array_map(function($attachment) {
            return '/' .  $attachment['file_path'];
        }, $attachments);

        $createdAt = new \DateTime($job['created_at']);
        $formattedCreatedAt = $createdAt->format('F j, Y, g:i a');
        
        $sanitizer = new HTMLSanitizer();
        $cleanHtml = $sanitizer->sanitize($job['deskripsi']);

      
        return $this->views('company/job-detail', [
            'company_name' => $company['nama'],
            'position' => $job['posisi'],
            'description' => $cleanHtml,
            // 'description' => $job['deskripsi'],
            'jobType' => $job['jenis_pekerjaan'],
            'locationType' => $job['jenis_lokasi'],
            'is_open' => $job['is_open'],
            'created_at' => $formattedCreatedAt,
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

    public function deleteLowonganCompany() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $lowonganId = $data['lowongan_id'] ?? null;

            $userId = $_SESSION['user']['id'];

            $lowonganModel = new LowonganModel();
            $lowongan = $lowonganModel->getLowonganById($lowonganId);

            if($lowongan['company_id'] != $userId) {
                Response::json([
                    'success' => false,
                    'message' => 'You are not authorized to perform this action'
                ], 403)
                ->send();
            }
            $attachments = $lowonganModel->getAttachments($lowonganId);
            $storage = new Storage();

            foreach ($attachments as $attachment) {
                $storage->delete($attachment['file_path']);
            }
            
            $lowonganModel->deleteLowonganById($lowonganId);
    
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Job listing deleted successfully']);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function changeOpenLowongan() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $lowonganId = $data['lowongan_id'] ?? null;

            $lowonganModel = new LowonganModel();
            $job = $lowonganModel->getLowonganById($lowonganId);
            if (!$job) {
                Response::json([
                    'success' => false,
                    'message' => 'Job not found'
                ], 404)
                ->send();
            }
            
            if($job['company_id'] != $_SESSION['user']['id']) {
                Response::json([
                    'success' => false,
                    'message' => 'You are not authorized to perform this action'
                ], 403)
                ->send();
            }

            if($job['is_open']) {
                $lowonganModel->closeLowongan($lowonganId);
                Response::json([
                    'success' => true,
                    'message' => 'Job closed successfully'
                ])
                ->send();
            } else {
                $lowonganModel->openLowongan($lowonganId);
                Response::json([
                    'success' => true,
                    'message' => 'Job opened successfully'
                ])
                ->send();
            }

        }
        catch (\Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)
            ->send();
        }
    }

 
  
}