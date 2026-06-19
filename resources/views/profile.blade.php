<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <!-- QRious CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <!-- Cropper.js CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <!-- Profile Page Styles -->
    <style>
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        .profile-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
        }

        .profile-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.35rem;
        }

        .profile-card-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.75rem;
        }

        /* Profile Header Card */
        .profile-header-card {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .profile-avatar-container {
            position: relative;
            flex-shrink: 0;
        }

        .profile-avatar-large {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            box-shadow: 0 8px 24px hsla(263, 85%, 55%, 0.25);
            overflow: hidden;
        }

        .profile-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-upload-overlay {
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            cursor: pointer;
        }

        .profile-avatar-container:hover .photo-upload-overlay {
            opacity: 1;
        }

        .photo-upload-overlay svg {
            width: 24px;
            height: 24px;
            color: #fff;
        }

        .photo-upload-input {
            display: none;
        }

        .profile-header-info {
            flex: 1;
        }

        .profile-header-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.25rem;
        }

        .profile-header-email {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .profile-header-role {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .profile-header-role.administrator {
            background: hsla(263, 85%, 65%, 0.15);
            border: 1px solid hsla(263, 85%, 65%, 0.3);
            color: hsl(263, 85%, 75%);
        }

        .profile-header-role.editor {
            background: hsla(190, 95%, 50%, 0.15);
            border: 1px solid hsla(190, 95%, 50%, 0.3);
            color: hsl(190, 95%, 60%);
        }

        .profile-header-role.user {
            background: hsla(290, 80%, 50%, 0.15);
            border: 1px solid hsla(290, 80%, 50%, 0.3);
            color: hsl(290, 80%, 70%);
        }

        /* Form Styling */
        .profile-form-group {
            margin-bottom: 1.25rem;
        }

        .profile-form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .profile-form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: hsla(224, 25%, 10%, 0.5);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-main);
            font-family: var(--font-sans);
            font-size: 0.9rem;
            transition: var(--transition-smooth);
            box-sizing: border-box;
        }

        .profile-form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px hsla(263, 85%, 55%, 0.15);
        }

        .profile-form-group input[readonly] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .profile-form-group .input-hint {
            font-size: 0.78rem;
            color: var(--text-dark);
            margin-top: 0.35rem;
        }

        .profile-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 600px) {
            .profile-form-row {
                grid-template-columns: 1fr;
            }
        }

        .btn-save-profile {
            padding: 0.7rem 1.75rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-family: var(--font-sans);
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .btn-save-profile:hover {
            box-shadow: 0 6px 20px hsla(263, 85%, 55%, 0.35);
            transform: translateY(-1px);
        }

        .btn-save-profile:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* QR Code Card */
        .qrcode-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .qrcode-wrapper {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qrcode-wrapper canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            image-rendering: pixelated;
        }

        .qrcode-label {
            font-size: 0.8rem;
            color: var(--text-dark);
            margin-top: 0.5rem;
        }

        .qrcode-uid {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            font-family: 'Courier New', Courier, monospace;
            letter-spacing: 0.1em;
            margin-top: 0.25rem;
        }

        .btn-download-qrcode {
            margin-top: 1.25rem;
            padding: 0.6rem 1.25rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: transparent;
            color: var(--text-muted);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-download-qrcode:hover {
            background: hsla(224, 20%, 20%, 0.5);
            color: var(--text-main);
            border-color: var(--primary);
        }

        /* Toast Alert */
        .profile-alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 9999;
            max-width: 320px;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            display: none;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: slide-in-toast 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .profile-alert.success {
            background: hsla(150, 85%, 35%, 0.15);
            border: 1px solid hsla(150, 85%, 35%, 0.3);
            color: hsl(150, 85%, 55%);
        }

        .profile-alert.error {
            background: hsla(0, 85%, 45%, 0.15);
            border: 1px solid hsla(0, 85%, 45%, 0.3);
            color: hsl(0, 85%, 65%);
        }

        @keyframes slide-in-toast {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Validation Errors */
        .field-error {
            font-size: 0.78rem;
            color: hsl(0, 85%, 65%);
            margin-top: 0.35rem;
        }

        .profile-form-group input.has-error {
            border-color: hsl(0, 85%, 60%);
        }

        .crop-modal-content {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .crop-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            font-family: var(--font-display);
        }

        .crop-modal-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .crop-container {
            width: 100%;
            max-height: 320px;
            min-height: 240px;
            background: #0f111a;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
        }

        .crop-container img {
            max-width: 100%;
            max-height: 320px;
            display: block;
        }

        .crop-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .btn-crop-cancel {
            padding: 0.6rem 1.25rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: transparent;
            color: var(--text-muted);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-crop-cancel:hover {
            background: hsla(224, 20%, 20%, 0.5);
            color: var(--text-main);
            border-color: var(--primary);
        }

        .btn-crop-confirm {
            padding: 0.6rem 1.25rem;
            background: linear-gradient(135deg, var(--primary) 0%, hsl(263, 85%, 55%) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-crop-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px hsla(263, 85%, 65%, 0.35);
        }

        .btn-crop-confirm:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <div class="dashboard-container">
        @include('partials.sidebar')

        <main class="main-content">

            <header class="content-header">
                <h1 class="content-title">Profile</h1>
                <p class="content-desc">Manage your personal information and account details.</p>
            </header>

            <!-- Toast Alert -->
            <div class="profile-alert" id="profile-alert"></div>

            <div class="profile-grid">

                <!-- Profile Header Card -->
                <div class="profile-card profile-header-card">
                    <div class="profile-avatar-container">
                        <div class="profile-avatar-large" id="profile-avatar">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" id="avatar-img">
                            @else
                                <span id="avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                            @endif
                        </div>
                        <label for="photo-input" class="photo-upload-overlay">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </label>
                        <input type="file" id="photo-input" class="photo-upload-input" accept="image/jpeg,image/png,image/webp">
                    </div>
                    <div class="profile-header-info">
                        <div class="profile-header-name" id="profile-display-name">{{ Auth::user()->name }}</div>
                        <div class="profile-header-email" id="profile-display-email">{{ Auth::user()->email }}</div>
                        <span class="profile-header-role {{ strtolower($user->role?->slug ?? 'user') }}">
                            {{ $user->role?->name ?? 'Guest' }}
                        </span>
                    </div>
                </div>

                <!-- Edit Profile Card -->
                <div class="profile-card">
                    <div class="profile-card-title">Personal Information</div>
                    <div class="profile-card-subtitle">Update your name.</div>

                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="profile-form-row">
                            <div class="profile-form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                                <div class="field-error" id="error-first_name"></div>
                            </div>
                            <div class="profile-form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}">
                                <div class="field-error" id="error-last_name"></div>
                            </div>
                        </div>

                        <div class="profile-form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" value="{{ $user->email }}" readonly>
                            <div class="input-hint">Email cannot be changed.</div>
                        </div>

                        <div class="profile-form-group">
                            <label for="role">Role</label>
                            <input type="text" id="role" value="{{ $user->role?->name ?? 'Guest' }}" readonly>
                            <div class="input-hint">Role cannot be changed from this page.</div>
                        </div>

                        <button type="submit" class="btn-save-profile" id="btn-save-profile">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            <span>Save Changes</span>
                        </button>
                    </form>
                </div>

                <!-- QR Code ID Card -->
                <div class="profile-card qrcode-card">
                    <div class="profile-card-title">Member QR Code</div>
                    <div class="profile-card-subtitle">Your unique identification QR code.</div>

                    @php $barcodeUid = $user->member_id ?? ('UID-' . str_pad($user->id, 6, '0', STR_PAD_LEFT)); @endphp

                    <div class="qrcode-wrapper" id="qrcode-wrapper">
                        <canvas id="qrcode-canvas" data-uid="{{ $barcodeUid }}" style="image-rendering: pixelated;"></canvas>
                    </div>
                    <div class="qrcode-label">Member ID</div>
                    <div class="qrcode-uid">{{ $barcodeUid }}</div>

                    <button type="button" class="btn-download-qrcode" id="btn-download-qrcode">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <span>Download QR Code</span>
                </div>

                <!-- Cropping Modal -->
                <dialog id="crop-dialog" closedby="any" class="glass-dialog" aria-labelledby="cropDialogTitle">
                    <div class="crop-modal-content">
                        <h3 id="cropDialogTitle" class="crop-modal-title">Crop Profile Photo</h3>
                        <p class="crop-modal-subtitle">Adjust the selection box to crop your image into a square.</p>
                        <div class="crop-container">
                            <img id="crop-preview-img" src="" alt="Source preview">
                        </div>
                        <div class="crop-modal-actions">
                            <button type="button" class="btn-crop-cancel" id="btn-crop-cancel">Cancel</button>
                            <button type="button" class="btn-crop-confirm" id="btn-crop-confirm">Confirm & Save</button>
                        </div>
                    </div>
                </dialog>

            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ── QR Code Generation ──
            const qrCanvas = document.getElementById('qrcode-canvas');
            const barcodeUid = qrCanvas.getAttribute('data-uid');
            let qr;
            try {
                qr = new QRious({
                    element: qrCanvas,
                    value: barcodeUid,
                    size: 160,
                    background: '#ffffff',
                    foreground: '#000000',
                    level: 'H'
                });
            } catch (e) {
                console.error('QR Code generation failed:', e);
            }

            // ── QR Code Download ──
            document.getElementById('btn-download-qrcode').addEventListener('click', function() {
                if (!qrCanvas) return;
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const padding = 40;

                canvas.width = qrCanvas.width + padding * 2;
                canvas.height = qrCanvas.height + padding + 60;

                // Draw white background card with rounded corners
                ctx.fillStyle = '#ffffff';
                if (typeof ctx.roundRect === 'function') {
                    ctx.roundRect(0, 0, canvas.width, canvas.height, 16);
                } else {
                    ctx.rect(0, 0, canvas.width, canvas.height);
                }
                ctx.fill();

                // Draw QR Code
                ctx.drawImage(qrCanvas, padding, padding);

                // Draw text
                ctx.fillStyle = '#1a1a2e';
                ctx.font = 'bold 14px Courier New, Courier, monospace';
                ctx.textAlign = 'center';
                ctx.fillText(barcodeUid, canvas.width / 2, qrCanvas.height + padding + 35);

                // Trigger download
                const link = document.createElement('a');
                link.download = barcodeUid + '-QR.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });

            // ── Photo Upload & Crop Flow ──
            const photoInput = document.getElementById('photo-input');
            const cropDialog = document.getElementById('crop-dialog');
            const cropPreviewImg = document.getElementById('crop-preview-img');
            const btnCropCancel = document.getElementById('btn-crop-cancel');
            const btnCropConfirm = document.getElementById('btn-crop-confirm');
            let cropperInstance = null;
            let originalFileName = '';

            // Handle file input changes
            photoInput.addEventListener('change', function() {
                if (!this.files || !this.files[0]) return;

                const file = this.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    showToast('error', 'Photo must be under 2MB.');
                    this.value = ''; // Reset input
                    return;
                }

                originalFileName = file.name;

                // Load image into FileReader for cropping
                const reader = new FileReader();
                reader.onload = function(e) {
                    cropPreviewImg.src = e.target.result;
                    
                    // Reset input so they can upload same file again
                    photoInput.value = '';

                    // Open crop modal dialog natively
                    cropDialog.showModal();

                    // Initialize Cropper.js instance
                    if (cropperInstance) {
                        cropperInstance.destroy();
                    }
                    cropperInstance = new Cropper(cropPreviewImg, {
                        aspectRatio: 1, // force square crop
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        responsive: true,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            });

            // Close dialog & destroy cropper helper
            function closeCropDialog() {
                cropDialog.close();
                if (cropperInstance) {
                    cropperInstance.destroy();
                    cropperInstance = null;
                }
                cropPreviewImg.src = '';
                btnCropConfirm.disabled = false;
                btnCropConfirm.textContent = 'Confirm & Save';
            }

            // Cancel button handler
            btnCropCancel.addEventListener('click', closeCropDialog);

            // Escape key listener or dialog close requests cleanup
            cropDialog.addEventListener('close', function() {
                if (cropperInstance) {
                    cropperInstance.destroy();
                    cropperInstance = null;
                }
                cropPreviewImg.src = '';
            });

            // Fallback for click outside modal (backdrop click dismiss)
            if (!('closedBy' in HTMLDialogElement.prototype)) {
                cropDialog.addEventListener('click', function(event) {
                    if (event.target !== cropDialog) return;
                    const rect = cropDialog.getBoundingClientRect();
                    const isDialogContent = (
                        rect.top <= event.clientY &&
                        event.clientY <= rect.top + rect.height &&
                        rect.left <= event.clientX &&
                        event.clientX <= rect.left + rect.width
                    );
                    if (!isDialogContent) {
                        closeCropDialog();
                    }
                });
            }

            // Confirm crop and upload via AJAX
            btnCropConfirm.addEventListener('click', function() {
                if (!cropperInstance) return;

                btnCropConfirm.disabled = true;
                btnCropConfirm.textContent = 'Uploading...';

                // Get cropped canvas (resized to 400x400 for profile photo)
                const canvas = cropperInstance.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                // Convert canvas to compressed jpeg blob
                canvas.toBlob(function(blob) {
                    if (!blob) {
                        showToast('error', 'Failed to generate cropped image.');
                        btnCropConfirm.disabled = false;
                        btnCropConfirm.textContent = 'Confirm & Save';
                        return;
                    }

                    const formData = new FormData();
                    formData.append('profile_photo', blob, originalFileName || 'cropped-avatar.jpg');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    fetch('{{ route("profile.photo") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => {
                        if (!response.ok) return response.json().then(d => { throw d; });
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update avatar on profile page
                            const avatarDiv = document.getElementById('profile-avatar');
                            avatarDiv.innerHTML = '<img src="' + data.photo_url + '" alt="Profile Photo" id="avatar-img">';

                            // Update sidebar avatar as well
                            const sidebarAvatar = document.getElementById('sidebar-avatar');
                            if (sidebarAvatar) {
                                sidebarAvatar.innerHTML = '<img src="' + data.photo_url + '" alt="Profile Photo">';
                            }

                            showToast('success', 'Photo cropped and updated successfully.');
                            closeCropDialog();
                        }
                    })
                    .catch(errData => {
                        const msg = errData.errors?.profile_photo?.[0] || errData.message || 'Failed to upload photo.';
                        showToast('error', msg);
                        btnCropConfirm.disabled = false;
                        btnCropConfirm.textContent = 'Confirm & Save';
                    });
                }, 'image/jpeg', 0.9);
            });

            // ── AJAX Profile Update ──
            const form = document.getElementById('profile-form');
            const btnSave = document.getElementById('btn-save-profile');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
                document.querySelectorAll('.has-error').forEach(el => el.classList.remove('has-error'));

                btnSave.disabled = true;

                const formData = new FormData(form);

                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) return response.json().then(d => { throw d; });
                    return response.json();
                })
                .then(data => {
                    btnSave.disabled = false;
                    if (data.success) {
                        document.getElementById('profile-display-name').textContent = data.user.name;
                        document.getElementById('profile-display-email').textContent = data.user.email;

                        // Update avatar initials only if no photo
                        const initialsEl = document.getElementById('avatar-initials');
                        if (initialsEl) initialsEl.textContent = data.user.initials;

                        showToast('success', 'Profile updated successfully.');
                    }
                })
                .catch(errData => {
                    btnSave.disabled = false;
                    if (errData.errors) {
                        for (const [field, messages] of Object.entries(errData.errors)) {
                            const errorEl = document.getElementById('error-' + field);
                            const inputEl = document.getElementById(field);
                            if (errorEl) errorEl.textContent = messages[0];
                            if (inputEl) inputEl.classList.add('has-error');
                        }
                    } else {
                        showToast('error', errData.message || 'An error occurred.');
                    }
                });
            });

            // ── Toast Helper ──
            function showToast(type, message) {
                const alertDiv = document.getElementById('profile-alert');
                const icon = type === 'success'
                    ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>'
                    : '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>';

                alertDiv.className = 'profile-alert ' + type;
                alertDiv.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + icon + '</svg><span>' + message + '</span>';
                alertDiv.style.display = 'flex';
                setTimeout(() => { alertDiv.style.display = 'none'; }, 4000);
            }

        });
    </script>
</body>
</html>
