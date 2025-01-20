<?php

namespace App\Controllers;

use App\Helper\Session;
use App\Models\Faculty;
use App\Models\Position;
use App\Models\Bulletin;
use \Core\View;
use \Core\Controller;
use Carbon\Carbon;

/**
 * BulletinController controller
 */
class BulletinController extends Controller
{
    public function __construct()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()){
            header('Location: /login');
        }
    }

    public function index()
    {
        $currentYear = date('Y'); 
        $faculties = Faculty::orderBy('id')->get();
        $bulletins = Bulletin::orderBy('published_at', 'desc')->get();

        View::renderTemplate('admin/bulletins/index.html', ['bulletins' => $bulletins, 'faculties'=>$faculties, 'currentYear'=>$currentYear] );
    }

    private function uploadPdf($file)
    {

        $maxFileSize = 5 * 1024 * 1024; 

        if ($file['type'] !== 'application/pdf') {
            throw new \Exception('Invalid file type. Only PDF files are allowed.');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Error uploading the PDF file.');
        }
        
        if ($file['size'] > $maxFileSize) {
            throw new \Exception('File size exceeds the maximum allowed limit of 5MB.');
        }

        $uploadDir = '../uploads/bulletins/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid('bulletin_', true) . '.pdf';
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new \Exception('Failed to move the uploaded file.');
        }

        return $filePath;
    }


    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        $positions = Position::orderBy('position', 'ASC')->get();
        View::renderTemplate('admin/bulletins/create.html', ['faculties' => $faculties, 'positions' => $positions]);
    }


    public function store()
    {
        if (empty($_POST['faculty_id']) || empty($_POST['bulletin_title']) || empty($_FILES['pdf_file'])) {
            header("Location: /admin/bulletins/create");
            return;
        }
        $maxFileSize = 5 * 1024 * 1024; 
        if ($_FILES['pdf_file']['size'] > $maxFileSize) {
            throw new \Exception('File size exceeds the maximum allowed limit of 5MB.');
        }
    
        $pdfFilePath = $this->uploadPdf($_FILES['pdf_file']);
    
        $bulletin = new Bulletin();
        $bulletin->faculty_id = $_POST['faculty_id'];
        $bulletin->position_id = $_POST['position_id'] ?? null;
        $bulletin->bulletin_title = $_POST['bulletin_title'];
        $bulletin->pdf_file_path = $pdfFilePath;
        $bulletin->description = $_POST['description'] ?? null;
        $bulletin->published_at = $_POST['published_at'] ?? Carbon::now();
        $bulletin->save();
    
        header("Location: /admin/bulletins");
    }



    public function downloadPdf()
    {
        // dd($_GET['file_id']);
        $id = $_GET['file_id'];

        try {
            $bulletin = Bulletin::findOrFail($id);

            $filePath = $bulletin->pdf_file_path;

            if (!file_exists($filePath)) {
                throw new \Exception('The requested file does not exist.');
            }

            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            if (ob_get_length()) {
                ob_clean();
            }
            flush();
            readfile($filePath);

            exit; 
        } catch (\Exception $e) {
            error_log("Download error: " . $e->getMessage());
            http_response_code(404);
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function viewFile()
    {
                // dd($_GET['file_id']);

        $fileId = $_GET['file_id'] ?? null;

        $id = $_GET['file_id'];

        if (!$fileId) {
            http_response_code(400);
            echo "Invalid file ID.";
            return;
        }

        $bulletin = Bulletin::findOrFail($fileId);

        if (!$bulletin) {
            http_response_code(404);
            echo "File not found.";
            return;
        }

        $filePath = $bulletin->pdf_file_path;

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "File not found on the server.";
            return;
        }

        $mimeType = mime_content_type($filePath);

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }



    public function show()
    {
        $id = $_GET['id'];
        $bulletin = Bulletin::findOrFail($id);
        View::renderTemplate('admin/bulletins/show.html', ['bulletin' => $bulletin]);
    }

    public function edit()
    {
        $id = $_GET['id'];
        $faculties = Faculty::orderBy('name')->get();
        $positions = Position::orderBy('position', 'ASC')->get();
        $bulletin = Bulletin::findOrFail($id);
        View::renderTemplate('admin/bulletins/edit.html', ['bulletin' => $bulletin, 'faculties' => $faculties, 'positions' => $positions]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $bulletin = Bulletin::findOrFail($id);

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $pdfFilePath = $this->uploadPdf($_FILES['pdf_file']);
            $bulletin->pdf_file_path = $pdfFilePath;  
        }

        $bulletin->faculty_id = $_POST['faculty_id'];
        $bulletin->position_id = $_POST['position_id'] ?? null;
        $bulletin->bulletin_title = $_POST['bulletin_title'];
        $bulletin->description = $_POST['description'] ?? null;
        $bulletin->published_at = $_POST['published_at'] ?? $bulletin->published_at; 
        $bulletin->save();

        header("Location: /admin/bulletins");
    }


    public function destroy()
    {
        $id = $_GET['id'];
        $bulletin = Bulletin::findOrFail($id);
        $bulletin->delete();

        header("Location: /admin/bulletins");
    }

}
