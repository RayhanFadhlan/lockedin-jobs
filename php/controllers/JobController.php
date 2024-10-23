<?php
namespace controllers;
use core\Request;
use core\Response;
use Exception;
use helpers\HTMLSanitizer;
use helpers\Redirect;
use helpers\Storage;
use models\LamaranModel;
use models\LowonganModel;
use models\UserModel;
class JobController extends Controller
{

    public function viewJobDetail(Request $request, $id){
        
        try {

        $this->verifySpecificCompanyWithLowongan($id);
        
    
        $lowonganModel = new LowonganModel();
        $userModel = new UserModel();

        $job = $lowonganModel->getLowonganById($id);
        if (!$job) {
            Redirect::withToast('/', 'Job not found');
        }
        $company = $userModel->find($job['company_id']);
        

        $attachments = $lowonganModel->getAttachments($id);

        


        $imgPaths = array_map(function($attachment) {
            return '/' .  $attachment['file_path'];
        }, $attachments);

        $createdAt = new \DateTime($job['created_at']);
        $formattedCreatedAt = $createdAt->format('F j, Y, g:i a');
        
        $sanitizer = new HTMLSanitizer();
        $cleanHtml = $sanitizer->sanitize($job['deskripsi']);

        $lamaranModel = new LamaranModel();
        $lamarans = $lamaranModel->getLamaransNameStatus($id);
//         echo '<pre>';
// print_r($lamarans);
// echo '</pre>';
      
        return $this->views('company/job-detail', [
            'jobId' => $id,
            'company_name' => $company['nama'],
            'position' => $job['posisi'],
            'description' => $cleanHtml,
            // 'description' => $job['deskripsi'],
            'jobType' => $job['jenis_pekerjaan'],
            'locationType' => $job['jenis_lokasi'],
            'is_open' => $job['is_open'],
            'created_at' => $formattedCreatedAt,
            'images' => $imgPaths,
            'lamarans' => $lamarans
        ] );
        }
        catch (Exception $e) {
            Redirect::withToast('/', $e->getMessage(), 'error');
        }
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

            $lowonganModel = new LowonganModel();
            
            
            
            $lowonganId = $lowonganModel->insertLowongan($user_id, $jobPosition, $jobType, $jobLocation, $jobDescription);
            
            
            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'][0])) {
                $storage = new Storage('storage/uploads/', ['image/jpeg', 'image/png', 'image/jpg']);

                $attachmentPaths = $storage->store($_FILES);
    
                $lowonganModel->insertAttachmentLowongan($lowonganId, $attachmentPaths);
            }
    
            
            
            Response::json([
                'success' => true,
                'message' => 'Job created successfully',
            ])
            ->send();

        } catch (Exception $e) {
            
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

            
            $this->verifySpecificCompanyWithLowongan($lowonganId);
            
            $lowonganModel = new LowonganModel();

            $attachments = $lowonganModel->getAttachments($lowonganId);
            $storage = new Storage();

            foreach ($attachments as $attachment) {
                $storage->delete($attachment['file_path']);
            }
            
            $lowonganModel->deleteLowonganById($lowonganId);
    
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Job listing deleted successfully']);
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function changeOpenLowongan() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $lowonganId = $data['lowongan_id'] ?? null;

            $this->verifySpecificCompanyWithLowongan($lowonganId);

            
            $lowonganModel = new LowonganModel();
            $job = $lowonganModel->getLowonganById($lowonganId);
            



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
        catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)
            ->send();
        }
    }

    
    public function verifySpecificCompanyWithLowongan($lowonganId){
        try {
            $userId = $_SESSION['user']['id'];
            $lowonganModel = new LowonganModel();
            $lowongan = $lowonganModel->getLowonganById($lowonganId);
            if (!$lowongan) {
                throw new Exception('Job not found');
            }
            if($lowongan['company_id'] != $userId) {
                throw new Exception('You are not authorized to perform this action');
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
 

    public function viewEditJob(Request $request, $id){
        try {

            $this->verifySpecificCompanyWithLowongan($id);

            $lowonganModel = new LowonganModel();
            $job = $lowonganModel->getLowonganById($id);

            

            return $this->views('company/edit-job', [
                'jobPosition' => $job['posisi'],
                'jobType' => $job['jenis_pekerjaan'],
                'jobLocation' => $job['jenis_lokasi'],
                'jobDescription' => $job['deskripsi'],
            ]);


        }
        catch (Exception $e) {
            Redirect::withToast('/', $e->getMessage(), 'error');
        }

    }
    
    public function editJob(Request $request, $id){
        try {
            $this->verifySpecificCompanyWithLowongan($id);

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
            
            $lowonganModel = new LowonganModel();
            $lowonganModel->updateLowongan($id, $jobPosition, $jobType, $jobLocation, $jobDescription);


            $attachments = $lowonganModel->getAttachments($id);
            $storage = new Storage('storage/uploads/', ['image/jpeg', 'image/png', 'image/jpg']);

            foreach ($attachments as $attachment) {
                $storage->delete($attachment['file_path']);
            }

            $lowonganModel->deleteAttachments($id);

            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'][0])) {
                $attachmentPaths = $storage->store($_FILES);
    
                $lowonganModel->insertAttachmentLowongan($id, $attachmentPaths);
            }
            // $attachmentPaths = $storage->store($_FILES);

            // $lowonganModel->insertAttachmentLowongan($id, $attachmentPaths);




            Response::json([
                'success' => true,
                'message' => 'Job updated successfully',
            ])
            ->send();

        } catch (Exception $e) {
            
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400)
            ->send();

        }
    }
  
}