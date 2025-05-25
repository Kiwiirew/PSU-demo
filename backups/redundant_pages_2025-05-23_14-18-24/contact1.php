<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); 
    require_once 'session_check.php'; // Adjust the path if needed
    authMiddleware();
?>

<body>

    <div class="main-wrapper">
        
        <?php include('userpcheader.php'); ?>
        <?php include('usermobileheader.php'); ?>

        <div class="overlay"></div>
        
        <div class="section page-banner" style="background: url('assets/images/landingpage.jpg') center; text-align: center;">
            <div class="landing-text" style="text-align: center; margin: auto;">
                We’d love to hear from you!
            </div>
        </div>

        <div class="section section-padding">
            <div class="container">

                <div class="contact-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6" id="contactinfo">
                            <div class="contact-info">
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-phone-call"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="title">Phone No.</h6>
                                        <p><a href="tel:+63752299100">09123456789</a></p>
                                    </div>
                                </div>
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-email"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="title">Email Address</h6>
                                        <p><a href="mailto:info@psu.edu.ph">info@psu.edu.ph</a></p>
                                    </div>
                                </div>
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-pin"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="title">Office Address</h6>
                                        <p>Pangasinan State University, Lingayen Campus, Lingayen, Pangasinan, Philippines</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="contact-form">
                                <h3 class="title">Get in Touch <span>With Us</span></h3>
                                <div class="form-wrapper">
                                    <form id="contact-form" action="https://htmlmail.hasthemes.com/humayun/edule-contact.php" method="POST">
                                        <div class="single-form">
                                            <input type="text" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="single-form">
                                            <input type="email" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" name="subject" placeholder="Subject" required>
                                        </div>
                                        <div class="single-form">
                                            <textarea name="message" placeholder="Message" required></textarea>
                                        </div>
                                        <p class="form-message"></p>
                                        <div class="single-form">
                                            <button class="btn btn-primary btn-hover-dark w-100" type="submit">Send Message <i class="flaticon-right"></i></button>
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
