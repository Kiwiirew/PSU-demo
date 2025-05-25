<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

    <div class="main-wrapper">
        
        <?php include('userpcheader.php'); ?>
        <?php include('mobileheader.php'); ?>

        <div class="overlay"></div>
        
        <div class="section page-banner" style="background: url('assets/images/landingpage.jpg') center; text-align: center;">
            <div class="landing-text" style="text-align: center; margin: auto;">
                We'd love to hear from you!
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
                                        <p><a href="mailto:asingancampus@psu.edu.ph">asingancampus@psu.edu.ph</a></p>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="contact-form">
                                <h3 class="title">Send Us Your <span>Feedback</span></h3>
                                <p class="subtitle">Help us improve by sharing your thoughts and suggestions</p>
                                <div class="form-wrapper">
                                    <form id="contact-form" action="submit_feedback.php" method="POST">
                                        <div class="single-form">
                                            <input type="text" name="name" placeholder="Full Name" required>
                                        </div>
                                        <div class="single-form">
                                            <input type="email" name="email" placeholder="Email Address" required>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" name="subject" placeholder="Subject/Topic" required>
                                        </div>
                                        
                                        <!-- Enhanced Rating System -->
                                        <div class="single-form rating-form">
                                            <label class="form-label">Rate Your Experience</label>
                                            <div class="star-rating">
                                                <input type="radio" name="rating" value="5" id="star5" required>
                                                <label for="star5" title="Excellent"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" value="4" id="star4">
                                                <label for="star4" title="Very Good"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" value="3" id="star3">
                                                <label for="star3" title="Good"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" value="2" id="star2">
                                                <label for="star2" title="Fair"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" value="1" id="star1">
                                                <label for="star1" title="Poor"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="rating-text">
                                                <span id="rating-description">Select a rating</span>
                                            </div>
                                        </div>
                                        
                                        <div class="single-form">
                                            <textarea name="message" placeholder="Your detailed feedback, suggestions, or comments..." rows="6" required></textarea>
                                        </div>
                                        
                                        <p class="form-message"></p>
                                        
                                        <div class="single-form">
                                            <button class="btn btn-primary btn-hover-dark w-100" type="submit" id="submitBtn">
                                                <i class="fas fa-paper-plane"></i> Send Feedback
                                            </button>
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

    <!-- Enhanced CSS for Rating System -->
    <style>
        .contact-form .title {
            color: #0A27D8;
            margin-bottom: 10px;
        }
        
        .contact-form .subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .rating-form {
            margin: 20px 0;
        }
        
        .rating-form .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #ddd;
            transition: all 0.3s ease;
            padding: 5px;
        }
        
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input[type="radio"]:checked ~ label {
            color: #FFE047;
            transform: scale(1.1);
        }
        
        .star-rating label:hover {
            color: #FFC107;
        }
        
        .rating-text {
            text-align: center;
            margin-top: 10px;
        }
        
        .rating-text span {
            font-weight: 600;
            color: #0A27D8;
            font-size: 14px;
        }
        
        .single-form {
            margin-bottom: 20px;
        }
        
        .single-form input,
        .single-form textarea {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .single-form input:focus,
        .single-form textarea:focus {
            border-color: #0A27D8;
            box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #0A27D8, #1e3a8a);
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(10, 39, 216, 0.3);
        }
        
        .form-message {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        
        .form-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }
        
        .form-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
        
        @media (max-width: 768px) {
            .star-rating label {
                font-size: 1.5rem;
            }
        }
    </style>

    <!-- Enhanced JavaScript for Rating -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            const ratingDescription = document.getElementById('rating-description');
            const form = document.getElementById('contact-form');
            const submitBtn = document.getElementById('submitBtn');
            
            const ratingTexts = {
                5: 'Excellent - Outstanding experience!',
                4: 'Very Good - Great experience!',
                3: 'Good - Satisfactory experience',
                2: 'Fair - Could be improved',
                1: 'Poor - Needs significant improvement'
            };
            
            // Handle rating selection
            ratingInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const rating = this.value;
                    ratingDescription.textContent = ratingTexts[rating];
                    ratingDescription.style.color = rating >= 4 ? '#28a745' : rating >= 3 ? '#ffc107' : '#dc3545';
                });
            });
            
            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Change button state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                submitBtn.disabled = true;
                
                // Submit form
                const formData = new FormData(form);
                
                fetch('submit_feedback.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    const messageEl = document.querySelector('.form-message');
                    
                    if (data.includes('successfully')) {
                        messageEl.className = 'form-message success';
                        messageEl.innerHTML = '<i class="fas fa-check-circle"></i> Thank you! Your feedback has been submitted successfully.';
                        form.reset();
                        ratingDescription.textContent = 'Select a rating';
                        ratingDescription.style.color = '#0A27D8';
                    } else {
                        messageEl.className = 'form-message error';
                        messageEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Sorry, there was an error submitting your feedback. Please try again.';
                    }
                    
                    // Reset button
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Feedback';
                    submitBtn.disabled = false;
                })
                .catch(error => {
                    const messageEl = document.querySelector('.form-message');
                    messageEl.className = 'form-message error';
                    messageEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Network error. Please check your connection and try again.';
                    
                    // Reset button
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Feedback';
                    submitBtn.disabled = false;
                });
            });
        });
    </script>

</body>

</html>
