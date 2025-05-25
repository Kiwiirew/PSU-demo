<!DOCTYPE html>
<html lang="en">
 
<link rel="stylesheet" href="assets/css/styles1.css">
<!-- Head Section -->
<?php include('head.php'); 
       require_once 'session_check.php'; // Adjust the path if needed
       authMiddleware();
?>

<!-- CSS for styling the form container and form elements -->


<body>
    <div class="main-wrapper">
        <!-- Header Sections-->
        <?php include('userpcheader.php'); ?>
        <?php include('usermobileheader.php'); ?> 

        <div class="overlay"></div> 
    
                <!-- Form Section -->
                <div class="section section-padding">
                    <div class="form-container">
                        <?php if (isset($_SESSION['user_name'])): ?>
                            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 😊</h2>
                            <p>We’re glad to see you here. You can access the ticket support by clicking the ticket support tab above or on the side bar .</p>
                        <?php else: ?>
                            <h2>Welcome! 😊</h2>
                            <p>Please log in to see your personalized dashboard.</p>
                        <?php endif; ?>
                    </div>
                </div>

        <!-- Back to Top Button -->
        <a href="#" class="back-to-top">
            <i class="icofont-simple-up"></i>
        </a>
    </div>

    <!-- Include Scripts -->
    <?php include('scripts.php'); ?>
</body>

</html>
