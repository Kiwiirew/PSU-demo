<!DOCTYPE html>
<html lang="en">

<?php 
include('head.php'); 
require_once 'session_manager.php';

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

        <!-- Flash Message Display -->
        <?php if ($flashMessage): ?>
            <div class="flash-message-container">
                <div class="container">
                    <div class="alert alert-<?php echo $flashMessage['type'] === 'error' ? 'danger' : $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flashMessage['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Enhanced Hero Section with Parallax -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 60vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">Our Academic Programs</h1>
                <p class="hero-subtitle">Discover excellent education opportunities at Pangasinan State University</p>
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
                                <button class="btn btn-primary" type="button" id="searchBtn" style="background: linear-gradient(45deg, #FFE047, #FFB800); border: none; padding: 20px 30px; color: #000; font-weight: 600;">
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
                                // Determine category based on course tag or name
                                $category = strtolower($row['course_tag']);
                                
                                // Map common education terms
                                if (strpos(strtolower($row['course_name']), 'education') !== false || 
                                    strpos(strtolower($row['course_tag']), 'education') !== false ||
                                    strpos(strtolower($row['course_name']), 'teaching') !== false) {
                                    $category = 'education';
                                }
                                
                                // Map business terms
                                if (strpos(strtolower($row['course_name']), 'business') !== false || 
                                    strpos(strtolower($row['course_tag']), 'business') !== false ||
                                    strpos(strtolower($row['course_name']), 'management') !== false) {
                                    $category = 'business';
                                }
                                
                                // Map technology terms
                                if (strpos(strtolower($row['course_name']), 'technology') !== false || 
                                    strpos(strtolower($row['course_tag']), 'technology') !== false ||
                                    strpos(strtolower($row['course_name']), 'information') !== false ||
                                    strpos(strtolower($row['course_name']), 'computer') !== false) {
                                    $category = 'technology';
                                }
                                
                                echo '<div class="col-lg-4 col-md-6 course-item" data-category="'.$category.'" data-name="'.strtolower($row['course_name']).'" data-description="'.strtolower($row['description']).'">
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
                        
                        // Include default static courses with proper categories
                        ?>
                        <!-- Static Courses with proper categories -->
                        <div class="col-lg-4 col-md-6 course-item" data-category="technology" data-name="bachelor of science in information technology" data-description="information technology computer programming software development database management">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course1.jpeg" alt="BSIT">
                                    <div class="course-overlay">
                                        <a href="courses-bsit.php" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Technology</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Science in Information Technology</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Comprehensive IT program covering programming, software development, database management, and system administration</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="courses-bsit.php" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 course-item" data-category="education" data-name="bachelor of technology and livelihood education" data-description="education teaching technology livelihood technical vocational">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course2.jpg" alt="BTLE">
                                    <div class="course-overlay">
                                        <a href="courses-btle.php" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Education</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Technology and Livelihood Education</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Prepare students to become effective teachers in technology and livelihood education</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="courses-btle.php" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 course-item" data-category="business" data-name="bachelor of science in business administration" data-description="business administration management marketing financial management economics">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course3.png" alt="BSBA">
                                    <div class="course-overlay">
                                        <a href="course-details.php?course=bsba" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Business</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Science in Business Administration</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Comprehensive business education covering management, marketing, and entrepreneurship</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="course-details.php?course=bsba" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 course-item" data-category="education" data-name="bachelor of secondary education" data-description="education teaching secondary school curriculum development classroom management">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course1.jpeg" alt="BSE">
                                    <div class="course-overlay">
                                        <a href="courses-bse.php" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Education</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Secondary Education</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Prepare future educators with specialized knowledge in their chosen major and effective teaching strategies</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="courses-bse.php" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 course-item" data-category="education" data-name="bachelor of elementary education" data-description="education teaching elementary school general education young learners">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course2.jpg" alt="BEE">
                                    <div class="course-overlay">
                                        <a href="courses-bee.php" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Education</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Elementary Education</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Train teachers for elementary education with enhanced general education and skills for young learners</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="courses-bee.php" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 course-item" data-category="technology" data-name="bachelor of industrial technology" data-description="technology industrial manufacturing practical skills theoretical knowledge">
                            <div class="course-card-modern scroll-animate">
                                <div class="course-image-wrapper">
                                    <img src="assets/images/courses/course3.png" alt="BIT">
                                    <div class="course-overlay">
                                        <a href="courses-bit.php" class="view-course-btn">Explore Program</a>
                                    </div>
                                    <span class="tag">Technology</span>
                                </div>
                                <div class="courses-content">
                                    <h4 class="title">Bachelor of Industrial Technology</h4>
                                    <div class="courses-meta">
                                        <div class="ellipsis5" style="font-size: 13px;">Specialized training in industrial technology fields with practical skills for manufacturing sectors</div>
                                    </div>
                                    <div class="courses-price-review">
                                        <div class="courses-price" style="text-align: center; width: 100%;">
                                            <a href="courses-bit.php" class="sale-parice">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="text-center" style="display: none; padding: 60px 20px;">
                    <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                        <i class="icofont-search-document" style="font-size: 4rem; color: #0A27D8; margin-bottom: 20px;"></i>
                        <h3 style="color: #0A27D8; margin-bottom: 15px;">No Programs Found</h3>
                        <p style="color: #666; margin-bottom: 20px;">We couldn't find any programs matching your search criteria.</p>
                        <button class="btn-modern btn-primary-modern" onclick="resetFilters()">View All Programs</button>
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
            transition: all 0.5s ease;
            margin-bottom: 30px;
        }
        
        .course-item.hidden {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
            height: 0;
            overflow: hidden;
            margin: 0;
            padding: 0;
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

        @media (max-width: 768px) {
            .filter-btn {
                margin: 5px;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        // Enhanced filter and search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const courseItems = document.querySelectorAll('.course-item');
            const searchInput = document.getElementById('courseSearch');
            const searchBtn = document.getElementById('searchBtn');
            const noResults = document.getElementById('noResults');
            
            let currentFilter = 'all';
            let currentSearch = '';
            
            // Filter functionality
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    currentFilter = this.getAttribute('data-filter');
                    applyFilters();
                });
            });
            
            // Search functionality
            function performSearch() {
                currentSearch = searchInput.value.toLowerCase().trim();
                applyFilters();
            }
            
            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
            
            // Real-time search (optional - you can remove this if you prefer button-only search)
            searchInput.addEventListener('input', function() {
                currentSearch = this.value.toLowerCase().trim();
                applyFilters();
            });
            
            // Apply both filter and search
            function applyFilters() {
                let visibleCount = 0;
                
                courseItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    const name = item.getAttribute('data-name') || '';
                    const description = item.getAttribute('data-description') || '';
                    
                    // Check filter criteria
                    const matchesFilter = currentFilter === 'all' || category === currentFilter;
                    
                    // Check search criteria
                    const matchesSearch = currentSearch === '' || 
                                        name.includes(currentSearch) || 
                                        description.includes(currentSearch) ||
                                        category.includes(currentSearch);
                    
                    if (matchesFilter && matchesSearch) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });
                
                // Show/hide no results message
                if (visibleCount === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }
            
            // Reset filters function
            window.resetFilters = function() {
                // Reset search
                searchInput.value = '';
                currentSearch = '';
                
                // Reset filter to "All Programs"
                filterBtns.forEach(btn => btn.classList.remove('active'));
                document.querySelector('[data-filter="all"]').classList.add('active');
                currentFilter = 'all';
                
                // Apply filters
                applyFilters();
            };
            
            // Initial load
            applyFilters();
        });
        
        // Image fallback handling
        document.addEventListener('DOMContentLoaded', function() {
            const courseImages = document.querySelectorAll('.course-image-wrapper img');
            
            courseImages.forEach(img => {
                img.addEventListener('error', function() {
                    // Create a fallback element
                    const fallback = document.createElement('div');
                    fallback.style.cssText = `
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(135deg, #0A27D8, #FFE047);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-size: 3rem;
                        font-weight: bold;
                    `;
                    fallback.textContent = '📚';
                    
                    // Replace the image with the fallback
                    this.parentNode.replaceChild(fallback, this);
                });
                
                // Trigger load check
                if (!img.complete || img.naturalWidth === 0) {
                    img.src = img.src; // Reload
                }
            });
        });
    </script>
</body>

</html>