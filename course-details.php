<?php
require_once 'Admin/db_conn.php';

if (!isset($_GET['id'])) {
    header("Location: courses.php");
    exit();
}

$course_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM courses WHERE id = ?";
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

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: courses.php");
    exit();
}

$course = mysqli_fetch_assoc($result);

// Get course instructors
$sql = "SELECT * FROM course_instructors WHERE course_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $course_id);
mysqli_stmt_execute($stmt);
$instructors_result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>
    <div class="main-wrapper">
        <?php include('pcheader.php') ?>
        <?php include('mobileheader.php') ?>
        <div class="overlay"></div>

        <!-- Course Details Start -->
        <div class="section section-padding" style="margin-top:50px;">
            <div class="container">
                <div class="row gx-10">
                    <div class="col-lg-8">
                        <div class="courses-details">
                            <div class="courses-details-images">
                                <img src="<?php echo htmlspecialchars($course['course_image']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>">
                                <span class="tags"><?php echo htmlspecialchars($course['course_tag']); ?></span>

                                <?php if (!empty($course['course_video'])): ?>
                                <div class="courses-play">
                                    <a class="play video-popup" href="<?php echo htmlspecialchars($course['course_video']); ?>">
                                        <i class="flaticon-play"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>

                            <h2 class="title"><?php echo htmlspecialchars($course['course_name']); ?></h2>

                            <div class="courses-details-tab">
                                <div class="details-tab-menu">
                                    <ul class="nav justify-content-center">
                                        <li><button class="active" data-bs-toggle="tab" data-bs-target="#description">Description</button></li>
                                        <li><button data-bs-toggle="tab" data-bs-target="#benefits">Benefits</button></li>
                                        <li><button data-bs-toggle="tab" data-bs-target="#instructors">Instructors</button></li>
                                    </ul>
                                </div>

                                <div class="details-tab-content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="description">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <h3 class="tab-title">Description:</h3>
                                                    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="benefits">
                                            <div class="tab-description">
                                                <div class="description-wrapper">
                                                    <h3 class="tab-title">How This Course Can Benefit You</h3>
                                                    <br><br>
                                                    <strong>•   Career Opportunities:</strong>
                                                    <p><?php echo nl2br(htmlspecialchars($course['career_opportunities'])); ?></p>
                                                    <br><br>
                                                    <strong>•   Skills Gained:</strong>
                                                    <p><?php echo nl2br(htmlspecialchars($course['skills_gained'])); ?></p>
                                                    <br><br>
                                                    <strong>•   Future Impact:</strong>
                                                    <p><?php echo nl2br(htmlspecialchars($course['future_impact'])); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="instructors">
                                            <div class="tab-instructors">
                                                <h3 class="tab-title">Course Instructor:</h3>
                                                <div class="row">
                                                    <?php while ($instructor = mysqli_fetch_assoc($instructors_result)): ?>
                                                    <div class="col-md-3 col-6">
                                                        <div class="single-team">
                                                            <div class="team-thumb">
                                                                <img src="<?php echo htmlspecialchars($instructor['instructor_image']); ?>" alt="Instructor">
                                                            </div>
                                                            <div class="team-content">
                                                                <h4 class="name"><?php echo htmlspecialchars($instructor['instructor_name']); ?></h4>
                                                                <span class="designation"><?php echo htmlspecialchars($instructor['designation']); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endwhile; ?>
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
                                    <h3 class="title">Details</h3>
                                    <ul>
                                        <li><i class="icofont-clock-time"></i> <span>Duration:</span> <?php echo htmlspecialchars($course['duration']); ?></li>
                                        <li><i class="icofont-book-alt"></i> <span>Total Subjects:</span> <?php echo htmlspecialchars($course['total_subjects']); ?></li>
                                        <li><i class="icofont-graduate"></i> <span>Level:</span> <?php echo htmlspecialchars($course['level']); ?></li>
                                        <li><i class="icofont-globe"></i> <span>Language:</span> <?php echo htmlspecialchars($course['language']); ?></li>
                                        <li><i class="icofont-certificate"></i> <span>Certificate:</span> <?php echo htmlspecialchars($course['certificate']); ?></li>
                                    </ul>
                                    <a href="<?php echo htmlspecialchars($course['portal_link']); ?>" class="btn btn-primary btn-hover-dark" target="_blank">Visit Portal</a>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h3 class="title">Share Course:</h3>
                                <ul class="social-share">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>" target="_blank"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($current_url); ?>" target="_blank"><i class="icofont-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($current_url); ?>" target="_blank"><i class="icofont-linkedin"></i></a></li>
                                    <li><a href="https://api.whatsapp.com/send?text=<?php echo urlencode($current_url); ?>" target="_blank"><i class="icofont-whatsapp"></i></a></li>
                                    <li><a href="https://www.instagram.com/" target="_blank"><i class="icofont-instagram"></i></a></li>
                                </ul>
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
