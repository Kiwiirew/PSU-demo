<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="assets/css/styles1.css">

<?php 
include('head.php'); 
require_once 'session_manager.php';

// Require login to access this page
SessionManager::requireLogin('login.php');

// Get current user info
$currentUser = SessionManager::getCurrentUser();
$flashMessage = SessionManager::getFlashMessage();
?>

<body>
    <!-- Loading Animation -->
    <div class="loading-container">
        <!-- Content will be dynamically added by JavaScript -->
    </div>

    <div class="main-wrapper">
        
        <?php include('dynamic_header.php'); ?>
        <?php include('dynamic_mobile_header.php'); ?>

        <div class="overlay"></div>

        <!-- Flash Message Display -->
        <?php if ($flashMessage): ?>
            <div class="flash-message-container">
                <div class="container">
                    <div class="alert alert-<?php echo $flashMessage['type'] === 'error' ? 'danger' : $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flashMessage['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Enhanced Hero Section -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 40vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">IT Service Ticket</h1>
                <p class="hero-subtitle">Submit a support request and get help from our technical team</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="section section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="form-container-modern">
                            
                            <!-- Welcome Message -->
                            <div class="user-welcome-section">
                                <div class="user-info">
                                    <h2>Welcome, <?php echo htmlspecialchars($currentUser['name']); ?>! 👋</h2>
                                    <p>We're here to help you with any technical issues. Please provide detailed information about your problem so our team can assist you effectively.</p>
                                </div>
                            </div>

                            <form action="submit_ticket.php" method="POST" enctype="multipart/form-data">
                                <!-- CSRF Token -->
                                <input type="hidden" name="csrf_token" value="<?php echo SessionManager::generateCSRFToken(); ?>">
                                
                                <!-- Auto-fill user info from session -->
                                <input type="hidden" name="user_id" value="<?php echo $currentUser['id']; ?>">

                                <!-- Name Fields (Pre-filled) -->
                                <div class="form-group">
                                    <label for="full-name">Full Name</label>
                                    <input type="text" id="full-name" name="full_name" value="<?php echo htmlspecialchars($currentUser['name']); ?>" readonly class="readonly-field">
                                </div>

                                <!-- Email Field (Pre-filled) -->
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" readonly class="readonly-field">
                                </div>

                                <!-- Department Field -->
                                <div class="form-group">
                                    <label for="department">Department/Program</label>
                                    <select id="department" name="department" required>
                                        <option value="">Select your Department/Program</option>
                                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                                        <option value="BSBA">Bachelor of Science in Business Administration</option>
                                        <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                                        <option value="BEE">Bachelor of Elementary Education</option>
                                        <option value="BIT">Bachelor of Industrial Technology</option>
                                        <option value="BSE">Bachelor of Secondary Education</option>
                                        <option value="Faculty">Faculty Member</option>
                                        <option value="Staff">Staff Member</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Priority Level -->
                                <div class="form-group">
                                    <label for="priority">Priority Level</label>
                                    <select id="priority" name="priority" required>
                                        <option value="">Select Priority Level</option>
                                        <option value="Low">Low - General inquiry or minor issue</option>
                                        <option value="Medium">Medium - Affecting work but workaround available</option>
                                        <option value="High">High - Significantly impacting work</option>
                                        <option value="Critical">Critical - System down or urgent issue</option>
                                    </select>
                                </div>

                                <!-- Issue Category -->
                                <div class="form-group">
                                    <label for="category">Issue Category</label>
                                    <select id="category" name="category" required>
                                        <option value="">Select Issue Category</option>
                                        <option value="Virtual Tour">Virtual Tour Access/Navigation</option>
                                        <option value="Website">Website Functionality</option>
                                        <option value="Login">Login/Account Issues</option>
                                        <option value="Course Information">Course Information</option>
                                        <option value="Technical Support">General Technical Support</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- File Upload Field -->
                                <div class="form-group">
                                    <label for="screenshot">Upload Screenshots (Optional)</label>
                                    <div class="file-upload-modern" onclick="document.getElementById('screenshot').click()">
                                        <input type="file" id="screenshot" name="screenshot[]" multiple style="display: none;" accept="image/*">
                                        <div class="upload-content">
                                            <i class="icofont-upload-alt"></i>
                                            <p>Click here to upload screenshots</p>
                                            <small>Supported formats: JPG, PNG, GIF (Max 5MB each)</small>
                                        </div>
                                    </div>
                                    <div id="image-preview" class="image-preview-container"></div>
                                </div>

                                <!-- Problem Description -->
                                <div class="form-group">
                                    <label for="description">Describe the Problem</label>
                                    <textarea id="description" name="description" placeholder="Please provide detailed information about the issue you're experiencing..." required rows="6"></textarea>
                                    <small class="form-text">Include steps to reproduce the issue, error messages, and any other relevant details.</small>
                                </div>

                                <!-- Hidden Status Field -->
                                <input type="hidden" id="status" name="status" value="1">

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="btn-modern btn-primary-modern w-100">
                                        <i class="icofont-paper-plane"></i> Submit Ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>

        <!-- Back to Top Button -->
        <a href="#" class="back-to-top floating">
            <i class="icofont-simple-up"></i>
        </a>
    </div>

    <?php include('scripts.php'); ?>

    <script>
        const screenshotInput = document.getElementById('screenshot');
        const imagePreview = document.getElementById('image-preview');
        const maxFileSize = 5 * 1024 * 1024; // 5MB max file size

        screenshotInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';

            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    if (file.size > maxFileSize) {
                        showFileError(`File too large: ${file.name} (Max 5MB)`);
                        return;
                    }

                    if (file.type.startsWith('image/')) {
                        createImagePreview(file, index);
                    } else {
                        showFileError(`Invalid file type: ${file.name}`);
                    }
                });
            }
        });

        function createImagePreview(file, index) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';

                previewItem.innerHTML = `
                    <div class="preview-image">
                        <img src="${e.target.result}" alt="Screenshot Preview">
                        <button type="button" class="remove-image" onclick="removeImage(this)">
                            <i class="icofont-close"></i>
                        </button>
                    </div>
                    <div class="preview-info">
                        <span class="file-name">${file.name}</span>
                        <span class="file-size">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                    </div>
                `;

                imagePreview.appendChild(previewItem);
            };

            reader.readAsDataURL(file);
        }

        function removeImage(button) {
            button.closest('.preview-item').remove();
        }

        function showFileError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'file-error';
            errorDiv.textContent = message;
            imagePreview.appendChild(errorDiv);

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        // Form validation and submission enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="icofont-spinner-alt-2 icofont-spin"></i> Submitting...';
            submitBtn.disabled = true;

            // Re-enable button after a delay in case of form validation errors
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
    </script>

    <style>
        .form-container-modern {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }

        .user-welcome-section {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            text-align: center;
        }

        .user-welcome-section h2 {
            color: #0A27D8;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .user-welcome-section p {
            color: #666;
            margin: 0;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0A27D8;
            background: white;
            box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
        }

        .readonly-field {
            background: #e9ecef !important;
            color: #6c757d;
            cursor: not-allowed;
        }

        .file-upload-modern {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .file-upload-modern:hover {
            border-color: #0A27D8;
            background: rgba(10, 39, 216, 0.05);
        }

        .upload-content i {
            font-size: 3rem;
            color: #0A27D8;
            margin-bottom: 15px;
        }

        .upload-content p {
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .upload-content small {
            color: #666;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .preview-item {
            position: relative;
            background: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            min-width: 150px;
        }

        .preview-image {
            position: relative;
        }

        .preview-image img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-info {
            margin-top: 10px;
            text-align: center;
        }

        .file-name {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .file-size {
            font-size: 0.8rem;
            color: #666;
        }

        .file-error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .form-text {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .form-container-modern {
                padding: 20px;
                margin-top: -30px;
            }

            .user-welcome-section {
                padding: 20px;
            }
        }
    </style>

</body>

</html>
