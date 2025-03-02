class FloatingChat {
    constructor() {
        this.isOpen = false;
        this.init();
    }

    init() {
        this.chatWidget = document.querySelector('.chat-widget');
        this.chatTrigger = document.getElementById('chat-trigger');
        this.chatClose = this.chatWidget.querySelector('.chat-close');
        this.messagesContainer = this.chatWidget.querySelector('.chat-messages');
        this.textarea = this.chatWidget.querySelector('textarea');
        // Fix: Select the send button specifically from chat-input-container
        this.sendButton = this.chatWidget.querySelector('.chat-input-container button');
        
        this.bindEvents();
    }

    bindEvents() {
        console.log('Binding events...'); 
        console.log('Send button:', this.sendButton); // Should now show the correct button
        
        if (!this.sendButton) {
            console.error('Send button not found!');
            return;
        }

        this.chatTrigger.addEventListener('click', () => {
            console.log('Chat trigger clicked');
            this.toggleChat();
        });
        
        this.chatClose.addEventListener('click', () => {
            console.log('Chat close clicked');
            this.toggleChat();
        });
        
        this.sendButton.addEventListener('click', (e) => {
            console.log('Send button clicked');
            e.preventDefault();
            this.sendMessage();
        });
        
        this.textarea.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                console.log('Enter pressed');
                e.preventDefault();
                this.sendMessage();
            }
        });
    }

    showThinkingIndicator() {
        const thinkingDiv = document.createElement('div');
        thinkingDiv.className = 'ai-thinking';
        thinkingDiv.innerHTML = `
            I'm thinking
            <div class="thinking-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;
        this.messagesContainer.appendChild(thinkingDiv);
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        return thinkingDiv;
    }

    async sendMessage() {
        const message = this.textarea.value.trim();
        console.log('Sending message:', message); // Debug log
        
        if (!message) return;

        // Add user message to chat
        this.addMessage('user', message);
        this.textarea.value = '';

        // Show thinking indicator
        const thinkingIndicator = this.showThinkingIndicator();

        try {
            const formData = new FormData();
            formData.append('question', message);
            
            console.log('Sending request to server...'); // Debug log
            
            const response = await fetch('/phpbookstore/chat/processMessage', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            // Remove thinking indicator
            thinkingIndicator.remove();
            
            console.log('Response received:', response); // Debug log
            
            const data = await response.json();
            console.log('Parsed data:', data); // Debug log
            
            if (data.status === 'success') {
                this.addMessage('ai', data.message);
            } else {
                this.addMessage('error', 'Sorry, I could not process your request.');
            }
        } catch (error) {
            // Remove thinking indicator
            thinkingIndicator.remove();
            
            console.error('Detailed error:', error); // More detailed error logging
            this.addMessage('error', 'Error: Could not connect to the server.');
        }
    }

    addMessage(type, content) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${type}-message`;
        
        // Format the content
        if (type === 'ai') {
            // Remove <think> tags
            content = content.replace(/<think>.*?<\/think>/g, '');
            
            // Format math expressions
            content = content.replace(/\\(.*?\\)/g, match => 
                `<span class="math-expression">${match}</span>`);
            
            // Format numbered lists/steps
            content = content.replace(/(\d+\.\s+.*?)(?=\d+\.|$)/g, match =>
                `<div class="step-item">${match}</div>`);
            
            // Add line breaks for readability
            content = content.replace(/\n/g, '<br>');
        }
        
        messageDiv.innerHTML = content;
        this.messagesContainer.appendChild(messageDiv);
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        this.chatWidget.classList.toggle('active', this.isOpen);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new FloatingChat();
});