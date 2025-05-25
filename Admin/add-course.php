<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>PSU ASINGAN CAMPUS - Add New Course</title>
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
                                            <h4 class="mt-0 header-title">Add New Course</h4>
                                            <p class="text-muted m-b-30">Fill in the details below to create a new course page.</p>

                                            <form action="process-course.php" method="POST" enctype="multipart/form-data">
                                                <div class="courses-details">
                                                    <div class="form-section">
                                                        <h5>Basic Information</h5>
                                                        <div class="form-group">
                                                            <label>Course Image</label>
                                                            <input type="file" class="form-control" name="course_image" accept="image/*" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Tag</label>
                                                            <select class="form-control" name="course_tag" required>
                                                                <option value="Education">Education</option>
                                                                <option value="Technology">Technology</option>
                                                                <option value="Business">Business</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Video URL (YouTube)</label>
                                                            <input type="url" class="form-control" name="course_video" placeholder="e.g., https://www.youtube.com/watch?v=...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course Title</label>
                                                            <input type="text" class="form-control" name="course_name" required>
                                                        </div>
                                                    </div>

                                                    <div class="courses-details-tab">
                                                        <div class="form-section">
                                                            <h5>Course Details</h5>
                                                            
                                                            <!-- Description Tab -->
                                                            <div class="form-group">
                                                                <label>Course Description</label>
                                                                <textarea class="form-control" name="description" rows="4" required></textarea>
                                                            </div>

                                                            <!-- Benefits Tab -->
                                                            <div class="form-group">
                                                                <label>Career Opportunities</label>
                                                                <textarea class="form-control" name="career_opportunities" rows="3" required 
                                                                    placeholder="List the career opportunities for graduates"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Skills Gained</label>
                                                                <textarea class="form-control" name="skills_gained" rows="3" required
                                                                    placeholder="List the skills students will gain"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Future Impact</label>
                                                                <textarea class="form-control" name="future_impact" rows="3" required
                                                                    placeholder="Describe the long-term impact of this course"></textarea>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Duration</label>
                                                                        <input type="text" class="form-control" name="duration" value="4 Years" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Total Subjects</label>
                                                                        <input type="number" class="form-control" name="total_subjects" value="60" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Level</label>
                                                                        <select class="form-control" name="level" required>
                                                                            <option value="Secondary">Secondary</option>
                                                                            <option value="Tertiary">Tertiary</option>
                                                                            <option value="Graduate">Graduate</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Language</label>
                                                                        <select class="form-control" name="language" required>
                                                                            <option value="English">English</option>
                                                                            <option value="Filipino">Filipino</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Certificate</label>
                                                                <select class="form-control" name="certificate" required>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Portal Link (Optional)</label>
                                                                <input type="url" class="form-control" name="portal_link" value="https://psu362.campus-erp.com/portal/">
                                                            </div>

                                                            <!-- Instructors Tab -->
                                                            <div class="instructors-section">
                                                                <h5>Course Instructors</h5>
                                                                <div id="instructors-container">
                                                                    <div class="instructor-entry">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Instructor Name</label>
                                                                                    <input type="text" class="form-control" name="instructor_names[]" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Designation</label>
                                                                                    <input type="text" class="form-control" name="instructor_designations[]" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Instructor Image</label>
                                                                                    <input type="file" class="form-control" name="instructor_images[]" accept="image/*" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-secondary mt-2" onclick="addInstructor()">Add Another Instructor</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-4">
                                                        <button type="submit" name="add_course" class="btn btn-primary">Create Course</button>
                                                        <a href="courses.php" class="btn btn-secondary">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>

                                            <script>
                                                function addInstructor() {
                                                    const container = document.getElementById('instructors-container');
                                                    const instructorEntry = document.querySelector('.instructor-entry').cloneNode(true);
                                                    
                                                    // Clear the values
                                                    instructorEntry.querySelectorAll('input').forEach(input => {
                                                        input.value = '';
                                                    });
                                                    
                                                    container.appendChild(instructorEntry);
                                                }
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
