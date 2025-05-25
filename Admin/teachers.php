<?php
include 'db_conn.php'; 

$sql = "SELECT COUNT(*) as count FROM teachers";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
} else {
    $count = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Teacher Management - PSU ASINGAN CAMPUS</title>
        <meta content="Admin Dashboard - Teacher Management" name="description" />
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

        <!-- Enhanced Loader -->
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

                            <!-- Enhanced Page Title -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="dashboard.php">PSU</a></li>
                                                <li class="breadcrumb-item active">Teacher Management</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">
                                            <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Management System
                                        </h4>
                                        <p class="text-muted mb-0">Manage faculty members and their academic information</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $count; ?>
                                        </div>
                                        <div class="stats-label">Total Teachers</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $active_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM teachers"))['count'];
                                            echo $active_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Active Teachers</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $dept_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(DISTINCT Department) as count FROM teachers"))['count'];
                                            echo $dept_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Departments</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="stats-number">2024</div>
                                        <div class="stats-label">Academic Year</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Teacher Management Card -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">                                
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-list-alt me-2"></i>
                                                    Faculty Directory
                                                    <span class="badge badge-soft-primary ms-2"><?php echo $count; ?> Total</span>
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                                                        <i class="fas fa-user-plus me-2"></i>Add New Teacher
                                                    </button>
                                                    <button class="btn btn-success" onclick="printTeacherReport()">
                                                        <i class="fas fa-print me-2"></i>Print Report
                                                    </button>
                                                    <button class="btn btn-info" onclick="exportTeacherData()">
                                                        <i class="fas fa-file-export me-2"></i>Export Data
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Enhanced Search and Filter Bar -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="search-wrapper position-relative">
                                                        <input type="text" id="searchInput" class="form-control" 
                                                               placeholder="🔍 Search teachers by name, department, or position...">
                                                        <div class="search-stats text-muted small mt-2">
                                                            <span id="searchResults">Showing all <?php echo $count; ?> teachers</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="departmentFilter" class="form-control">
                                                        <option value="">All Departments</option>
                                                        <?php
                                                        $dept_query = "SELECT DISTINCT Department FROM teachers ORDER BY Department";
                                                        $dept_result = mysqli_query($conn, $dept_query);
                                                        while($dept = mysqli_fetch_assoc($dept_result)) {
                                                            echo '<option value="'.$dept['Department'].'">'.$dept['Department'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="genderFilter" class="form-control">
                                                        <option value="">All Genders</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Enhanced Teachers Table -->
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" id="teachersTable">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                                            <th><i class="fas fa-user me-2"></i>Teacher Info</th>
                                                            <th><i class="fas fa-envelope me-2"></i>Contact</th>
                                                            <th><i class="fas fa-building me-2"></i>Department</th>
                                                            <th><i class="fas fa-user-tie me-2"></i>Position</th>
                                                            <th><i class="fas fa-venus-mars me-2"></i>Gender</th>
                                                            <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="teacherTableBody">
                                                        <?php
                                                        $sql = "SELECT * FROM teachers ORDER BY FullName";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                $imageSrc = ($row['Gender'] == 'Male') ? 'assets/images/manteacher.png' : 'assets/images/womanteacher.svg';
                                                                
                                                                echo '<tr data-teacher-id="'.$row['TeacherID'].'" data-department="'.htmlspecialchars($row['Department']).'" data-gender="'.$row['Gender'].'">
                                                                    <td><span class="badge badge-soft-primary">#'.$row['TeacherID'].'</span></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="'.$imageSrc.'" alt="" class="rounded-circle me-3 thumb-md">
                                                                            <div>
                                                                                <h6 class="mb-1">'.htmlspecialchars($row['FullName']).'</h6>
                                                                                <small class="text-muted">Faculty Member</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <div><i class="fas fa-envelope text-muted me-2"></i>'.htmlspecialchars($row['Email']).'</div>
                                                                            <div><i class="fas fa-phone text-muted me-2"></i>'.htmlspecialchars($row['PhoneNumber']).'</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-soft-info">'.htmlspecialchars($row['Department']).'</span>
                                                                    </td>
                                                                    <td>'.htmlspecialchars($row['Designation']).'</td>
                                                                    <td>
                                                                        <span class="badge badge-soft-warning">'.htmlspecialchars($row['Gender']).'</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="action-buttons justify-content-center">
                                                                            <button onclick="viewTeacher('.$row['TeacherID'].')" class="btn btn-sm btn-info me-2" title="View Details">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                            <button onclick="editTeacher('.$row['TeacherID'].')" class="btn btn-sm btn-warning me-2" title="Edit Teacher">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                            <button onclick="deleteTeacher('.$row['TeacherID'].')" class="btn btn-sm btn-danger" title="Delete Teacher">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                <td colspan="7" class="text-center py-4">
                                                                    <div class="empty-state">
                                                                        <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                                                                        <h5 class="text-muted">No Teachers Found</h5>
                                                                        <p class="text-muted">Start by adding your first teacher</p>
                                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                                                                            <i class="fas fa-plus me-2"></i>Add First Teacher
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- No Results Message -->
                                            <div id="noResults" class="text-center py-5" style="display: none;">
                                                <div class="empty-state">
                                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No Teachers Found</h5>
                                                    <p class="text-muted">Try adjusting your search criteria</p>
                                                    <button class="btn btn-primary" onclick="clearFilters()">
                                                        <i class="fas fa-refresh me-2"></i>Clear Filters
                        </button>
                        </div>
                                            </div>
                                        </div>
                        </div>
                    </div>
                </div>

                            <!-- Enhanced Add Teacher Modal -->
                            <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                            <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add New Teacher</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                            <form id="addTeacherForm" method="POST" action="add_teachers.php">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fullname"><i class="fas fa-user me-2"></i>Full Name</label>
                                                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="teacherEmail"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                                            <input type="email" class="form-control" id="teacherEmail" name="teacherEmail" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="pnumber"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                                            <input type="text" class="form-control" id="pnumber" name="pnumber" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="gender"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                                                            <select class="form-control" id="gender" name="gender" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="department"><i class="fas fa-building me-2"></i>Department</label>
                                                            <select class="form-control" id="department" name="department" required>
                                                                <option value="">Select Department</option>
                                                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                                                <option value="BSBA">Bachelor of Science in Business Administration</option>
                                                                <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                                                                <option value="BEE">Bachelor of Elementary Education</option>
                                                                <option value="BSE">Bachelor of Secondary Education</option>
                                                                <option value="BIT">Bachelor of Industrial Technology</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="designation"><i class="fas fa-user-tie me-2"></i>Position</label>
                                                            <input type="text" class="form-control" id="designation" name="designation" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-save me-2"></i>Add Teacher
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Edit Teacher Modal -->
                            <div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Teacher</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editTeacherForm" method="POST" action="update_teacher.php">
                                                <input type="hidden" id="editTeacherID" name="TeacherID">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editFullName"><i class="fas fa-user me-2"></i>Full Name</label>
                                                            <input type="text" class="form-control" id="editFullName" name="FullName" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editEmail"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                                            <input type="email" class="form-control" id="editEmail" name="Email" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editPhoneNumber"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                                            <input type="text" class="form-control" id="editPhoneNumber" name="PhoneNumber" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editGender"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                                                            <select class="form-control" id="editGender" name="Gender" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editdepartment"><i class="fas fa-building me-2"></i>Department</label>
                                                            <select class="form-control" id="editdepartment" name="Department" required>
                                                                <option value="">Select Department</option>
                                                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                                                <option value="BSBA">Bachelor of Science in Business Administration</option>
                                                                <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                                                                <option value="BEE">Bachelor of Elementary Education</option>
                                                                <option value="BSE">Bachelor of Secondary Education</option>
                                                                <option value="BIT">Bachelor of Industrial Technology</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="editDesignation"><i class="fas fa-user-tie me-2"></i>Position</label>
                                                            <input type="text" class="form-control" id="editDesignation" name="Designation" required>
                                                        </div>
                                                        </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-save me-2"></i>Save Changes
                                                </button>
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
                                <span class="ms-3 opacity-75">Teacher Management System</span>
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
        <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/dashboard.js"></script>
        <script src="assets/js/app.js"></script>

        <!-- Enhanced Teacher Management Scripts -->
        <script>
document.addEventListener('DOMContentLoaded', function() {
                // Enhanced Preloader
                const preloader = document.getElementById('preloader');
                setTimeout(() => {
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 300);
                }, 1000);

                // Initialize notification system
                initNotificationSystem();

                // Enhanced search functionality
    const searchInput = document.getElementById('searchInput');
                const departmentFilter = document.getElementById('departmentFilter');
                const genderFilter = document.getElementById('genderFilter');
                const tableBody = document.getElementById('teacherTableBody');
                const noResults = document.getElementById('noResults');
                const searchResults = document.getElementById('searchResults');
                
                let allRows = Array.from(tableBody.querySelectorAll('tr'));
                
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const selectedDepartment = departmentFilter.value.toLowerCase();
                    const selectedGender = genderFilter.value.toLowerCase();
                    let visibleCount = 0;

                    allRows.forEach(row => {
                        if (row.querySelector('h6')) {
                            const teacherName = row.querySelector('h6').textContent.toLowerCase();
                            const department = row.dataset.department.toLowerCase();
                            const gender = row.dataset.gender.toLowerCase();
                            const contact = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                            
                            const matchesSearch = !searchTerm || 
                                                teacherName.includes(searchTerm) || 
                                                department.includes(searchTerm) || 
                                                contact.includes(searchTerm);
                                                
                            const matchesDepartment = !selectedDepartment || department.includes(selectedDepartment);
                            const matchesGender = !selectedGender || gender.includes(selectedGender);
                            
                            if (matchesSearch && matchesDepartment && matchesGender) {
                                row.style.display = '';
                                visibleCount++;
                                
                                if (searchTerm) {
                                    highlightText(row, searchTerm);
                                }
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });

                    searchResults.textContent = `Showing ${visibleCount} of ${allRows.length} teachers`;
                    
                    const table = document.getElementById('teachersTable');
                    if (visibleCount === 0) {
                        noResults.style.display = 'block';
                        table.style.display = 'none';
            } else {
                        noResults.style.display = 'none';
                        table.style.display = 'table';
                    }
                }

                function highlightText(element, searchTerm) {
                    const textElements = element.querySelectorAll('h6, td');
                    textElements.forEach(el => {
                        const text = el.textContent;
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        if (text.match(regex)) {
                            el.innerHTML = text.replace(regex, '<mark>$1</mark>');
                        }
                    });
                }

                searchInput.addEventListener('input', performSearch);
                departmentFilter.addEventListener('change', performSearch);
                genderFilter.addEventListener('change', performSearch);

                window.clearFilters = function() {
                    searchInput.value = '';
                    departmentFilter.value = '';
                    genderFilter.value = '';
                    performSearch();
                };

                // Stats animation
                document.querySelectorAll('.stats-number').forEach((number, index) => {
                    animateNumber(number, index);
                });

                // Enhanced form submission
                $('#addTeacherForm').submit(function(e) {
                    e.preventDefault();
                    handleFormSubmission(this, 'Teacher added successfully!');
                });

                $('#editTeacherForm').submit(function(e) {
                    e.preventDefault();
                    handleFormSubmission(this, 'Teacher updated successfully!');
                });

                // Create quick actions menu
                createQuickActionsMenu();
            });

            // Enhanced form submission handler
            function handleFormSubmission(form, successMessage) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Saving...';
                submitBtn.disabled = true;

    $.ajax({
                    url: form.action,
        method: 'POST',
                    data: $(form).serialize(),
        success: function(response) {
                        try {
                            let res = JSON.parse(response);
                            if (res.status === 'success') {
                                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Success!';
                                submitBtn.className = 'btn btn-success w-100';
                                
                                showNotification(successMessage, 'success');
                                
                                setTimeout(() => {
                                    $(form).closest('.modal').modal('hide');
                                    location.reload();
                                }, 1500);
                            } else {
                                throw new Error(res.message || 'Operation failed');
                            }
                        } catch (e) {
                            showNotification('Operation failed. Please try again.', 'error');
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
            }
        },
        error: function(xhr, status, error) {
                        showNotification('Network error. Please try again.', 'error');
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }

            // Enhanced delete function
            function deleteTeacher(id) {
                const row = document.querySelector(`tr[data-teacher-id="${id}"]`);
                const teacherName = row.querySelector('h6').textContent;
                
                showConfirmDialog(
                    'Delete Teacher',
                    `Are you sure you want to delete "${teacherName}"?`,
                    'This action cannot be undone.',
                    () => {
                        performDelete(id, row, teacherName);
                    }
                );
            }

            function performDelete(id, row, teacherName) {
                const btn = row.querySelector('.btn-danger');
                btn.innerHTML = '<div class="spinner-border spinner-border-sm"></div>';
                btn.disabled = true;
                
        fetch('delete_teacher1.php', {
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
                            showNotification(`${teacherName} deleted successfully!`, 'success');
                        }, 500);
            } else {
                        throw new Error(data);
            }
        })
        .catch(error => {
                    showNotification('Error deleting teacher: ' + error.message, 'error');
                    btn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    btn.disabled = false;
                });
            }

            // Edit teacher function
            function editTeacher(id) {
                fetch('get_teacher.php?id=' + encodeURIComponent(id), {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const teacher = data.teacher;
                        document.getElementById('editTeacherID').value = teacher.TeacherID;
                        document.getElementById('editFullName').value = teacher.FullName;
                        document.getElementById('editEmail').value = teacher.Email;
                        document.getElementById('editPhoneNumber').value = teacher.PhoneNumber;
                        document.getElementById('editGender').value = teacher.Gender;
                        document.getElementById('editdepartment').value = teacher.Department;
                        document.getElementById('editDesignation').value = teacher.Designation;
                        
                        $('#editTeacherModal').modal('show');
                    } else {
                        showNotification('Error loading teacher data: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading teacher data: ' + error.message, 'error');
                });
            }

            // View teacher function
            function viewTeacher(id) {
                showNotification('View teacher feature coming soon!', 'info');
            }

            // Print report function
            function printTeacherReport() {
                const printWindow = window.open('', '', 'height=800,width=1200');
                const currentDate = new Date().toLocaleDateString();
                
                printWindow.document.write(`
                <html>
                <head>
                        <title>PSU Asingan Campus - Teachers Report</title>
                        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                            body { font-family: Arial, sans-serif; }
                            .header { text-align: center; margin-bottom: 30px; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                            th { background-color: #0A27D8; color: white; }
                    </style>
                </head>
                <body>
                        <div class="header">
                            <h2>PANGASINAN STATE UNIVERSITY</h2>
                            <h3>ASINGAN CAMPUS</h3>
                            <h4>FACULTY DIRECTORY REPORT</h4>
                            <p>Generated on: ${currentDate}</p>
                        </div>
                        <div class="content">
                            ${document.querySelector('.table-responsive').innerHTML}
                        </div>
                    </body>
                    </html>
                `);
                
                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 1000);
            }

            // Export data function
            function exportTeacherData() {
                showNotification('Preparing teacher data export...', 'info');
                
                const teachers = [];
                document.querySelectorAll('#teacherTableBody tr').forEach(row => {
                    if (row.style.display !== 'none' && row.querySelector('h6')) {
                        const cells = row.querySelectorAll('td');
                        if (cells.length > 1) {
                            teachers.push({
                                id: cells[0].textContent.replace('#', ''),
                                name: cells[1].querySelector('h6').textContent,
                                contact: cells[2].textContent.replace(/\s+/g, ' ').trim(),
                                department: cells[3].textContent,
                                position: cells[4].textContent,
                                gender: cells[5].textContent
                            });
                        }
                    }
                });
                
                const data = {
                    exportDate: new Date().toISOString(),
                    totalTeachers: teachers.length,
                    teachers: teachers
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `teachers_export_${new Date().toISOString().slice(0,10)}.json`;
                a.click();
                URL.revokeObjectURL(url);
                
                showNotification('Teacher data exported successfully!', 'success');
            }

            // Utility functions
            function initNotificationSystem() {
                if (!document.getElementById('notification-container')) {
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

            function createQuickActionsMenu() {
                const quickActions = document.createElement('div');
                quickActions.className = 'quick-actions';
                quickActions.innerHTML = `
                    <button class="quick-action-btn" onclick="$('#addTeacherModal').modal('show')" title="Add New Teacher">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <button class="quick-action-btn" onclick="printTeacherReport()" title="Print Report">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="quick-action-btn" onclick="exportTeacherData()" title="Export Data">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="quick-action-btn main-fab" onclick="toggleQuickActions()" title="Toggle Menu">
                        <i class="fas fa-plus"></i>
                    </button>
                `;
                document.body.appendChild(quickActions);
            }

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

            // Initialize welcome message
            window.addEventListener('load', function() {
                setTimeout(() => {
                    showNotification('Welcome to Teacher Management System! 👨‍🏫', 'success', 4000);
                }, 1000);
            });
</script>

    </body>
</html>