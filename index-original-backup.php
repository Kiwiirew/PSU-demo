<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

    <div class="main-wrapper">

        <?php include('pcheader.php') ?>

        
         <?php include('mobileheader.php') ?>
        

        
        <div class="overlay"></div>
        

        
        <div class="section slider-section" style="background: url('assets/images/landingpage.jpg') center;height: 100vh;display: flex;
    justify-content: center;
    align-items: center;">

            <div class="landing-text">
        Step Inside Our School with a Virtual Tour

        <div class="landing-center-btn">
                    <a href="Vtour/index.htm" class="btn" style="background:#FFE047;color: black;font-weight: bold;">Take a Tour</a>
                    <a href="Vtour/index.htm" class="btn" style="color:white;font-weight: bold;">Learn More</a>
            </div>
    </div>

        </div>
        

         
        <div class="section section-padding mt-n1">
            <div class="container">

                
                <div class="section-title shape-03 text-center">
                    <h5 class="sub-title">Features</h5>
                    <h2 class="main-title">Discover Our Features</h2>
                </div>
                

                
                <div class="featuresflex" >

                   

                    
                    <div class="featurediv" style="padding-top: 0px;">

                        <div class="featuretext">
                            <h3 class="title">Immersive Virtual Tours</h3>
                            <p>Experience a realistic 360-degree view of our school campus from the comfort of your home</p>
                        </div>
                    </div>

                    <div class="featurediv" style="padding-top: 0px;">

                        <div class="featuretext">
                            <h3 class="title">Interactive Image</h3>
                            <p>Navigate through our school facilities with interactive maps to explore every corner effortlessly</p>
                        </div>
                    </div>
                    <div class="featurediv" style="padding-top: 0px;">

                        <div class="featuretext">
                            <h3 class="title">Live Chat Support</h3>
                            <p>Get instant assistance and answers to your queries through our chatbot support available 24/7</p>
                        </div>
                    </div>
                    

                  

                    
                    <div class="featurediv" style="padding-top: 0px;">

                        <div class="featuretext">
                            <h3 class="title">Ticketing System</h3>
                            <p>Raise and track support tickets efficiently for any technical issues or during the virtual tour</p>
                        </div>
                    </div>
                    

                </div>

                

            </div>
        </div>
        

        <div class="section-padding-02 mt-n10">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">

                            
                            <div class="about-images">
                                <div class="images">
                                    <img src="assets/images/logotitle.png" alt="About">
                                </div>

                                
                            </div>
                            

                        </div>
                        <div class="col-lg-6">

                            
                            <div class="about-content">
                                <h5 class="sub-title">About us</h5>
                                <h2 class="main-title">Pangasinan State University</h2>
                                <p>Pangasinan State University aims to be a premier institution in the ASEAN Region. Asingan Campus fully supports this vision by focusing on instruction, research, extension, and production functions. Despite its size, the campus has achieved significant milestones, including a 100% completion rate for several programs. The campus has also received accreditation and produced board topnotchers. In addition to instruction, the campus is actively involved in research, extension, and production activities, contributing to the community and achieving recognition for its work.</p>
                                
                            </div>
                            

                        </div>
                    </div>
                </div>
            </div>

        
        <div class="section section-padding-02" style="margin-bottom: 100px;">
            <div class="container">
                <div class="section-title shape-03 text-center">
                    <h5 class="sub-title">Our Programs</h5>
                    <h2 class="main-title">Featured Courses</h2>
                </div>

                <div class="courses-wrapper">
                    <div class="row" style="justify-content: center;" id="courseContainer">
                        <?php
                        // Include default courses
                        include('default_courses.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section section-padding-02 mt-n1" style="margin-bottom: 100px;">
            <div class="container">

                
                <div class="section-title shape-03 text-center">
                    <h5 class="sub-title">Feedback</h5>
                    <h2 class="main-title">Our Testimonials</h2>
                </div>
                

                
                <div class="testimonial-wrapper testimonial-active">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            
                            <div class="single-testimonial swiper-slide">
                                <div class="testimonial-author">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimon/salagubang.jpg" alt="Author">

                                        <i class="icofont-quote-left"></i>
                                    </div>

                                    <span class="rating-star">
                                            <span class="rating-bar" style="width: 80%;"></span>
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <p>"The learning experiences I got from PSU has brought added value to my life. It was a splendid journey based on strong foundation of knowledge provided by the competent faculty and vibrant staff."</p>
                                    <h4 class="name">Jesus O. Salagubang</h4>
                                    <span class="designation">Vocational Administrator III</span>
                                </div>
                            </div>
                            

                            
                            <div class="single-testimonial swiper-slide">
                                <div class="testimonial-author">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimon/mariano.jpg" alt="Author">

                                        <i class="icofont-quote-left"></i>
                                    </div>

                                    <span class="rating-star">
                                            <span class="rating-bar" style="width: 80%;"></span>
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <p>"PSU has provided me the best possible platform to build my dynamic personality. Truly, the future of the PSUnians is a great hands and they are on the right path to becoming successful global leaders in whichever fields they go."</p>
                                    <h4 class="name">Evangeline A. Mariano</h4>
                                    <span class="designation">Assistant Principal II</span>
                                </div>
                            </div>
                            

                            
                            <div class="single-testimonial swiper-slide">
                                <div class="testimonial-author">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimon/velasco.jpg" alt="Author">

                                        <i class="icofont-quote-left"></i>
                                    </div>

                                    <span class="rating-star">
                                            <span class="rating-bar" style="width: 80%;"></span>
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <p>"It has been a great experience being a part of PSU which not only gave me quality education but also has helped me for my overall personality. Thank you and continue with what you have started.<i>Mabuhay ang PSU</i>"</p>
                                    <h4 class="name">Juanito M. Velasco</h4>
                                    <span class="designation">Principal III</span>
                                </div>
                            </div>
                            

                            <div class="single-testimonial swiper-slide">
                                <div class="testimonial-author">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimon/tabilin.jpg" alt="Author">

                                        <i class="icofont-quote-left"></i>
                                    </div>

                                    <span class="rating-star">
                                            <span class="rating-bar" style="width: 80%;"></span>
                                    </span>
                                </div>
                                <div class="testimonial-content">
                                    <p>"I am thankful to PSU-AC for the quality education I received throughout my year of study and for the best teachers who shared their wisdom and expertise which form part of my today's success." </p>
                                    <h4 class="name">Jay A. Tabilin</h4>
                                    <span class="designation">Supply Chain Manager</span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="swiper-pagination"></div>
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

  <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2024/11/02/10/20241102100606-FLZW2GGD.js"></script>
    
</body>

</html>