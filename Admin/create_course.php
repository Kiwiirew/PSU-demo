<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_abbreviation = strtolower($_POST['course_abbreviation']);
    $course_description = $_POST['course_description'];
    $course_major = $_POST['course_major'];
    $course_category = $_POST['course_category'];

    // Handle file upload
    $target_dir = "../assets/images/courses/";
    $file_extension = strtolower(pathinfo($_FILES["course_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = "course_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["course_image"]["tmp_name"], $target_file)) {
        // Create the course file
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
                                <img src="' . $target_file . '" alt="Courses Details">
                                <span class="tags">' . $course_category . '</span>
                                <div class="courses-play">
                                    <a class="play video-popup" href="#"><i class="flaticon-play"></i></a>
                                </div>
                            </div>
                            <h2 class="title">' . $course_name . '</h2>
                            <div class="courses-details-tab">
                                <div class="details-tab-menu">
                                    <ul class="nav justify-content-center">
                                        <li><button class="active" data-bs-toggle="tab" data-bs-target="#description">Description</button></li>
                                    </ul>
                                </div>
                                <div class="details-tab-content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="description">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <p>' . $course_description . '</p>
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
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include(\'footer.php\') ?>
    </div>
    <?php include(\'script.php\') ?>
</body>
</html>';

        file_put_contents($course_file, $course_content);

        // Add the course to the courses section in courses.php
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
                                            <div class="ellipsis5" style="font-size: 13px;">' . $course_description . '</div>
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

        // Find the position to insert the new course - after the first tab content div
        $insert_position = strpos($courses_content, '<div class="tab-content">') + strlen('<div class="tab-content">');
        $courses_content = substr_replace($courses_content, $new_course_html, $insert_position, 0);
        file_put_contents($courses_file, $courses_content);

        header("Location: courses.php?success=1");
        exit();
    } else {
        header("Location: courses.php?error=upload_failed");
        exit();
    }
} else {
    header("Location: courses.php");
    exit();
}
?>
