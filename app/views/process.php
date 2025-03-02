<?php
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

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 10s to connect
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);        // 30s total timeout
        $result = curl_exec($ch);

        if ($result === false) {
            $response = "Error connecting to AI server: " . curl_error($ch);
        } else {
            $json = json_decode($result, true);
            $response = $json['response'] ?? "No response from AI.";
        }
        curl_close($ch);
    }
    header("Location: index.php?response=" . urlencode($response));
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>