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
            $response = $this->makeApiRequest($url, $data);
            
            // Format the response
            $formatted_response = $this->formatResponse($response);

            echo json_encode([
                'status' => 'success',
                'message' => $formatted_response
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    private function formatResponse($response) {
        // Remove thinking process and metadata
        $formatted = preg_replace('/<think>.*?<\/think>/s', '', $response);
        
        // Remove incorrect solution paths
        $formatted = preg_replace('/First, I\'ll start with.*?Therefore,/s', '', $formatted);
        
        // Extract just the solution section
        if (preg_match('/\*\*Solution:\*\*(.*?)\*\*Final Answer:\*\*/s', $formatted, $matches)) {
            $formatted = trim($matches[1]);
        }
        
        // Clean up LaTeX formatting
        $formatted = str_replace(['\\[', '\\]'], '', $formatted);
        $formatted = str_replace('\boxed{', '', $formatted);
        $formatted = str_replace('}', '', $formatted);
        
        // Format simple equations
        if (preg_match('/(\d+\s*[\+\-\*\/]\s*\d+\s*=\s*\d+)/', $formatted, $matches)) {
            return trim($matches[1]); // Return just the equation
        }
        
        // Clean up final formatting
        $formatted = preg_replace('/\n{2,}/', "\n", $formatted); // Remove extra newlines
        $formatted = trim($formatted);
        
        return $formatted;
    }
}