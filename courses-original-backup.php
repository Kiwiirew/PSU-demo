
<!DOCTYPE html>

<!--client-side courses--->
<?php include('head.php'); ?>

<body>
<div>
    <div class="main-wrapper">

        <?php include('pcheader.php') ?>

        <?php include('mobileheader.php') ?>

        <div class="overlay"></div>

        <div class="section page-banner"  style="background: url('assets/images/landingpage.jpg') center; text-align: center;">

             <div class="landing-text" style="text-align: center;margin: auto;">
       Quality programs for your future.

    </div>

        </div>

        <div class="section section-padding-02" style="margin-bottom: 100px;">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-6 mx-auto">
                        <div class="input-group">
                            <input type="text" id="courseSearch" class="form-control" placeholder="Search courses...">
                            <button class="btn btn-primary" type="button">
                                <i class="icofont-search-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="courses-wrapper">
                    <div class="row" style="justify-content: center;" id="courseContainer">
                        <?php
                        require_once 'Admin/db_conn.php';
                        
                        // Get courses from database
                        $sql = "SELECT * FROM courses ORDER BY course_name";
                        $result = mysqli_query($conn, $sql);
                        
                        // Store database courses in an array
                        $db_courses = array();
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-lg-4 col-md-6">
                                    <div class="single-courses">
                                        <div class="courses-images">
                                            <img src="'.htmlspecialchars($row['course_image']).'" alt="Course">
                                            <span class="tag">'.htmlspecialchars($row['course_tag']).'</span>
                                        </div>
                                        <div class="courses-content">
                                            <h4 class="title">'.htmlspecialchars($row['course_name']).'</h4>
                                            <div class="courses-meta">
                                                <div class="ellipsis5" style="font-size: 13px;">'.htmlspecialchars($row['description']).'</div>
                                            </div>
                                            <div class="courses-link">
                                                <button class="view-more-btn" onclick="location.href=\'course-details.php?id='.$row['id'].'\'">View More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                        
                        // Include default courses
                        include('default_courses.php');
                        ?>
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
<script src="assets/js/course-search.js"></script>
</body>

</html>