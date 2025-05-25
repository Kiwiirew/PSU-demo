<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

    <div class="main-wrapper">

         
        <?php include('pcheader.php') ?>

        

        <?php include('mobileheader.php') ?>

        
        <div class="overlay"></div>
        

        
        
           <div class="section page-banner"  style="background: url('assets/images/landingpage.jpg') center; text-align: center;">

            
             <div class="landing-text" style="text-align: center;margin: auto;">
      Join us and start your journey.

    </div>
</div>
        

        
        <div class="section section-padding">
            <div class="container">

                
                <div class="register-login-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6">

                            
                            <div class="register-login-images" style="background:transparent;margin-top: -30px;">
                              

                                <div class="images">
                                    <img src="assets/images/logo.jpg" alt="Register Login">
                                </div>
                            </div>
                            

                        </div>
                        <div class="col-lg-6">

                            
                            <div class="register-login-form">
                                <h3 class="title">Registration <span>Now</span></h3>

                                <div class="form-wrapper">
                                <form action="backend.php" method="POST">
                                    <div class="single-form">
                                        <input type="text" name="name" placeholder="Name" required>
                                    </div>

                                    <div class="single-form">
                                        <input type="email" name="email" placeholder="Email @psu.edu.ph" required>
                                    </div>

                                    <div class="single-form">
                                        <input type="password" name="password" placeholder="Password" required>
                                    </div>

                                    <div class="single-form">
                                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                    </div>

                                    <div class="single-form">
                                        <button type="submit" class="btn btn-primary btn-hover-dark w-100">Create an account</button>
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
        

        
        <a href="#" class="back-to-top">
            <i class="icofont-simple-up"></i>
        </a>
        

    </div>

  <?php include('scripts.php'); ?>

</body>

</html>