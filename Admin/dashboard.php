<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>PSU ASINGAN CAMPUS - Admin Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="../assets/images/logotitle.png" type="image/x-icon">
        <link rel="icon" href="../assets/images/logotitle.png" type="image/x-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

        <!-- Modern Admin Styles -->
        <link rel="stylesheet" href="assets/css/admin-modern.css">
        <link rel="stylesheet" href="assets/css/custom.css">
    </head>

    <body class="fixed-left">

        <!-- Loader -->
<div class="preloader" id="preloader">
            <div class="lds-ellipsis">
                <span></span>
                <span style="background:#0A27D8"></span>
                <span style="background: #FFE047;"></span>
            </div>
        </div>
        
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Left Sidebar -->
            <?php include('leftnavbar.php') ?>

            <!-- Start right Content here -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar -->
                    <?php include('topnavbar.php') ?>

                    <div class="page-content-wrapper">
                        <div class="container-fluid">

                            <!-- Page Title -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">PSU</a></li>
                                                <li class="breadcrumb-item active">Dashboard</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Welcome to PSU Asingan Admin Dashboard! 🎓</h4>
                                        <p class="text-muted mb-0">Manage your educational platform with modern tools and insights</p>
                                    </div>
                                </div>
                            </div>
                          
                            <!-- Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-users-cog"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            include 'db_conn.php';
                                            $admin_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM admin_accounts"))['count'];
                                            echo $admin_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Total Admins</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $teacher_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM teachers"))['count'];
                                            echo $teacher_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Total Teachers</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $student_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
                                            echo $student_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Total Students</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $course_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM courses"))['count'];
                                            echo $course_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Total Courses</div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="row">
                                <!-- Administrators Card -->
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Administrators</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive boxscroll" style="max-height: 400px; overflow-y: auto;">
                                                <table class="table mb-0">                                                                
                                                    <tbody>
                                                        <?php
                                                            include 'db_conn.php';

                                                            $sql = "SELECT id, username, password, acctype FROM admin_accounts";
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = htmlspecialchars($row["id"]);
                                                                    $username = htmlspecialchars($row["username"]);
                                                                    $acctype = htmlspecialchars($row["acctype"]);
                                                                    $password = htmlspecialchars($row["password"]);
                                                                    
                                                                    echo '<tr>';
                                                                    echo '<td class="border-top-0">';
                                                                    echo '<div class="media">';
                                                                    echo '<img src="assets/images/admin.svg" alt="" class="thumb-md rounded-circle">';
                                                                    echo '<div class="media-body ml-2">';
                                                                    echo '<p class="mb-0">' . $username . '<span class="badge badge-soft-primary" style="margin-left:5px">' . $acctype . '</span></p>';
                                                                    echo '<span class="font-12 text-muted">' . $password . '</span>';
                                                                    echo '</div>';
                                                                    echo '</div>';
                                                                    echo '</td>';
                                                                    echo '<td class="border-top-0 text-right">';
                                                                    echo '<a href="#" class="btn btn-light btn-sm delete-btn" data-id="' . $id . '" data-url="delete_admin.php"><i class="far fa-trash-alt mr-2 text-danger"></i>Delete</a>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="2">No records found</td></tr>';
                                                            }

                                                            $conn->close();
                                                            ?>                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Management Actions Card -->
                                <div class="col-xl-4 col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Actions</h5>
                                        </div>   
                                        <div class="card-body">
                                            <div class="management-section mb-4">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-2"><i class="fas fa-user-shield me-2"></i>Admin Management</h6>
                                                        <p class="text-muted mb-0 small">Create and manage admin accounts with customizable roles and permissions</p>
                                        </div>                        
                                                    <a href="#" class="btn btn-primary btn-sm ms-3" id="btncreate">New Admin</a>
                                        </div>  
                                    </div>
                                   
                                            <div class="management-section mb-4">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-2"><i class="fas fa-chalkboard-teacher me-2"></i>Teacher Management</h6>
                                                        <p class="text-muted mb-0 small">Onboard and manage teaching staff accounts with course access</p>
                                </div>
                                                    <a href="teachers" class="btn btn-warning btn-sm ms-3">New Teacher</a>
                                            </div>
                                                    </div>

                                            <div class="management-section">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-2"><i class="fas fa-user-graduate me-2"></i>Student Management</h6>
                                                        <p class="text-muted mb-0 small">Manage student accounts and course registrations</p>
                                                    </div>
                                                    <a href="students" class="btn btn-success btn-sm ms-3">New Student</a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Teachers Overview Card -->
                               <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Recent Teachers</h5>
                                                <a href="teachers" class="btn btn-sm btn-outline-primary">View All</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive boxscroll" style="max-height: 350px; overflow-y: auto;">
                                                <table class="table mb-0">                                                                
                                                    <tbody>
                                                        <?php
                                                            include 'db_conn.php';
                                                        $sql = "SELECT TeacherID, FullName, Department, Gender FROM teachers LIMIT 5";
                                                            $result = $conn->query($sql);

                                                            if ($result === false) {
                                                            echo '<tr><td colspan="2" class="text-center text-muted">Error loading teachers</td></tr>';
                                                            } else if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $imageSrc = ($row['Gender'] == 'Male') ? 'assets/images/manteacher.png' : 'assets/images/womanteacher.svg';
                                                                    
                                                                    echo '<tr>';
                                                                echo '<td class="border-top-0">';
                                                                echo '<div class="media">';
                                                                echo '<img src="' . $imageSrc . '" alt="" class="thumb-md rounded-circle">';
                                                                echo '<div class="media-body">';
                                                                echo '<p class="mb-0">' . htmlspecialchars($row['FullName']) . '</p>';
                                                                echo '<span class="font-12 text-muted">' . htmlspecialchars($row['Department']) . '</span>';
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                echo '<td class="border-top-0 text-right">';
                                                                echo '<div class="action-buttons">';
                                                                echo '<a href="#" class="btn btn-danger btn-sm delete-btn" data-id="' . htmlspecialchars($row['TeacherID']) . '" data-url="delete_teacher.php"><i class="fas fa-trash-alt"></i></a>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                            echo '<tr><td colspan="2" class="text-center text-muted">No teachers found</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <!-- Students Overview -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Recent Students</h5>
                                                <a href="students" class="btn btn-sm btn-outline-primary">View All Students</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-user me-2"></i>Full Name</th>
                                                            <th><i class="fas fa-envelope me-2"></i>Email</th>
                                                            <th><i class="fas fa-phone me-2"></i>Phone Number</th>
                                                            <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>                                                                                  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                          <?php
                                                        $sql = "SELECT StudentID, FullName, EmailAddress, PhoneNumber FROM students LIMIT 8";
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                $studentID = htmlspecialchars($row['StudentID']);
                                                                $fullName = htmlspecialchars($row['FullName']);
                                                                $email = htmlspecialchars($row['EmailAddress']);
                                                                $phone = htmlspecialchars($row['PhoneNumber']);

                                                                echo '<tr>';
                                                                echo '<td>';
                                                                echo '<div class="media">';
                                                                echo '<img src="assets/images/student.png" alt="" class="rounded-circle thumb-sm me-3">';
                                                                echo '<div class="media-body">';
                                                                echo '<p class="mb-0 font-weight-bold">' . $fullName . '</p>';
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                echo '<td><i class="fas fa-envelope text-muted me-2"></i>' . $email . '</td>';
                                                                echo '<td><i class="fas fa-phone text-muted me-2"></i>' . $phone . '</td>';
                                                                echo '<td class="text-center">';
                                                                echo '<div class="action-buttons justify-content-center">';
                                                                echo '<a href="#" class="btn btn-sm btn-primary me-2"><i class="fas fa-eye"></i></a>';
                                                                echo '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' . $studentID . '" data-url="delete_student.php"><i class="fas fa-trash-alt"></i></a>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                echo '</tr>';
                                                            }
                                                            } else {
                                                            echo '<tr><td colspan="4" class="text-center text-muted py-4">No students found</td></tr>';
                                                            }
                                                            $conn->close();
                                                            ?>        
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>                                                                   
                                </div> 
                            </div>

                            <!-- Modal for New Admin -->
                            <div class="modal fade" id="newAdminModal" tabindex="-1" role="dialog" aria-labelledby="newAdminModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newAdminModalLabel"><i class="fas fa-user-plus me-2"></i>Add New Admin</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="newAdminForm">
                                                <div class="form-group">
                                                    <label for="username"><i class="fas fa-user me-2"></i>Username</label>
                                                    <input type="text" class="form-control" id="username" required placeholder="Enter username">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                                    <input type="password" class="form-control" id="password" required placeholder="Enter password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="acctype"><i class="fas fa-user-tag me-2"></i>Role</label>
                                                    <select class="form-control" id="acctype" required>
                                                        <option value="">Select Role</option>
                                                        <option value="admin">Faculty Admin</option>
                                                        <option value="superadmin">Super Admin</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Create Admin Account</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- container-fluid -->
                    </div> <!-- page-content-wrapper -->
                </div> <!-- content -->

                <!-- Modern Footer -->
                <footer class="footer">
                    <div style="background: var(--psu-blue); color: white; padding: 15px 20px; border-radius: 10px; margin: 20px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>© 2024 PSU ASINGAN CAMPUS</strong>
                                <span class="ms-3 opacity-75">Admin Dashboard</span>
                            </div>
                            <div class="text-end">
                                <small>Version 2.0 | Professional Interface</small>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

        <!-- jQuery and Bootstrap -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- Chart.js -->
        <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- Modern Admin Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Enhanced Preloader with Progress
                const preloader = document.getElementById('preloader');
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 30;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(progressInterval);
                        setTimeout(() => {
                            preloader.style.opacity = '0';
                            setTimeout(() => {
                                preloader.style.display = 'none';
                            }, 300);
                        }, 500);
                    }
                }, 200);

                // Quick Actions Floating Menu
                createQuickActionsMenu();

                // System Health Monitor
                initSystemHealthMonitor();

                // Enhanced Stats Cards Animation with Real-time Updates
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                            entry.target.classList.add('fadeInUp');
                        }
                    });
                }, observerOptions);

                // Apply animation to cards with staggered delay
                document.querySelectorAll('.stats-card, .card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    card.style.animationDelay = `${index * 0.1}s`;
                    observer.observe(card);
                });

                // Enhanced Modal functionality with keyboard navigation
                document.getElementById('btncreate').addEventListener('click', function(event) {
                    event.preventDefault();
                    openModal('newAdminModal');
                });

                // Smart Form Validation
                const adminForm = document.getElementById('newAdminForm');
                setupSmartValidation(adminForm);

                // Enhanced Admin Form submission with progress tracking
                adminForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    handleFormSubmission(this);
                });

                // Enhanced Delete functionality with modern UI
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', handleDeleteAction);
                });

                // Live Search and Filter
                setupLiveSearch();

                // Advanced Table Interactions
                enhanceTableInteractions();

                // Auto-refresh data every 30 seconds
                setInterval(refreshDashboardData, 30000);

                // Add pulse animation to important stats
                document.querySelectorAll('.stats-number').forEach((number, index) => {
                    animateNumber(number, index);
                });

                // Theme customization
                initThemeCustomization();

                // Notification System
                initNotificationSystem();

                // Activity Logger
                logActivity('Dashboard loaded');
            });

            // Quick Actions Floating Menu
            function createQuickActionsMenu() {
                const quickActions = document.createElement('div');
                quickActions.className = 'quick-actions';
                quickActions.innerHTML = `
                    <div class="quick-action-tooltip" style="display: none;">Quick Actions</div>
                    <button class="quick-action-btn" onclick="$('#newAdminModal').modal('show')" title="Add New Admin">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <button class="quick-action-btn" onclick="window.location.href='courses'" title="Manage Courses">
                        <i class="fas fa-book"></i>
                    </button>
                    <button class="quick-action-btn" onclick="refreshDashboardData()" title="Refresh Data">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="quick-action-btn" onclick="exportData()" title="Export Data">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="quick-action-btn main-fab" onclick="toggleQuickActions()" title="Toggle Menu">
                        <i class="fas fa-plus"></i>
                    </button>
                `;
                document.body.appendChild(quickActions);
            }

            // System Health Monitor
            function initSystemHealthMonitor() {
                const healthWidget = document.createElement('div');
                healthWidget.className = 'widget system-health';
                healthWidget.innerHTML = `
                    <div class="widget-header">
                        <h6 class="widget-title">System Health</h6>
                        <span class="badge badge-soft-success">Online</span>
                    </div>
                    <div class="widget-body">
                        <div class="health-item">
                            <span>Database</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 95%"></div>
                            </div>
                            <small>95% Healthy</small>
                        </div>
                        <div class="health-item">
                            <span>Server Load</span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 65%"></div>
                            </div>
                            <small>65% Usage</small>
                        </div>
                    </div>
                `;
                
                // Add to the first management card
                const firstCard = document.querySelector('.col-xl-4 .card');
                if (firstCard) {
                    firstCard.parentNode.insertBefore(healthWidget, firstCard.nextSibling);
                }
            }

            // Enhanced Modal Function
            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                $(modal).modal('show');
                
                // Auto-focus first input
                setTimeout(() => {
                    const firstInput = modal.querySelector('input, select, textarea');
                    if (firstInput) firstInput.focus();
                }, 300);
            }

            // Smart Form Validation
            function setupSmartValidation(form) {
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        validateField(this);
                    });
                    
                    input.addEventListener('blur', function() {
                        validateField(this);
                    });
                });
            }

            function validateField(field) {
                const value = field.value.trim();
                const fieldGroup = field.closest('.form-group');
                let isValid = true;
                let message = '';

                // Remove previous validation
                fieldGroup.classList.remove('has-error', 'has-success');
                const errorMsg = fieldGroup.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();

                // Validation rules
                if (field.hasAttribute('required') && !value) {
                    isValid = false;
                    message = 'This field is required';
                } else if (field.type === 'password' && value.length < 6) {
                    isValid = false;
                    message = 'Password must be at least 6 characters';
                } else if (field.id === 'username' && value.length < 3) {
                    isValid = false;
                    message = 'Username must be at least 3 characters';
                }

                // Apply validation styling
                if (!isValid && value) {
                    fieldGroup.classList.add('has-error');
                    const errorDiv = document.createElement('small');
                    errorDiv.className = 'error-message text-danger';
                    errorDiv.textContent = message;
                    fieldGroup.appendChild(errorDiv);
                } else if (value) {
                    fieldGroup.classList.add('has-success');
                }

                return isValid;
            }

            // Enhanced Form Submission
            function handleFormSubmission(form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                // Validate all fields
                let isFormValid = true;
                form.querySelectorAll('input, select').forEach(field => {
                    if (!validateField(field)) {
                        isFormValid = false;
                    }
                });

                if (!isFormValid) {
                    showNotification('Please fix validation errors', 'error');
                    return;
                }

                // Animate button
                submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Creating...';
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');

                    const formData = new FormData();
                    formData.append('username', document.getElementById('username').value);
                    formData.append('password', document.getElementById('password').value);
                    formData.append('acctype', document.getElementById('acctype').value);

                    fetch('adminbackend.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        try {
                            const result = JSON.parse(data);
                            if (result.success) {
                            submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Success!';
                            submitBtn.className = 'btn btn-success w-100';
                            
                            showNotification('Admin created successfully!', 'success');
                            logActivity(`New admin created: ${document.getElementById('username').value}`);
                            
                            setTimeout(() => {
                                $('#newAdminModal').modal('hide');
                                refreshDashboardData();
                            }, 1500);
                            } else {
                            throw new Error(result.message || 'Failed to create admin');
                            }
                        } catch (e) {
                        showNotification('Failed to create admin. Please try again.', 'error');
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('loading');
                        }
                    })
                    .catch(error => {
                    showNotification('Network error. Please try again.', 'error');
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                });
            }

            // Enhanced Delete Action
            function handleDeleteAction(event) {
                event.preventDefault();
                
                const id = this.getAttribute('data-id');
                const url = this.getAttribute('data-url');
                const row = this.closest('tr');
                const itemName = row.querySelector('.media-body p').textContent;
                
                showConfirmDialog(
                    'Delete Confirmation',
                    `Are you sure you want to delete "${itemName}"?`,
                    'This action cannot be undone.',
                    () => {
                        performDelete(id, url, row, itemName);
                    }
                );
            }

            function performDelete(id, url, row, itemName) {
                const btn = row.querySelector('.delete-btn');
                btn.innerHTML = '<div class="spinner-border spinner-border-sm"></div>';
                btn.disabled = true;
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        row.style.transition = 'all 0.5s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-100%)';
                        
                        setTimeout(() => {
                            row.remove();
                            showNotification(`${itemName} deleted successfully!`, 'success');
                            logActivity(`Deleted: ${itemName}`);
                            updateStatsAfterDelete();
                        }, 500);
                    } else {
                        throw new Error(data);
                    }
                })
                .catch(error => {
                    showNotification('Error deleting item: ' + error.message, 'error');
                    btn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    btn.disabled = false;
                });
            }

            // Enhanced Notification System
            function initNotificationSystem() {
                const container = document.createElement('div');
                container.id = 'notification-container';
                container.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    max-width: 400px;
                `;
                document.body.appendChild(container);
            }

            function showNotification(message, type = 'info', duration = 5000) {
                const notification = document.createElement('div');
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-triangle',
                    warning: 'fas fa-exclamation-circle',
                    info: 'fas fa-info-circle'
                };
                
                notification.className = `alert alert-${type} alert-dismissible fade notification`;
                notification.innerHTML = `
                    <i class="${icons[type]} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                `;
                
                document.getElementById('notification-container').appendChild(notification);
                
                setTimeout(() => notification.classList.add('show'), 100);
                
                if (duration > 0) {
                    setTimeout(() => {
                        notification.classList.remove('show');
                        setTimeout(() => notification.remove(), 300);
                    }, duration);
                }
            }

            // Modern Confirm Dialog
            function showConfirmDialog(title, message, subtitle, onConfirm) {
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>${title}</h5>
                            </div>
                            <div class="modal-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-question-circle fa-3x text-warning"></i>
                                </div>
                                <h6>${message}</h6>
                                <p class="text-muted">${subtitle}</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger confirm-btn">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                $(modal).modal('show');
                
                modal.querySelector('.confirm-btn').addEventListener('click', function() {
                    $(modal).modal('hide');
                    onConfirm();
                });
                
                $(modal).on('hidden.bs.modal', function() {
                    modal.remove();
                });
            }

            // Enhanced Number Animation
            function animateNumber(element, delay = 0) {
                const finalValue = parseInt(element.textContent);
                element.textContent = '0';
                
                setTimeout(() => {
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 50);
                    
                    const counter = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(counter);
                            element.classList.add('pulse');
                        }
                        element.textContent = currentValue.toLocaleString();
                    }, 30);
                }, delay * 200);
            }

            // Activity Logger
            function logActivity(action) {
                const timestamp = new Date().toLocaleString();
                console.log(`[${timestamp}] Admin Activity: ${action}`);
                
                // Store in localStorage for session tracking
                const activities = JSON.parse(localStorage.getItem('adminActivities') || '[]');
                activities.push({ action, timestamp });
                
                // Keep only last 50 activities
                if (activities.length > 50) {
                    activities.splice(0, activities.length - 50);
                }
                
                localStorage.setItem('adminActivities', JSON.stringify(activities));
            }

            // Dashboard Data Refresh
            function refreshDashboardData() {
                showNotification('Refreshing dashboard data...', 'info', 2000);
                
                // Add loading state to stats cards
                document.querySelectorAll('.stats-number').forEach(num => {
                    num.parentElement.classList.add('loading');
                });
                
                // Simulate data refresh (replace with actual API call)
                setTimeout(() => {
                    document.querySelectorAll('.loading').forEach(el => {
                        el.classList.remove('loading');
                    });
                    
                    showNotification('Dashboard data refreshed!', 'success', 3000);
                    logActivity('Dashboard data refreshed');
                }, 2000);
            }

            // Export Data Function
            function exportData() {
                showNotification('Preparing data export...', 'info');
                
                const data = {
                    exportDate: new Date().toISOString(),
                    totalAdmins: document.querySelector('.stats-number').textContent,
                    activities: JSON.parse(localStorage.getItem('adminActivities') || '[]')
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `admin_dashboard_export_${new Date().toISOString().slice(0,10)}.json`;
                a.click();
                URL.revokeObjectURL(url);
                
                showNotification('Data exported successfully!', 'success');
                logActivity('Data exported');
            }

            // Enhanced Keyboard Shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + N = New Admin
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    $('#newAdminModal').modal('show');
                }
                
                // Ctrl + R = Refresh Data
                if (e.ctrlKey && e.key === 'r') {
                    e.preventDefault();
                    refreshDashboardData();
                }
                
                // Ctrl + E = Export Data
                if (e.ctrlKey && e.key === 'e') {
                    e.preventDefault();
                    exportData();
                }
                
                // Escape = Close modals
                if (e.key === 'Escape') {
                    $('.modal').modal('hide');
                }
                
                // F1 = Help
                if (e.key === 'F1') {
                    e.preventDefault();
                    showHelpDialog();
                }
            });

            // Help Dialog
            function showHelpDialog() {
                const helpModal = document.createElement('div');
                helpModal.className = 'modal fade';
                helpModal.innerHTML = `
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-question-circle me-2"></i>Keyboard Shortcuts</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Quick Actions</h6>
                                        <ul class="list-unstyled">
                                            <li><kbd>Ctrl + N</kbd> New Admin</li>
                                            <li><kbd>Ctrl + R</kbd> Refresh Data</li>
                                            <li><kbd>Ctrl + E</kbd> Export Data</li>
                                            <li><kbd>Esc</kbd> Close Modals</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Navigation</h6>
                                        <ul class="list-unstyled">
                                            <li><kbd>F1</kbd> Help</li>
                                            <li><kbd>Tab</kbd> Navigate Fields</li>
                                            <li><kbd>Enter</kbd> Submit Forms</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(helpModal);
                $(helpModal).modal('show');
                
                $(helpModal).on('hidden.bs.modal', function() {
                    helpModal.remove();
                });
            }

            // Quick Actions Toggle
            function toggleQuickActions() {
                const actions = document.querySelectorAll('.quick-action-btn:not(.main-fab)');
                const mainFab = document.querySelector('.main-fab i');
                
                actions.forEach((btn, index) => {
                    if (btn.style.display === 'none' || !btn.style.display) {
                        btn.style.display = 'flex';
                        btn.style.transform = 'scale(0)';
                        setTimeout(() => {
                            btn.style.transform = 'scale(1)';
                        }, index * 50);
                        mainFab.style.transform = 'rotate(45deg)';
                    } else {
                        btn.style.transform = 'scale(0)';
                        setTimeout(() => {
                            btn.style.display = 'none';
                        }, 200);
                        mainFab.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // Initialize everything when page loads
            window.addEventListener('load', function() {
                // Show welcome message
                setTimeout(() => {
                    showNotification('Welcome to PSU Admin Dashboard! 🎓', 'success', 4000);
                }, 1000);
            });
        </script>

        <!-- Additional Modern UI Enhancements -->
        <style>
            /* Loading Dots Animation */
            .loading-dots {
                display: inline-flex;
                gap: 3px;
                margin-right: 8px;
            }
            
            .loading-dots span {
                width: 4px;
                height: 4px;
                border-radius: 50%;
                background: currentColor;
                animation: loadingDots 1.4s ease-in-out infinite both;
            }
            
            .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
            .loading-dots span:nth-child(2) { animation-delay: -0.16s; }
            
            @keyframes loadingDots {
                0%, 80%, 100% {
                    transform: scale(0);
                    opacity: 0.5;
                }
                40% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Form Validation States */
            .form-group.has-error .form-control {
                border-color: #dc3545;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
                animation: shake 0.5s ease-in-out;
            }
            
            .form-group.has-success .form-control {
                border-color: #28a745;
                box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
            }
            
            .form-group.has-success::after {
                content: '✓';
                position: absolute;
                right: 15px;
                top: 50%;
                color: #28a745;
                font-weight: bold;
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }

            /* Enhanced Health Monitor Widget */
            .system-health {
                background: white;
                border-radius: var(--border-radius);
                padding: 20px;
                margin-bottom: 20px;
                border: 1px solid var(--border-color);
                box-shadow: var(--shadow-light);
            }
            
            .health-item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 15px;
                padding: 10px;
                background: var(--light-gray);
                border-radius: 8px;
            }
            
            .health-item span:first-child {
                min-width: 80px;
                font-weight: 600;
                color: var(--dark-gray);
            }
            
            .health-item .progress {
                flex: 1;
                height: 6px;
                margin: 0 10px;
            }
            
            .health-item small {
                min-width: 80px;
                text-align: right;
                color: var(--text-muted);
                font-size: 0.8rem;
            }

            /* Quick Actions Enhanced */
            .quick-actions {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 1000;
            }
            
            .quick-action-btn {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                background: var(--psu-blue);
                color: white;
                border: none;
                box-shadow: 0 4px 20px rgba(10, 39, 216, 0.3);
                margin-bottom: 12px;
                display: none;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
                transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }
            
            .quick-action-btn.main-fab {
                display: flex;
                width: 64px;
                height: 64px;
                background: linear-gradient(45deg, var(--psu-blue), var(--psu-blue-light));
                box-shadow: 0 6px 25px rgba(10, 39, 216, 0.4);
            }
            
            .quick-action-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 6px 30px rgba(10, 39, 216, 0.5);
            }
            
            .quick-action-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }
            
            .quick-action-btn:hover::before {
                left: 100%;
            }

            /* Enhanced Notifications */
            #notification-container .alert {
                margin-bottom: 10px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
                animation: slideInRight 0.3s ease-out;
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Enhanced Card Animations */
            .card.fadeInUp {
                animation: fadeInUpCard 0.6s ease forwards;
            }
            
            @keyframes fadeInUpCard {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Loading State for Stats Cards */
            .stats-card.loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                animation: shimmer 1.5s infinite;
            }
            
            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 100%; }
            }

            /* Enhanced Table Hover Effects */
            .table tbody tr {
                cursor: pointer;
            }
            
            .table tbody tr:hover {
                background: linear-gradient(135deg, var(--light-gray), #e3f2fd);
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }

            /* Pulse Animation for Stats */
            .pulse {
                animation: pulseGlow 2s infinite;
            }
            
            @keyframes pulseGlow {
                0% { 
                    transform: scale(1);
                    text-shadow: 0 0 5px rgba(10, 39, 216, 0.3);
                }
                50% { 
                    transform: scale(1.05);
                    text-shadow: 0 0 20px rgba(10, 39, 216, 0.6);
                }
                100% { 
                    transform: scale(1);
                    text-shadow: 0 0 5px rgba(10, 39, 216, 0.3);
                }
            }

            /* Keyboard Shortcut Styling */
            kbd {
                background: var(--dark-gray);
                color: white;
                padding: 3px 6px;
                border-radius: 4px;
                font-size: 0.8rem;
                border: 1px solid #666;
                box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            }

            /* Enhanced Modal Animations */
            .modal.fade .modal-dialog {
                transition: transform 0.3s ease-out, opacity 0.3s;
                transform: translate(0, -50px) scale(0.95);
            }
            
            .modal.fade.show .modal-dialog {
                transform: translate(0, 0) scale(1);
            }

            /* Enhanced Progress Bars */
            .progress {
                background: var(--light-gray);
                border-radius: 10px;
                overflow: hidden;
                position: relative;
            }
            
            .progress-bar {
                transition: width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                position: relative;
                overflow: hidden;
            }
            
            .progress-bar::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, 
                    rgba(255,255,255,0.15) 25%, 
                    transparent 25%, 
                    transparent 50%, 
                    rgba(255,255,255,0.15) 50%, 
                    rgba(255,255,255,0.15) 75%, 
                    transparent 75%);
                background-size: 20px 20px;
                animation: progressStripes 1s linear infinite;
            }
            
            @keyframes progressStripes {
                0% { background-position: 0 0; }
                100% { background-position: 20px 0; }
            }

            /* Enhanced Button States */
            .btn.loading {
                position: relative;
                color: transparent !important;
            }
            
            .btn.loading::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                margin: -8px 0 0 -8px;
                width: 16px;
                height: 16px;
                border: 2px solid transparent;
                border-top-color: currentColor;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Activity Indicator */
            .activity-indicator {
                position: fixed;
                top: 10px;
                right: 10px;
                width: 8px;
                height: 8px;
                background: #28a745;
                border-radius: 50%;
                animation: pulse 2s infinite;
                z-index: 1001;
            }

            /* Enhanced Delete Button */
            .delete-btn:hover {
                background: #dc3545 !important;
                transform: scale(1.1);
                box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            }

            /* Tooltip Enhancement */
            [title]:hover::after {
                content: attr(title);
                position: absolute;
                background: var(--dark-gray);
                color: white;
                padding: 5px 8px;
                border-radius: 4px;
                font-size: 0.8rem;
                white-space: nowrap;
                z-index: 1000;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                margin-bottom: 5px;
            }

            /* Data Export Animation */
            .export-progress {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 10px 50px rgba(0,0,0,0.3);
                text-align: center;
                z-index: 10000;
            }

            /* System Status Indicators */
            .status-online {
                color: #28a745;
                animation: pulse 2s infinite;
            }
            
            .status-warning {
                color: #ffc107;
                animation: pulse 2s infinite;
            }
            
            .status-error {
                color: #dc3545;
                animation: pulse 2s infinite;
            }

            /* Enhanced Breadcrumb */
            .breadcrumb-item + .breadcrumb-item::before {
                content: "›";
                color: var(--psu-blue);
                font-weight: bold;
            }

            /* Smart Form Enhancements */
            .form-control:focus + .form-label::after {
                width: 100%;
            }
            
            .form-floating > .form-control:focus ~ label,
            .form-floating > .form-control:not(:placeholder-shown) ~ label {
                transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
                color: var(--psu-blue);
            }
        </style>

    </body>
</html>