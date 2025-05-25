<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

    <div class="main-wrapper">
        
        <?php include('pcheader.php'); ?>
        <?php include('mobileheader.php'); ?>

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
                            <a href="tel:+63752299100">
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-phone-call"></i>
                                    </div>
                                    </a>
                                    <div class="info-content">
                                        <h6 class="title">Phone No.</h6>
                                        <p><a href="tel:+0929-2600-261">0929-2600-261</a></p>
                                    </div>
                                </div>
                                <a href="mailto:info@psu.edu.ph">
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-email"></i>
                                    </div>
                                    </a>
                                    <div class="info-content">
                                        <h6 class="title">Email Address</h6>
                                        <p style="font-size: 1.20em;"><a href="mailto:asingancampus@psu.edu.ph">asingancampus@psu.edu.ph</a></p>
                                    </div>
                                </div>
                                <a href="https://maps.app.goo.gl/p7iBzYwUE3bWbFNC8">
                                <div class="single-contact-info">
                                    <div class="info-icon">
                                        <i class="flaticon-pin"></i>
                                    </div>
                                    </a>
                                    <div class="info-content">
                                        <h6 class="title">Office Address</h6>
                                        <p>Pangasinan State University, Asingan Campus, Pangasinan, Philippines</p>
                                        <div class="map-container" style="margin-top: 15px;">
                                            <iframe 
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.4939654734435!2d120.56611631484752!3d16.030166688902946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339142550a5273d1%3A0x88c07eaf3a6c4e94!2sPangasinan%20State%20University%20-%20Asingan%20Campus!5e0!3m2!1sen!2sph!4v1709697547375!5m2!1sen!2sph" 
                                                width="100%" 
                                                height="250" 
                                                style="border:0; border-radius: 8px;" 
                                                allowfullscreen="" 
                                                loading="lazy" 
                                                referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="contact-form">
                                <h3 class="title">Get in Touch <span>With Us</span></h3>
                                <div class="form-wrapper">
                                    <form id="contact-form" action="submit_feedback.php" method="POST">
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
