<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); 
    require_once 'redirect_if_logged_in.php';
    redirectIfLoggedIn();
?>

<body>

    <div class="main-wrapper">

        <?php include('pcheader.php') ?>

        
         <?php include('mobileheader.php') ?>
        

        
        <div class="overlay"></div>
        

        
        <div class="section slider-section" style="background: url('assets/images/landingpage.jpg') center;height: 100vh;display: flex;
    justify-content: center;
    align-items: center;">

            <div class="landing-text">
        You Should Must To Log In To Access The Tickets

        <div class="landing-center-btn">
                    <a href="login" class="btn" style="background:#FFE047;color: black;font-weight: bold;">Go to Login</a>
                    
            </div>
    </div>

        </div>
        
         <?php include('footer.php'); ?>

        

        
        <a href="#" class="back-to-top">
            <i class="icofont-simple-up"></i>
        </a>
        

    </div>

  <?php include('scripts.php'); ?>

  <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2024/11/02/10/20241102100606-FLZW2GGD.js"></script>
    
</body>

</html>