<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $course_tag = mysqli_real_escape_string($conn, $_POST['course_tag']);
    $course_video = mysqli_real_escape_string($conn, $_POST['course_video']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $career_opportunities = mysqli_real_escape_string($conn, $_POST['career_opportunities']);
    $skills_gained = mysqli_real_escape_string($conn, $_POST['skills_gained']);
    $future_impact = mysqli_real_escape_string($conn, $_POST['future_impact']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $total_subjects = intval($_POST['total_subjects']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $certificate = mysqli_real_escape_string($conn, $_POST['certificate']);
    $portal_link = mysqli_real_escape_string($conn, $_POST['portal_link']);

    // Handle course image upload
    $target_dir = "../assets/images/courses/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES["course_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = "course_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["course_image"]["tmp_name"], $target_file)) {
        // Insert course into database
        $image_path = "assets/images/courses/" . $new_filename;
        $sql = "INSERT INTO courses (course_name, course_tag, course_image, course_video, description, 
                                   career_opportunities, skills_gained, future_impact, duration, total_subjects,
                                   level, language, certificate, portal_link) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die('Error preparing statement: ' . mysqli_error($conn));
        }
        
        if (!mysqli_stmt_bind_param($stmt, "sssssssssissss", $course_name, $course_tag, $image_path, $course_video, 
                                   $description, $career_opportunities, $skills_gained, $future_impact,
                                   $duration, $total_subjects, $level, $language, $certificate, $portal_link)) {
            die('Error binding parameters: ' . mysqli_stmt_error($stmt));
        }
        
        if (!mysqli_stmt_execute($stmt)) {
            die('Error executing statement: ' . mysqli_stmt_error($stmt));
        }
        
        $course_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Handle instructor uploads
        $instructor_names = $_POST['instructor_names'];
        $instructor_designations = $_POST['instructor_designations'];
        $instructor_images = $_FILES['instructor_images'];
        
        $instructor_dir = $target_dir . "instructors/";
        if (!is_dir($instructor_dir)) {
            mkdir($instructor_dir, 0777, true);
        }

        // Prepare instructor insert statement
        $sql = "INSERT INTO course_instructors (course_id, instructor_name, designation, instructor_image) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt === false) {
            die('Error preparing instructor statement: ' . mysqli_error($conn));
        }

        // Process each instructor
        for ($i = 0; $i < count($instructor_names); $i++) {
            if ($instructor_names[$i] && $instructor_designations[$i] && $instructor_images['name'][$i]) {
                $instructor_img_ext = strtolower(pathinfo($instructor_images['name'][$i], PATHINFO_EXTENSION));
                $instructor_filename = "instructor_" . time() . "_" . $i . "." . $instructor_img_ext;
                $instructor_target = $instructor_dir . $instructor_filename;
                
                if (move_uploaded_file($instructor_images['tmp_name'][$i], $instructor_target)) {
                    $instructor_image_path = "assets/images/courses/instructors/" . $instructor_filename;
                    
                    if (!mysqli_stmt_bind_param($stmt, "isss", $course_id, $instructor_names[$i], 
                                              $instructor_designations[$i], $instructor_image_path)) {
                        die('Error binding instructor parameters: ' . mysqli_stmt_error($stmt));
                    }
                    
                    if (!mysqli_stmt_execute($stmt)) {
                        die('Error executing instructor statement: ' . mysqli_stmt_error($stmt));
                    }
                }
            }
        }
        
        mysqli_stmt_close($stmt);
        header("Location: courses.php");
        exit();
    } else {
        header("Location: add-course.php?error=Failed to upload image");
        exit();
    }
}

