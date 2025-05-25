<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>
    <!-- Loading Animation -->
    <div class="loading-container">
        <!-- Content will be dynamically added by JavaScript -->
    </div>

    <div class="main-wrapper">
        
        <?php include('pcheader.php'); ?>
        <?php include('mobileheader.php'); ?>

        <div class="overlay"></div>
        
        <!-- Enhanced Hero Section -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 60vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">Contact Us</h1>
                <p class="hero-subtitle">We'd love to hear from you! Get in touch with us</p>
            </div>
        </div>

        <!-- Enhanced Contact Section -->
        <div class="contact-enhanced scroll-animate">
            <div class="container">
                
                <!-- Contact Info Cards -->
                <div class="row mb-5">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card scroll-animate">
                            <div class="contact-icon">
                                <i class="icofont-phone"></i>
                            </div>
                            <h4>Call Us</h4>
                            <p>Ready to help you anytime</p>
                            <a href="tel:+0929-2600-261" class="contact-link">0929-2600-261</a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card scroll-animate">
                            <div class="contact-icon">
                                <i class="icofont-email"></i>
                            </div>
                            <h4>Email Us</h4>
                            <p>Send us your queries anytime</p>
                            <a href="mailto:asingancampus@psu.edu.ph" class="contact-link">asingancampus@psu.edu.ph</a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card scroll-animate">
                            <div class="contact-icon">
                                <i class="icofont-location-pin"></i>
                            </div>
                            <h4>Visit Us</h4>
                            <p>Come and meet us in person</p>
                            <a href="https://maps.app.goo.gl/p7iBzYwUE3bWbFNC8" class="contact-link" target="_blank">PSU Asingan Campus</a>
                        </div>
                    </div>
                </div>

                <div class="contact-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-5">
                            <div class="contact-info-modern scroll-animate">
                                <h3 class="section-title mb-4">Get In Touch</h3>
                                <p class="section-subtitle mb-4">We're here to assist you with any questions about our virtual tour system or academic programs.</p>
                                
                                <div class="contact-details">
                                    <div class="contact-item">
                                        <div class="contact-item-icon">
                                            <i class="icofont-phone"></i>
                                        </div>
                                        <div class="contact-item-content">
                                            <h6>Phone Number</h6>
                                            <p><a href="tel:+0929-2600-261">0929-2600-261</a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-item-icon">
                                            <i class="icofont-email"></i>
                                        </div>
                                        <div class="contact-item-content">
                                            <h6>Email Address</h6>
                                            <p><a href="mailto:asingancampus@psu.edu.ph">asingancampus@psu.edu.ph</a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <div class="contact-item-icon">
                                            <i class="icofont-location-pin"></i>
                                        </div>
                                        <div class="contact-item-content">
                                            <h6>Campus Address</h6>
                                            <p>Pangasinan State University<br>Asingan Campus, Pangasinan, Philippines</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Map -->
                                <div class="map-container-modern mt-4">
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.4939654734435!2d120.56611631484752!3d16.030166688902946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339142550a5273d1%3A0x88c07eaf3a6c4e94!2sPangasinan%20State%20University%20-%20Asingan%20Campus!5e0!3m2!1sen!2sph!4v1709697547375!5m2!1sen!2sph" 
                                        width="100%" 
                                        height="300" 
                                        style="border:0; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="contact-form-modern scroll-animate">
                                <div class="form-header">
                                    <h3 class="form-title">Send Us a Message</h3>
                                    <p class="form-subtitle">Fill out the form below and we'll get back to you as soon as possible</p>
                                </div>
                                
                                <div class="form-wrapper">
                                    <form id="contact-form" action="submit_feedback.php" method="POST">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input type="text" id="subject" name="subject" placeholder="What is this about?" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea id="message" name="message" rows="5" placeholder="Tell us more about your inquiry..." required></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button class="btn-modern btn-primary-modern w-100" type="submit">
                                                <i class="icofont-paper-plane"></i>
                                                Send Message
                                            </button>
                                        </div>
                                        
                                        <p class="form-message text-center mt-3"></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="additional-info mt-5">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="info-box scroll-animate">
                                <div class="info-icon">
                                    <i class="icofont-clock-time"></i>
                                </div>
                                <h5>Office Hours</h5>
                                <p>Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 8:00 AM - 12:00 PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="info-box scroll-animate">
                                <div class="info-icon">
                                    <i class="icofont-support-faq"></i>
                                </div>
                                <h5>Virtual Tour Support</h5>
                                <p>Need help with the virtual tour? Our technical support team is available 24/7 to assist you.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="info-box scroll-animate">
                                <div class="info-icon">
                                    <i class="icofont-graduate"></i>
                                </div>
                                <h5>Admissions Office</h5>
                                <p>Questions about our programs? Contact our admissions office for detailed information about enrollment.</p>
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

    <style>
        .contact-enhanced {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .contact-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #FFE047, #FFB800);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: #000;
            transition: all 0.3s ease;
        }

        .contact-card:hover .contact-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .contact-card h4 {
            color: #0A27D8;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .contact-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .contact-link {
            color: #0A27D8;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-link:hover {
            color: #FFB800;
        }

        .contact-info-modern {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: #e9ecef;
            transform: translateX(10px);
        }

        .contact-item-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #0A27D8, #1e40af);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 1.5rem;
        }

        .contact-item-content h6 {
            color: #0A27D8;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .contact-item-content p {
            margin: 0;
            color: #666;
        }

        .contact-form-modern {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            color: #0A27D8;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .form-subtitle {
            color: #666;
            margin: 0;
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
        .form-group textarea:focus {
            outline: none;
            border-color: #0A27D8;
            background: white;
            box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
        }

        .info-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .info-box .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #FFE047, #FFB800);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            color: #000;
        }

        .info-box h5 {
            color: #0A27D8;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-box p {
            color: #666;
            margin: 0;
            line-height: 1.6;
        }

        .section-title {
            color: #0A27D8;
            font-weight: 700;
            font-size: 2rem;
        }

        .section-subtitle {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .contact-enhanced {
                padding: 60px 0;
            }
            
            .contact-card,
            .contact-info-modern,
            .contact-form-modern {
                padding: 30px 20px;
            }
        }
    </style>

</body>

</html> 