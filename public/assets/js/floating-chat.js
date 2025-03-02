class FloatingChat {
    constructor() {
        if (document.querySelector('.floating-chat-icon')) {
            return;
        }
        this.isOpen = false;
        this.init();
    }

    init() {
        this.createChatIcon();
        this.createChatWidget();
        this.bindEvents();
    }

    createChatIcon() {
        const icon = document.createElement('div');
        icon.className = 'floating-chat-icon';
        icon.innerHTML = '<i class="ti ti-message-circle"></i>';
        document.body.appendChild(icon);
        this.chatIcon = icon;
    }

    createChatWidget() {
        const widget = document.createElement('div');
        widget.className = 'chat-widget';
        widget.innerHTML = `
            <div class="chat-header">
                <span>Chat with AI</span>
                <button class="chat-close">&times;</button>
            </div>
            <div class="chat-messages"></div>
            <div class="chat-input-container">
                <textarea placeholder="Type your message..." rows="3"></textarea>
                <button type="button">Send</button>
            </div>
        `;
        document.body.appendChild(widget);
        this.chatWidget = widget;
        this.messagesContainer = widget.querySelector('.chat-messages');
        this.textarea = widget.querySelector('textarea');
    }

    bindEvents() {
        this.chatIcon.addEventListener('click', () => this.toggleChat());
        this.chatWidget.querySelector('.chat-close').addEventListener('click', () => this.toggleChat());
        this.chatWidget.querySelector('button').addEventListener('click', () => this.sendMessage());
        this.textarea.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        this.chatWidget.classList.toggle('active', this.isOpen);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const chatTrigger = document.getElementById('chat-trigger');
    const chatWidget = document.querySelector('.chat-widget');
    const chatClose = document.querySelector('.chat-close');
    const chatInput = document.querySelector('.chat-input-container textarea');
    const sendButton = document.querySelector('.chat-input-container button');

    function toggleChat() {
        chatWidget.classList.toggle('active');
    }

    chatTrigger.addEventListener('click', toggleChat);
    chatClose.addEventListener('click', toggleChat);

    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Handle message sending here
            chatInput.value = '';
        }
    }
});