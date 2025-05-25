<?php
include 'db_conn.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: courses.php');
    exit();
}

$course_id = $_GET['id'];

// Initialize arrays for instructor data
$instructor_names = isset($_POST['instructor_names']) ? $_POST['instructor_names'] : array();
$instructor_positions = isset($_POST['instructor_positions']) ? $_POST['instructor_positions'] : array();

// Fetch course details
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: courses.php');
    exit();
}

$course = $result->fetch_assoc();

// Fetch instructors for this course
$sql = "SELECT id, course_id, instructor_name as name, designation as position, instructor_image as image FROM course_instructors WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$instructors_result = $stmt->get_result();
$instructors = [];
while ($row = $instructors_result->fetch_assoc()) {
    $instructors[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $course_tag = $_POST['course_tag'];
    $course_video = $_POST['course_video'];
    $description = $_POST['description'];
    $career_opportunities = $_POST['career_opportunities'];
    $skills_gained = $_POST['skills_gained'];
    $future_impact = $_POST['future_impact'];
    $duration = $_POST['duration'];
    $total_subjects = $_POST['total_subjects'];
    $level = $_POST['level'];
    
    $success = true;
    $error_message = '';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Handle image upload if a new image is provided
        if (!empty($_FILES['course_image']['name'])) {
            $target_dir = "../uploads/courses/";
            
            // Create directory if it doesn't exist
            if (!file_exists($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    throw new Exception("Failed to create upload directory.");
                }
            }

            $file_extension = strtolower(pathinfo($_FILES["course_image"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            // Check file type
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($file_extension, $allowed_types)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            // Upload file
            if (!move_uploaded_file($_FILES["course_image"]["tmp_name"], $target_file)) {
                throw new Exception("Sorry, there was an error uploading your file. Please check directory permissions.");
            }

            // Delete old image if exists
            if (!empty($course['course_image'])) {
                $old_image = $target_dir . $course['course_image'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            
            // Update database with new image
            $sql = "UPDATE courses SET 
                    course_name = ?, 
                    course_tag = ?, 
                    course_video = ?,
                    description = ?, 
                    career_opportunities = ?,
                    skills_gained = ?,
                    future_impact = ?,
                    duration = ?,
                    total_subjects = ?,
                    level = ?,
                    course_image = ? 
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("sssssssssssi", 
                $course_name, 
                $course_tag,
                $course_video, 
                $description,
                $career_opportunities,
                $skills_gained,
                $future_impact,
                $duration,
                $total_subjects,
                $level,
                $new_filename,
                $course_id
            );
        } else {
            // Update without changing image
            $sql = "UPDATE courses SET 
                    course_name = ?, 
                    course_tag = ?, 
                    course_video = ?,
                    description = ?, 
                    career_opportunities = ?,
                    skills_gained = ?,
                    future_impact = ?,
                    duration = ?,
                    total_subjects = ?,
                    level = ?
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("ssssssssssi", 
                $course_name, 
                $course_tag,
                $course_video, 
                $description,
                $career_opportunities,
                $skills_gained,
                $future_impact,
                $duration,
                $total_subjects,
                $level,
                $course_id
            );
        }

        if (!$stmt->execute()) {
            throw new Exception("Error updating course: " . $stmt->error);
        }

        // Handle instructors
        // First, delete existing instructors
        $sql = "DELETE FROM course_instructors WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error preparing delete statement: " . $conn->error);
        }
        $stmt->bind_param("i", $course_id);
        if (!$stmt->execute()) {
            throw new Exception("Error removing old instructors: " . $stmt->error);
        }

        // Add new instructors
        if (isset($_POST['instructor_names']) && is_array($_POST['instructor_names'])) {
            $sql = "INSERT INTO course_instructors (course_id, instructor_name, designation, instructor_image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error preparing insert statement: " . $conn->error);
            }

            foreach ($_POST['instructor_names'] as $key => $name) {
                // Skip empty entries
                if (empty($name) || empty($_POST['instructor_positions'][$key])) {
                    continue;
                }
                
                $position = $_POST['instructor_positions'][$key];
                $image = ''; // You can add image handling here if needed

                $stmt->bind_param("isss", $course_id, $name, $position, $image);
                if (!$stmt->execute()) {
                    throw new Exception("Error adding instructor: " . $stmt->error);
                }
            }
        }

        // Commit transaction
        $conn->commit();
        header('Location: courses.php?success=Course updated successfully');
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error_message = $e->getMessage();
        $success = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>PSU ASINGAN CAMPUS - Edit Course</title>
        <meta content="Admin Dashboard" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="../assets/img/logotitle.png" type="image/x-icon">
        <link rel="icon" href="../assets/img/logotitle.png" type="image/x-icon">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="assets/css/custom.css">
        
        <style>
            .form-section {
                background: #fff;
                padding: 30px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }
            .preview-section {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 5px;
                margin-top: 20px;
            }
            .tab-section {
                margin-top: 20px;
            }
            .nav-tabs {
                border-bottom: 2px solid #dee2e6;
            }
            .nav-tabs .nav-link {
                margin-bottom: -2px;
                border: none;
                color: #495057;
            }
            .nav-tabs .nav-link.active {
                color: #007bff;
                border-bottom: 2px solid #007bff;
            }
        </style>
    </head>

    <body class="fixed-left">
        <div id="wrapper">
            <?php include('leftnavbar.php') ?>
            
            <div class="content-page">
                <div class="content">
                    <?php include('topnavbar.php') ?>

                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Edit Course</h4>
                                            <p class="text-muted m-b-30">Update the course details below.</p>

                                            <?php if (isset($error_message)): ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $error_message; ?>
                                                </div>
                                            <?php endif; ?>

                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="courses-details">
                                                    <div class="form-section">
                                                        <h5>Basic Information</h5>
                                                        <div class="form-group">
                                                            <label>Course Image</label>
                                                            <?php if (!empty($course['course_image'])): ?>
                                                                <div class="mb-2">
                                                                    <img src="../uploads/courses/<?php echo htmlspecialchars($course['course_image']); ?>" alt="Current Image" style="max-width: 200px;">
                                                                </div>
                                                            <?php endif; ?>
                                                            <input type="file" class="form-control" name="course_image" accept="image/*">
                                                            <small class="form-text text-muted">Leave empty to keep the current image</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Tag</label>
                                                            <select class="form-control" name="course_tag" required>
                                                                <option value="Education" <?php echo $course['course_tag'] == 'Education' ? 'selected' : ''; ?>>Education</option>
                                                                <option value="Technology" <?php echo $course['course_tag'] == 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                                                <option value="Business" <?php echo $course['course_tag'] == 'Business' ? 'selected' : ''; ?>>Business</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Video URL (YouTube)</label>
                                                            <input type="url" class="form-control" name="course_video" value="<?php echo htmlspecialchars($course['course_video'] ?? ''); ?>" placeholder="e.g., https://www.youtube.com/watch?v=...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Title</label>
                                                            <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="courses-details-tab">
                                                        <div class="form-section">
                                                            <h5>Course Details</h5>
                                                            
                                                            <!-- Description Tab -->
                                                            <div class="form-group">
                                                                <label>Course Description</label>
                                                                <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                                                            </div>

                                                            <!-- Benefits Tab -->
                                                            <div class="form-group">
                                                                <label>Career Opportunities</label>
                                                                <textarea class="form-control" name="career_opportunities" rows="3" required 
                                                                    placeholder="List the career opportunities for graduates"><?php echo htmlspecialchars($course['career_opportunities'] ?? ''); ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Skills Gained</label>
                                                                <textarea class="form-control" name="skills_gained" rows="3" required
                                                                    placeholder="List the skills students will gain"><?php echo htmlspecialchars($course['skills_gained'] ?? ''); ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Future Impact</label>
                                                                <textarea class="form-control" name="future_impact" rows="3" required
                                                                    placeholder="Describe the long-term impact of this course"><?php echo htmlspecialchars($course['future_impact'] ?? ''); ?></textarea>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Duration</label>
                                                                        <input type="text" class="form-control" name="duration" value="<?php echo htmlspecialchars($course['duration'] ?? '4 Years'); ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Total Subjects</label>
                                                                        <input type="number" class="form-control" name="total_subjects" value="<?php echo htmlspecialchars($course['total_subjects'] ?? '60'); ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Level</label>
                                                                        <select class="form-control" name="level" required>
                                                                            <option value="Secondary" <?php echo ($course['level'] ?? '') == 'Secondary' ? 'selected' : ''; ?>>Secondary</option>
                                                                            <option value="Tertiary" <?php echo ($course['level'] ?? '') == 'Tertiary' ? 'selected' : ''; ?>>Tertiary</option>
                                                                            <option value="Graduate" <?php echo ($course['level'] ?? '') == 'Graduate' ? 'selected' : ''; ?>>Graduate</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Instructors Section -->
                                                    <div class="form-section">
                                                        <h5>Course Instructors</h5>
                                                        <div id="instructors-container">
                                                            <?php 
                                                            // Always show at least one instructor field
                                                            $show_instructors = !empty($instructors) ? $instructors : [['name' => '', 'position' => '']];
                                                            
                                                            foreach ($show_instructors as $index => $instructor): 
                                                                $name = isset($instructor['name']) ? htmlspecialchars($instructor['name']) : '';
                                                                $position = isset($instructor['position']) ? htmlspecialchars($instructor['position']) : '';
                                                            ?>
                                                                <div class="instructor-entry">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <label>Instructor Name</label>
                                                                                <input type="text" class="form-control" name="instructor_names[]" value="<?php echo $name; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <label>Position</label>
                                                                                <input type="text" class="form-control" name="instructor_positions[]" value="<?php echo $position; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <button type="button" class="btn btn-danger remove-instructor" style="margin-top: 32px;">Remove</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <button type="button" class="btn btn-success" onclick="addInstructor()">Add Instructor</button>
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update Course</button>
                                                        <a href="courses.php" class="btn btn-secondary">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>

                                            <script>
                                                function addInstructor() {
                                                    const container = document.getElementById('instructors-container');
                                                    const newInstructor = document.createElement('div');
                                                    newInstructor.className = 'instructor-entry';
                                                    newInstructor.innerHTML = `
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Instructor Name</label>
                                                                    <input type="text" class="form-control" name="instructor_names[]" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Position</label>
                                                                    <input type="text" class="form-control" name="instructor_positions[]" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger remove-instructor" style="margin-top: 32px;">Remove</button>
                                                            </div>
                                                        </div>
                                                    `;
                                                    container.appendChild(newInstructor);
                                                    
                                                    // Add event listener to the new remove button
                                                    const removeButton = newInstructor.querySelector('.remove-instructor');
                                                    removeButton.addEventListener('click', function() {
                                                        this.closest('.instructor-entry').remove();
                                                    });
                                                }

                                                // Add event listeners to existing remove buttons
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    document.querySelectorAll('.remove-instructor').forEach(button => {
                                                        button.addEventListener('click', function() {
                                                            this.closest('.instructor-entry').remove();
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    2024 PSU ASINGAN CAMPUS
                </footer>
            </div>
        </div>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>
