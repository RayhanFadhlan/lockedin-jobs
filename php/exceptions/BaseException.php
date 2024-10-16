<?php 

namespace exceptions;

class BaseException extends \Exception
{
    protected $statusCode;
    protected $errorMessage;

    public function __construct($message = "An error occurred", $statusCode = 500)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->errorMessage = $message;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function render()
    {
        http_response_code($this->statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'message' => $this->getErrorMessage()
        ]);
        exit;
    }
}

// try {
//     blablabla
//     throw new NotFoundException("The page you're looking for does not exist.");
// } catch (BaseException $e) {
//     $e->render();
// }
