<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>
    <!-- Loading Animation -->
    <div class="loading-container">
        <div class="loading-spinner"></div>
    </div>

    <div class="main-wrapper">

        <?php include('pcheader.php') ?>
        <?php include('mobileheader.php') ?>

        <div class="overlay"></div>

        <!-- Enhanced Hero Section -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 60vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">Our Academic Programs</h1>
                <p class="hero-subtitle">Quality programs designed for your future success</p>
            </div>
        </div>

        <!-- Enhanced Courses Section -->
        <div class="courses-enhanced scroll-animate">
            <div class="container">
                <!-- Search Section -->
                <div class="row mb-5">
                    <div class="col-md-8 mx-auto">
                        <div class="search-wrapper" style="position: relative;">
                            <div class="input-group" style="border-radius: 50px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <input type="text" id="courseSearch" class="form-control" placeholder="Search for courses, programs, or majors..." style="border: none; padding: 20px 25px; font-size: 1.1rem;">
                                <button class="btn btn-primary" type="button" style="background: linear-gradient(45deg, #FFE047, #FFB800); border: none; padding: 20px 30px; color: #000; font-weight: 600;">
                                    <i class="icofont-search-1"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="filter-tabs text-center">
                            <button class="filter-btn active" data-filter="all">All Programs</button>
                            <button class="filter-btn" data-filter="education">Education</button>
                            <button class="filter-btn" data-filter="business">Business</button>
                            <button class="filter-btn" data-filter="technology">Technology</button>
                        </div>
                    </div>
                </div>

                <div class="courses-wrapper">
                    <div class="row justify-content-center" id="courseContainer">
                        <?php
                        require_once 'Admin/db_conn.php';
                        
                        // Get courses from database
                        $sql = "SELECT * FROM courses ORDER BY course_name";
                        $result = mysqli_query($conn, $sql);
                        
                        // Store database courses in an array
                        $db_courses = array();
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $tag_class = strtolower($row['course_tag']);
                                echo '<div class="col-lg-4 col-md-6 course-item" data-category="'.$tag_class.'">
                                    <div class="course-card-modern scroll-animate">
                                        <div class="course-image-wrapper">
                                            <img src="'.htmlspecialchars($row['course_image']).'" alt="'.htmlspecialchars($row['course_name']).'">
                                            <div class="course-overlay">
                                                <a href="course-details.php?id='.$row['id'].'" class="view-course-btn">Explore Program</a>
                                            </div>
                                            <span class="tag">'.htmlspecialchars($row['course_tag']).'</span>
                                        </div>
                                        <div class="courses-content">
                                            <h4 class="title">'.htmlspecialchars($row['course_name']).'</h4>
                                            <div class="courses-meta">
                                                <div class="ellipsis5" style="font-size: 13px;">'.htmlspecialchars($row['description']).'</div>
                                            </div>
                                            <div class="courses-price-review">
                                                <div class="courses-price" style="text-align: center; width: 100%;">
                                                    <a href="course-details.php?id='.$row['id'].'" class="sale-parice">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                        
                        // Include modern enhanced courses
                        include('default_courses_modern.php');
                        ?>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-5">
                    <div class="cta-section" style="background: linear-gradient(135deg, #0A27D8, #FFE047); padding: 60px 40px; border-radius: 20px; color: white;">
                        <h3 style="margin-bottom: 20px;">Ready to Start Your Journey?</h3>
                        <p style="margin-bottom: 30px; opacity: 0.9;">Explore our campus virtually and discover the perfect program for your future</p>
                        <a href="Vtour/index.htm" class="btn-modern btn-secondary-modern">Take Virtual Tour</a>
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

    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2024/11/02/10/20241102100606-FLZW2GGD.js"></script>
    <script src="assets/js/course-search.js"></script>

    <style>
        .filter-tabs {
            margin-bottom: 40px;
        }
        
        .filter-btn {
            background: transparent;
            border: 2px solid #0A27D8;
            color: #0A27D8;
            padding: 12px 25px;
            margin: 0 10px 10px 0;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: #0A27D8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(10, 39, 216, 0.3);
        }
        
        .course-item {
            transition: all 0.3s ease;
        }
        
        .course-item.hidden {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
        }
        
        .search-wrapper::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>') no-repeat center;
            opacity: 0.5;
            pointer-events: none;
        }
    </style>

    <script>
        // Enhanced filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const courseItems = document.querySelectorAll('.course-item');
            
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    courseItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });
        });
    </script>
</body>

</html> 