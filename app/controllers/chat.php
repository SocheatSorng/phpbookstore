<?php

class Chat extends Controller
{
    function index()
    {
        $data['page_title'] = "Chat";        
        $this->view("chat", $data);
    }

    function processMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = isset($_POST['question']) ? trim($_POST['question']) : '';
            
            if (empty($question)) {
                $response = "Please enter a question.";
            } else {
                $ai_server_ip = "192.168.0.101"; // Verify this is correct
                $url = "http://$ai_server_ip:11434/api/generate";
                $data = json_encode([
                    "model" => "deepseek-r1:1.5b",
                    "prompt" => $question,
                    "stream" => false
                ]);

                $response = $this->makeApiRequest($url, $data);
            }
            
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => $response]);
            exit;
        }
        
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }

    private function makeApiRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        
        $result = curl_exec($ch);
        
        if ($result === false) {
            return "Error connecting to AI server: " . curl_error($ch);
        }
        
        $json = json_decode($result, true);
        $response = $json['response'] ?? "No response from AI.";
        
        // Format response using Markdown
        $formatted = $this->formatMarkdownResponse($response);
        return $formatted;
    }

    private function formatMarkdownResponse($response) {
        // Remove any thinking process
        $response = preg_replace('/<think>.*?<\/think>/s', '', $response);
        
        // Remove redundant explanations
        $response = preg_replace('/First, I\'ll start with.*?Therefore,/s', '', $response);
        
        // Clean up whitespace
        $response = preg_replace('/\n\s*\n/', "\n", $response);
        
        // Format as Markdown
        $response = "# Answer\n\n" . trim($response);
        
        // Convert LaTeX to Markdown code blocks
        $response = preg_replace('/\\\[(.*?)\\\]/', '```math\n$1\n```', $response);
        
        // Format lists properly
        $response = preg_replace('/(\d+\.\s+)/', "\n$1", $response);
        
        return trim($response);
    }
}