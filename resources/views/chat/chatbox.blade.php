@extends('layouts.master')

@section('content')
<style>
    :root {
        --primary: #6c5ce7;
        --primary-light: #a29bfe;
        --secondary: #fd79a8;
        --dark: #2d3436;
        --light: #f5f6fa;
        --white: #ffffff;
        --gray-light: #dfe6e9;
    }

    .chat-container {
        max-width: 1000px;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.1);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        direction: rtl; /* Added RTL direction to the entire container */
    }

    .chat-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-header-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .chat-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .chat-title {
        margin: 0;
        font-weight: 600;
    }

    .chat-role {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .messages-container {
        height: 60vh;
        padding: 1.5rem;
        overflow-y: auto;
        background-color: var(--light);
    }

    .message {
        margin-bottom: 1.5rem;
        max-width: 80%;
        direction: ltr; /* Messages remain LTR */
        text-align: left; /* Messages remain left-aligned */
    }

    .message.sent {
        margin-left: auto; /* Push sent messages to the right */
    }

    .message.received {
        margin-right: auto; /* Push received messages to the left */
    }

    .message-content {
        padding: 1rem;
        border-radius: 1.25rem;
        position: relative;
        word-break: break-word;
    }

    .message.sent .message-content {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-bottom-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }

    .message.received .message-content {
        background: var(--white);
        color: var(--dark);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border-bottom-left-radius: 0.25rem;
        border-bottom-right-radius: 0;
    }

    .message-time {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: block;
        text-align: left;
    }

    .chat-input-container {
        padding: 1rem;
        background-color: var(--white);
        border-top: 1px solid var(--gray-light);
    }

    .message-form {
        position: relative;
    }

    .message-input-wrapper {
        position: relative;
    }

    /* .message-input {
        width: 100%;
        padding: 1rem 4rem 1rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: 2rem;
        resize: none;
        outline: none;
        font-family: inherit;
        transition: border-color 0.2s;
    } */

    .message-input:focus {
        border-color: var(--primary-light);
    }

    .input-actions {
    position: absolute;
    right: 0.75rem; 
    bottom: 0.75rem;
    display: flex;
    gap: 0.5rem;
}
.message-input {
    width: 100%;
    padding: 1rem 1rem 1rem 2rem; 
    border: 1px solid var(--gray-light);
    border-radius: 1.25rem;
    resize: none;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.2s;
    min-height: 60px;
    max-height: 150px;
    background: var(--light);
    text-align: left;
}


    .file-input-label {
        cursor: pointer;
        color: var(--primary);
        font-size: 1.2rem;
        margin-top : 1.25rem;

    }

    .file-input {
        display: none;
    }

    .send-button {
        background: none;
        border: none;
        color: var(--primary);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
    }

    .file-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: rgba(255,255,255,0.2);
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        text-decoration: none;
        color: inherit;
    }

    .file-icon {
        font-size: 1.5rem;
    }

    .file-info {
        display: flex;
        flex-direction: column;
    }

    .file-name {
        font-weight: 500;
    }

    .file-size {
        font-size: 0.75rem;
        opacity: 0.7;
    }

    .back-button {
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        margin-top : 1.25rem;

    }

    @media (max-width: 768px) {
        .chat-container {
            margin: 0;
            border-radius: 0;
            height: 100vh;
        }
        
        .messages-container {
            height: calc(100vh - 200px);
        }
    }
</style>

<div class="chat-container">
    <div class="chat-header">
        <button class="back-button" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        
        <div class="chat-header-info">
            {{-- <div class="chat-avatar">
                {{ strtoupper(substr($receiver->name, 0, 1)) }}
            </div> --}}
            <div>
                <h3 class="chat-title">{{ $receiver->name }}</h3>
                {{-- <div class="chat-role">{{ ucfirst($receiver->role) }}</div> --}}
            </div>
        </div>
    </div>

    <div class="messages-container" id="messages-container">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <div class="message-content">
                    @if($message->message)
                        <p>{{ $message->message }}</p>
                    @endif
                    
                    @if($message->file_path)
                        <a href="{{ Storage::url($message->file_path) }}" target="_blank" class="file-message">
                            <i class="fas fa-file-pdf file-icon"></i>
                            <div class="file-info">
                                <div class="file-name">{{ basename($message->file_path) }}</div>
                                <div class="file-size">{{ round(Storage::disk('public')->size($message->file_path) / 1024) }} KB</div>
                            </div>
                        </a>
                    @endif
                    
                    <span class="message-time">
                        {{ $message->created_at->format('h:i A - M j, Y') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="chat-input-container">
        <form method="POST" action="{{ route('chat.store') }}" class="message-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
            
            <div class="message-input-wrapper">
                <textarea 
                    name="message" 
                    class="message-input" 
                    placeholder="...Type your message here" 
                    rows="1"
                ></textarea>
                
                <div class="input-actions">
                    <button type="submit" class="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    
                    <label for="file-upload" class="file-input-label">
                        <i class="fas fa-paperclip"></i>
                    </label>
                    <input type="file" id="file-upload" name="file" class="file-input">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-scroll to bottom
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
        
        // Auto-resize textarea
        const textarea = document.querySelector('.message-input');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Show file name when selected
        const fileInput = document.getElementById('file-upload');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const messageInput = document.querySelector('.message-input');
                messageInput.placeholder = `Attached: ${fileName}`;
            } else {
                document.querySelector('.message-input').placeholder = 'Type your message here...';
            }
        });
    });
</script>
@endsection