<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        --success: #00b894;
        --warning: #fdcb6e;
        --danger: #d63031;
    }

    .gc-chat-container {
        max-width: 1000px;
        margin: 2rem auto;
        display: grid;
        grid-template-rows: auto 1fr auto;
        height: 85vh;
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.1);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .gc-chat-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .gc-chat-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--success), var(--primary-light));
    }

    .gc-chat-title {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .gc-chat-title i {
        font-size: 1.2rem;
    }

    .gc-chat-role-badge {
        background: rgba(255, 255, 255, 0.15);
        padding: 0.35rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gc-messages-container {
        padding: 1.5rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        background-color: var(--light);
        background-image: linear-gradient(rgba(245, 246, 250, 0.9), rgba(245, 246, 250, 0.9)), 
                          url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236c5ce7' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .gc-message {
        max-width: 80%;
        padding: 0;
        position: relative;
        animation: fadeIn 0.3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
    }

    .gc-message-content {
        padding: 1rem;
        border-radius: 1.25rem;
        line-height: 1.5;
        position: relative;
        word-break: break-word;
    }

    .gc-message.sent .gc-message-content {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-bottom-right-radius: 0.25rem;
    }

    .gc-message.received .gc-message-content {
        background: var(--white);
        color: var(--dark);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border-bottom-left-radius: 0.25rem;
    }

    .gc-message-info {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        gap: 0.75rem;
    }

    .gc-message.sent .gc-message-info {
        justify-content: flex-end;
    }

    .gc-message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .gc-message-sender {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .gc-message.sent .gc-message-sender {
        color: var(--primary-light);
    }

    .gc-message.received .gc-message-sender {
        color: var(--secondary);
    }

    .gc-message-time {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .gc-message.sent .gc-message-time {
        text-align: right;
        color: rgba(255, 255, 255, 0.8);
    }

    .gc-message.received .gc-message-time {
        color: #7f8c8d;
    }

    .gc-input-container {
        padding: 1.25rem;
        background: var(--white);
        border-top: 1px solid var(--gray-light);
    }

    .gc-message-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
    }

    .gc-input-wrapper {
        flex: 1;
        position: relative;
    }

    .gc-message-input {
        width: 100%;
        padding: 1rem 4.5rem 1rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: 1.25rem;
        resize: none;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.2s;
        min-height: 60px;
        max-height: 150px;
        background: var(--light);
    }

    .gc-message-input:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
    }

    .gc-input-actions {
        position: absolute;
        right: 0.75rem;
        bottom: 0.75rem;
        display: flex;
        gap: 0.5rem;
    }

    .gc-file-label {
        cursor: pointer;
        color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
       margin-top: 6px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .gc-file-label:hover {
        background: rgba(108, 92, 231, 0.2);
    }

    .gc-file-input {
        display: none;
      

    }

    .gc-send-button {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        width: 38px;
        height: 38px;
        margin-top: 6px;
        border-radius: 50%;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
    }

    .gc-send-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(108, 92, 231, 0.4);
    }

    .gc-send-button:disabled {
        background: var(--gray-light);
        box-shadow: none;
        cursor: not-allowed;
        transform: none !important;
    }

    /* File message styling */
    .gc-file-message {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 0.75rem;
        margin-top: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .gc-message.received .gc-file-message {
        background: rgba(245, 246, 250, 0.8);
    }

    .gc-file-message:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .gc-message.received .gc-file-message:hover {
        background: rgba(245, 246, 250, 1);
    }

    .gc-file-icon {

        font-size: 1.5rem;
        margin-right: 0.75rem;
        color: var(--primary);
    }

    .gc-file-info {
        flex: 1;
        overflow: hidden;
    }

    .gc-file-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .gc-file-size {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .gc-message.received .gc-file-size {
        color: #7f8c8d;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar */
    .gc-messages-container::-webkit-scrollbar {
        width: 8px;
    }

    .gc-messages-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.02);
    }

    .gc-messages-container::-webkit-scrollbar-thumb {
        background: rgba(108, 92, 231, 0.2);
        border-radius: 4px;
    }

    .gc-messages-container::-webkit-scrollbar-thumb:hover {
        background: rgba(108, 92, 231, 0.3);
    }

    /* Date dividers */
    .gc-date-divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .gc-date-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(0, 0, 0, 0.08);
        z-index: 1;
    }

    .gc-date-divider span {
        background: var(--light);
        padding: 0.25rem 1rem;
        position: relative;
        z-index: 2;
        color: #7f8c8d;
        font-size: 0.8rem;
        border-radius: 2rem;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05);
    }

    /* Role restriction notice */
    .gc-role-notice {
        background: rgba(214, 48, 49, 0.1);
        color: var(--danger);
        padding: 1rem;
        border-radius: 0.75rem;
        text-align: center;
        margin-bottom: 1rem;
        border: 1px solid rgba(214, 48, 49, 0.2);
    }

    /* Empty state */
    .gc-empty-state {
        text-align: center;
        padding: 3rem;
        color: #7f8c8d;
    }

    .gc-empty-state i {
        font-size: 3rem;
        color: var(--gray-light);
        margin-bottom: 1rem;
    }

    .gc-empty-state p {
        margin: 0;
        font-size: 1.1rem;
    }
    .back-to-menu-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
    }
    
    .back-to-menu-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        background: linear-gradient(135deg, #6c5ce7 0%, #8479f2 100%);
    }
    
    .back-to-menu-btn:active {
        transform: translateY(0);
    }
    
    .back-to-menu-btn i {
        margin-right: 10px;
        transition: transform 0.3s ease;
    }
    
    .back-to-menu-btn:hover i {
        transform: translateX(-5px);
    }
    
    .back-to-menu-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.3) 100%);
        transform: translateX(-100%);
        transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }
    
    .back-to-menu-btn:hover::after {
        transform: translateX(0);
    }
