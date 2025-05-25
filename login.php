<!DOCTYPE html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php 
include('head.php'); 
require_once 'session_manager.php';

// Redirect if already logged in
SessionManager::redirectIfLoggedIn('index.php');

// Get flash message if any
$flashMessage = SessionManager::getFlashMessage();
?>

<body>
    <!-- Loading Animation -->
    <div class="loading-container">
        <!-- Content will be dynamically added by JavaScript -->
    </div>

    <div class="main-wrapper">

        <?php include('dynamic_header.php') ?>
        <?php include('dynamic_mobile_header.php') ?>

        <div class="overlay"></div>

        <!-- Enhanced Hero Section -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 60vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">Welcome Back</h1>
                <p class="hero-subtitle">Access your account securely to continue your PSU journey</p>
            </div>
        </div>

        <div class="section section-padding">
            <div class="container">

                <!-- Flash Message Display -->
                <?php if ($flashMessage): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-<?php echo $flashMessage['type'] === 'error' ? 'danger' : $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($flashMessage['message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="register-login-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="register-login-images" style="background:transparent;margin-top: -30px;">
                                <div class="images">
                                    <img src="assets/images/logo.jpg" alt="PSU Logo">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="register-login-form">
                                <h3 class="title">Login <span>Now</span></h3>
                                <div class="form-wrapper">
                                    <form id="loginForm" action="login_backend.php" method="POST">
                                        <!-- CSRF Token -->
                                        <input type="hidden" name="csrf_token" value="<?php echo SessionManager::generateCSRFToken(); ?>">
                                        
                                        <div class="single-form">
                                            <input id="email" type="email" name="email" placeholder="Email Address" required>
                                        </div>
                                        
                                        <div class="single-form">
                                            <input id="password" type="password" name="password" placeholder="Password" required>
                                        </div>
                                        
                                        <div style="color: #0A28DA;font-weight: 400;margin-top: 10px;cursor: pointer;">
                                            <a href="#" style="color: #0A28DA; text-decoration: none;">Forgot password?</a>
                                        </div>
                                        
                                        <div class="single-form">
                                            <button type="submit" class="btn-modern btn-primary-modern w-100">
                                                <i class="icofont-login"></i> Sign In
                                            </button>
                                        </div>
                                        
                                        <div class="text-center mt-3">
                                            <p>Don't have an account? <a href="register.php" style="color: #0A28DA; font-weight: 600;">Sign Up</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>

        <a href="#" class="back-to-top floating">
            <i class="icofont-simple-up"></i>
        </a>
    </div>

    <?php include('scripts.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                var email = $('#email').val().trim();
                var password = $('#password').val();

                if (email === '' || password === '') {
                    showAlert("Both email and password are required.", 'danger');
                    return;
                }

                // Show loading state
                var submitBtn = $(this).find('button[type="submit"]');
                var originalText = submitBtn.html();
                submitBtn.html('<i class="icofont-spinner-alt-2 icofont-spin"></i> Signing In...').prop('disabled', true);

                $.ajax({
                    url: 'login_backend.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        password: password,
                        csrf_token: $('input[name="csrf_token"]').val()
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            setTimeout(function() {
                                window.location.href = response.redirect || 'index.php';
                            }, 1000);
                        } else {
                            showAlert(response.message, 'danger');
                            submitBtn.html(originalText).prop('disabled', false);
                        }
                    },
                    error: function() {
                        showAlert('An error occurred. Please try again.', 'danger');
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            function showAlert(message, type) {
                // Remove existing alerts
                $('.alert').remove();
                
                // Add new alert
                var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                               message +
                               '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                               '</div>';
                
                $('#loginForm').prepend(alertHtml);
            }
        });
    </script>

    <style>
        .register-login-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .register-login-form .title {
            color: #0A27D8;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .single-form {
            margin-bottom: 20px;
        }

        .single-form input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .single-form input:focus {
            outline: none;
            border-color: #0A27D8;
            background: white;
            box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
        }

        .register-login-images img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }
    </style>

</body>

</html>