// Handle course deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $course_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get course and instructor images before deletion
    $sql = "SELECT course_image FROM courses WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die('Error preparing statement: ' . mysqli_error($conn));
    }
    
    if (!mysqli_stmt_bind_param($stmt, "i", $course_id)) {
        die('Error binding parameters: ' . mysqli_stmt_error($stmt));
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        die('Error executing statement: ' . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Delete course image
        $image_path = "../" . $row['course_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Get and delete instructor images
        $sql = "SELECT instructor_image FROM course_instructors WHERE course_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($instructor = mysqli_fetch_assoc($result)) {
            $instructor_image = "../" . $instructor['instructor_image'];
            if (file_exists($instructor_image)) {
                unlink($instructor_image);
            }
        }
        
        // Delete the course (this will cascade delete instructors due to foreign key)
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die('Error preparing statement: ' . mysqli_error($conn));
        }
        
        if (!mysqli_stmt_bind_param($stmt, "i", $course_id)) {
            die('Error binding parameters: ' . mysqli_stmt_error($stmt));
        }
        
        if (!mysqli_stmt_execute($stmt)) {
            die('Error executing statement: ' . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        header("Location: view-courses.php?success=Course deleted successfully");
        exit();
    }
    
    header("Location: view-courses.php?error=Failed to delete course");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_abbreviation = strtolower($_POST['course_abbreviation']);
    $course_category = $_POST['course_category'];
    $course_video = $_POST['course_video'];
    $short_description = $_POST['short_description'];
    $full_description = $_POST['full_description'];
    $course_major = $_POST['course_major'];
    $career_opportunities = $_POST['career_opportunities'];
    $skills_gained = $_POST['skills_gained'];
    $future_impact = $_POST['future_impact'];

    // New fields
    $duration = $_POST['duration'];
    $total_subjects = $_POST['total_subjects'];
    $level = $_POST['level'];
    $language = $_POST['language'];
    $certificate = $_POST['certificate'];

    // Handle instructor data
    $instructor_names = $_POST['instructor_names'];
    $instructor_designations = $_POST['instructor_designations'];
    $instructor_images = $_FILES['instructor_images'];
    
    // Handle main course image
    $target_dir = "../assets/images/courses/";
    $file_extension = strtolower(pathinfo($_FILES["course_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = "course_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["course_image"]["tmp_name"], $target_file)) {
        // Process instructor images
        $instructor_html = '';
        for ($i = 0; $i < count($instructor_names); $i++) {
            $instructor_img_ext = strtolower(pathinfo($instructor_images["name"][$i], PATHINFO_EXTENSION));
            $instructor_filename = "instructor_" . time() . "_" . $i . "." . $instructor_img_ext;
            $instructor_target = $target_dir . "instructors/" . $instructor_filename;
            
            if (!is_dir($target_dir . "instructors/")) {
                mkdir($target_dir . "instructors/", 0777, true);
            }
            
            if (move_uploaded_file($instructor_images["tmp_name"][$i], $instructor_target)) {
                $instructor_html .= '
                <div class="col-md-3 col-6">
                    <div class="single-team">
                        <div class="team-thumb">
                            <img src="assets/images/courses/instructors/' . $instructor_filename . '" alt="' . $instructor_names[$i] . '">
                        </div>
                        <div class="team-content">
                            <h4 class="name">' . $instructor_names[$i] . '</h4>
                            <span class="designation">' . $instructor_designations[$i] . '</span>
                        </div>
                    </div>
                </div>';
            }
        }

        // Create the course file with all details
        $course_file = "../courses-" . $course_abbreviation . ".php";
        $course_content = '<!DOCTYPE html>
<html lang="en">
<?php include(\'head.php\'); ?>
<body>
    <div class="main-wrapper">
        <?php include(\'pcheader.php\') ?>
        <?php include(\'mobileheader.php\') ?>
        <div class="overlay"></div>
        <div class="section section-padding" style="margin-top:50px;">
            <div class="container">
                <div class="row gx-10">
                    <div class="col-lg-8">
                        <div class="courses-details">
                            <div class="courses-details-images">
                                <img src="assets/images/courses/' . basename($target_file) . '" alt="Courses Details">
                                <span class="tags">' . $course_category . '</span>
                                <div class="courses-play">
                                    <a class="play video-popup" href="' . $course_video . '"><i class="flaticon-play"></i></a>
                                </div>
                            </div>
                            <h2 class="title">' . $course_name . '</h2>
                            <div class="courses-details-tab">
                                <div class="details-tab-menu">
                                    <ul class="nav justify-content-center">
                                        <li><a class="active" data-bs-toggle="tab" href="#description">Description</a></li>
                                        <li><a data-bs-toggle="tab" href="#details">Details</a></li>
                                        <li><a data-bs-toggle="tab" href="#benefits">Benefits</a></li>
                                        <li><a data-bs-toggle="tab" href="#instructors">Instructors</a></li>
                                    </ul>
                                </div>
                                <div class="details-tab-content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="description">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <h3 class="tab-title">Description:</h3>
                                                    <p>' . $full_description . '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="details">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <h3 class="tab-title">Course Details</h3>
                                                    <div class="course-details-info">
                                                        <div class="single-info">
                                                            <span class="label">Duration:</span>
                                                            <span class="value">' . $duration . ' Years</span>
                                                        </div>
                                                        <div class="single-info">
                                                            <span class="label">Total Subjects:</span>
                                                            <span class="value">' . $total_subjects . '</span>
                                                        </div>
                                                        <div class="single-info">
                                                            <span class="label">Level:</span>
                                                            <span class="value">' . $level . '</span>
                                                        </div>
                                                        <div class="single-info">
                                                            <span class="label">Language:</span>
                                                            <span class="value">' . $language . '</span>
                                                        </div>
                                                        <div class="single-info">
                                                            <span class="label">Certificate:</span>
                                                            <span class="value">' . $certificate . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="benefits">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <h3 class="tab-title">How These Courses Can Benefit You</h3>
                                                    <br><br>
                                                    <strong>•   Career Opportunities:</strong> ' . $career_opportunities . '
                                                    <br><br>
                                                    <strong>•   Skills Gained:</strong> ' . $skills_gained . '
                                                    <br><br>
                                                    <strong>•   Future Impact:</strong> ' . $future_impact . '
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="instructors">
                                            <div class="tab-instructors">
                                                <h3 class="tab-title">Course Instructors:</h3>
                                                <div class="row">
                                                    ' . $instructor_html . '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget widget-information">
                                <div class="info-list">
                                    <ul>
                                        <li><i class="flaticon-teacher"></i> <strong>Major:</strong> <span>' . $course_major . '</span></li>
                                        <li><i class="flaticon-time"></i> <strong>Duration:</strong> <span>' . $duration . ' Years</span></li>
                                        <li><i class="flaticon-file"></i> <strong>Certificate:</strong> <span>' . $certificate . '</span></li>
                                        <li><i class="flaticon-globe"></i> <strong>Language:</strong> <span>' . $language . '</span></li>
                                    </ul>
                                </div>
                                <div class="info-btn">
                                    <a href="#" class="btn btn-primary btn-hover-dark">Visit Portal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include(\'footer.php\') ?>
    </div>

    <!-- JS
    ============================================ -->
    <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="assets/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="assets/js/plugins/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins/video-playlist.js"></script>
    <script src="assets/js/plugins/jquery.nice-select.min.js"></script>
    <script src="assets/js/plugins/ajax-contact.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>';

        file_put_contents($course_file, $course_content);

        // Insert course data into database
        $sql = "INSERT INTO courses (course_name, course_abbreviation, course_category, course_image, short_description, course_major) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }
        
        $image_path = "assets/images/courses/" . basename($target_file);
        if (!$stmt->bind_param("ssssss", $course_name, $course_abbreviation, $course_category, $image_path, $short_description, $course_major)) {
            die('Error binding parameters: ' . $stmt->error);
        }
        
        if (!$stmt->execute()) {
            die('Error executing statement: ' . $stmt->error);
        }
        
        $stmt->close();
        // Add to courses.php
        $courses_file = "../courses.php";
        $courses_content = file_get_contents($courses_file);
        $new_course_html = '
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single-courses">
                                            <div class="courses-images">
                                                <a href="courses-' . $course_abbreviation . '"><img src="assets/images/courses/' . basename($target_file) . '" alt="Courses"></a>
                                            </div>
                                            <div class="courses-content">
                                                <h4 class="title"><a href="courses-' . $course_abbreviation . '">' . $course_name . '</a></h4>
                                                <div class="courses-meta">
                                                    <div class="ellipsis5" style="font-size: 13px;">' . $short_description . '</div>
                                                </div>
                                                <div class="courses-meta">
                                                    <span>Major: ' . $course_major . '</span>
                                                </div>
                                                <div class="courses-price-review">
                                                    <div class="courses-price" style="text-align: center; width: 100%;">
                                                        <a href="courses-' . $course_abbreviation . '" class="sale-parice">View More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';

        // Find the position to insert the new course - inside the row div in the first tab
        $row_start = strpos($courses_content, '<div class="row" style="justify-content: center;">');
        if ($row_start !== false) {
            $insert_position = $row_start + strlen('<div class="row" style="justify-content: center;">');
            $courses_content = substr_replace($courses_content, $new_course_html, $insert_position, 0);
            file_put_contents($courses_file, $courses_content);
        }

        header("Location: courses.php?success=1");
        exit();
    } else {
        header("Location: add-course.php?error=upload_failed");
        exit();
    }
} else {
    header("Location: courses.php");
    exit();
}
?>
