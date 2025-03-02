<?php
class Chat extends Controller {
    public function processMessage() {
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        try {
            if (!isset($_POST['question'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No question provided'
                ]);
                return;
            }

            $question = $_POST['question'];
            
            // For testing, just echo back the message
            echo json_encode([
                'status' => 'success',
                'message' => "Received: " . $question
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}