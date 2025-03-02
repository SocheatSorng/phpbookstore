<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeepSeek Chat</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; }
        textarea { width: 100%; height: 100px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        #response { margin-top: 20px; padding: 10px; border: 1px solid #ddd; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Ask DeepSeek</h1>
    <form id="chatForm">
        <textarea name="question" placeholder="Type your question here..." required></textarea>
        <button type="submit">Ask</button>
    </form>
    <div id="response"></div>

    <script>
        document.getElementById('chatForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const textarea = this.querySelector('textarea');
            const response = document.getElementById('response');
            
            try {
                const formData = new FormData(this);
                const result = await fetch('/phpbookstore/chat/processMessage', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await result.json();
                response.textContent = data.message;
            } catch (error) {
                response.textContent = 'Error: Could not process your request';
            }
        });
    </script>
</body>
</html>