</style>
<a href="{{ route('chat.index') }}" class="back-to-menu-btn">
    <i class="fas fa-chevron-left"></i> Back to Main Menu
</a>
<div class="gc-chat-container">
    <div class="gc-chat-header">
        <h2 class="gc-chat-title">
            <i class="fas fa-users"></i>
            {{ $course->title }} Group Chat
        </h2>
        <span class="gc-chat-role-badge">
            <i class="fas fa-user-tag"></i>
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>
 
    <div class="gc-messages-container">
        @php $currentDate = null @endphp
        @if($messages->isEmpty())
            <div class="gc-empty-state">
                <i class="fas fa-comment-slash"></i>
                <p>No messages yet. Start the conversation!</p>
            </div>
        @else
            @foreach($messages as $message)
                @php $messageDate = $message->created_at->format('Y-m-d') @endphp
                @if($messageDate != $currentDate)
                    <div class="gc-date-divider">
                        <span>{{ $message->created_at->format('F j, Y') }}</span>
                    </div>
                    @php $currentDate = $messageDate @endphp
                @endif
                
                <div class="gc-message @if($message->sender_id == auth()->id()) sent @else received @endif">
                    <div class="gc-message-info">
                        @if($message->sender_id != auth()->id())
                            <div class="gc-message-avatar">
                                {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="gc-message-sender">{{ $message->sender->name }}</span>
                        <span class="gc-message-time">{{ $message->created_at->format('g:i A') }}</span>
                    </div>
                    <div class="gc-message-content">
                        @if($message->message)
                            <p>{{ $message->message }}</p>
                        @endif
                        @if($message->file_path)
                            <a href="{{ Storage::url($message->file_path) }}" target="_blank" class="gc-file-message">
                                <i class="fas fa-file-pdf gc-file-icon"></i>
                                <div class="gc-file-info">
                                    <div class="gc-file-name">{{ basename($message->file_path) }}</div>
                                    <div class="gc-file-size">{{ round(Storage::disk('public')->size($message->file_path) / 1024) }} KB</div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="gc-input-container">
        <form method="POST" action="{{ route('chat.group.send', $course->id) }}" class="gc-message-form" enctype="multipart/form-data">
            @csrf
            <div class="gc-input-wrapper">
                @if(auth()->user()->role == 'parent')
                    <textarea 
                        name="message" 
                        class="gc-message-input" 
                        placeholder="This group is for instructors only. You can't send messages here." 
                        rows="1"
                        disabled
                    ></textarea>
                    <div class="gc-role-notice">
                        <i class="fas fa-info-circle"></i> This group chat is for instructors only.
                    </div>
                @else
                    <textarea 
                        name="message" 
                        class="gc-message-input" 
                        placeholder="Type your message here..." 
                        rows="1"
                    ></textarea>
                    <div class="gc-input-actions">
                        <label for="gc-file-upload" class="gc-file-label">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input type="file" id="gc-file-upload" name="file" class="gc-file-input" accept=".pdf">
                        <button type="submit" class="gc-send-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-resize textarea
        const textarea = document.querySelector('.gc-message-input');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    
        // Scroll to bottom of messages
        const messagesContainer = document.querySelector('.gc-messages-container');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    
        // Show file name when selected
        const fileInput = document.getElementById('gc-file-upload');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    const messageInput = document.querySelector('.gc-message-input');
                    if (messageInput) {
                        messageInput.placeholder = `Attached: ${fileName}`;
                    }
                }
            });
        }
    });
</script>
