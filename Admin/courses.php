<?php
include 'db_conn.php'; 
// admin/courses
$sql = "SELECT COUNT(*) as count FROM courses";
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
        <title>Course Management - PSU ASINGAN CAMPUS</title>
        <meta content="Admin Dashboard - Course Management" name="description" />
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
                                                <li class="breadcrumb-item"><a href="dashboard.php">PSU</a></li>
                                                <li class="breadcrumb-item active">Course Management</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title"><i class="fas fa-book-open me-2"></i>Course Management System</h4>
                                        <p class="text-muted mb-0">Manage and organize academic programs and courses</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Card -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="stats-number"><?php echo $count; ?></div>
                                        <div class="stats-label">Total Courses</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php
                                            $student_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM students"))['count'];
                                            echo $student_count;
                                            ?>
                                        </div>
                                        <div class="stats-label">Enrolled Students</div>
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
                                        <div class="stats-label">Faculty Members</div>
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
                        
                            <!-- Main Course Management Card -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-list-alt me-2"></i>
                                                    All Courses & Programs
                                                    <span class="badge badge-soft-primary ms-2"><?php echo $count; ?> Total</span>
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <a href="add-course.php" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Add New Course
                                                    </a>
                                                    <button class="btn btn-success" onclick="printReport()">
                                                        <i class="fas fa-print me-2"></i>Print Report
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Enhanced Search Bar -->
                                            <div class="row mb-4">
                                                <div class="col-md-8">
                                                    <div class="search-wrapper position-relative">
                                                        <input type="text" id="searchInput" class="form-control" 
                                                               placeholder="🔍 Search courses by name, tag, or description...">
                                                        <div class="search-stats text-muted small mt-2">
                                                            <span id="searchResults">Showing all <?php echo $count; ?> courses</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="filter-options">
                                                        <select id="categoryFilter" class="form-control">
                                                            <option value="">All Categories</option>
                                                            <option value="Education">Education</option>
                                                            <option value="Technology">Technology</option>
                                                            <option value="Business">Business</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Enhanced Courses Table -->
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" id="coursesTable">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                                            <th><i class="fas fa-graduation-cap me-2"></i>Course Name</th>
                                                            <th><i class="fas fa-tag me-2"></i>Category</th>
                                                            <th><i class="fas fa-info-circle me-2"></i>Description</th>
                                                            <th><i class="fas fa-image me-2"></i>Image</th>
                                                            <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="courseTableBody">
                                                        <?php
                                                        // Get courses from database
                                                        $sql = "SELECT * FROM courses ORDER BY course_name";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                $description = strlen($row['description']) > 80 ? 
                                                                              substr($row['description'], 0, 80) . '...' : 
                                                                              $row['description'];
                                                                              
                                                                echo '<tr data-course-id="'.$row['id'].'" data-category="'.htmlspecialchars($row['course_tag']).'">
                                                                    <td><span class="badge badge-soft-primary">#'.$row['id'].'</span></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div>
                                                                                <h6 class="mb-1">'.htmlspecialchars($row['course_name']).'</h6>
                                                                                <small class="text-muted">Program</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-soft-warning">'.htmlspecialchars($row['course_tag']).'</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-muted" title="'.htmlspecialchars($row['description']).'">
                                                                            '.htmlspecialchars($description).'
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <img src="'.htmlspecialchars($row['course_image']).'" 
                                                                             alt="Course Image" 
                                                                             class="rounded course-thumb"
                                                                             style="width: 50px; height: 50px; object-fit: cover;"
                                                                             onerror="this.src=\'../assets/images/courses/course1.jpeg\'">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="action-buttons justify-content-center">
                                                                            <a href="edit-course.php?id='.$row['id'].'" class="btn btn-sm btn-warning me-2" title="Edit Course">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <button onclick="deleteCourse('.$row['id'].')" class="btn btn-sm btn-danger" title="Delete Course">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                <td colspan="6" class="text-center py-4">
                                                                    <div class="empty-state">
                                                                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                                                        <h5 class="text-muted">No Courses Found</h5>
                                                                        <p class="text-muted">Start by adding your first course program</p>
                                                                        <a href="add-course.php" class="btn btn-primary">
                                                                            <i class="fas fa-plus me-2"></i>Add First Course
                                                                        </a>
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
                                                    <h5 class="text-muted">No Courses Found</h5>
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
                            
                        </div> <!-- container-fluid -->
                    </div> <!-- page-content-wrapper -->
                </div> <!-- content -->

                <!-- Modern Footer -->
                <footer class="footer">
                    <div style="background: var(--psu-blue); color: white; padding: 15px 20px; border-radius: 10px; margin: 20px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>© 2024 PSU ASINGAN CAMPUS</strong>
                                <span class="ms-3 opacity-75">Course Management System</span>
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

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- Modern Course Management Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Preloader
                const preloader = document.getElementById('preloader');
                setTimeout(() => {
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 300);
                }, 1000);

                // Enhanced search functionality
                const searchInput = document.getElementById('searchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                const tableBody = document.getElementById('courseTableBody');
                const noResults = document.getElementById('noResults');
                const searchResults = document.getElementById('searchResults');
                
                let allRows = Array.from(tableBody.querySelectorAll('tr'));
                
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const selectedCategory = categoryFilter.value.toLowerCase();
                    let visibleCount = 0;

                    allRows.forEach(row => {
                        const courseName = row.querySelector('h6').textContent.toLowerCase();
                        const category = row.dataset.category.toLowerCase();
                        const description = row.querySelector('.text-muted[title]')?.getAttribute('title').toLowerCase() || '';
                        
                        const matchesSearch = !searchTerm || 
                                            courseName.includes(searchTerm) || 
                                            category.includes(searchTerm) || 
                                            description.includes(searchTerm);
                                            
                        const matchesCategory = !selectedCategory || category.includes(selectedCategory);
                        
                        if (matchesSearch && matchesCategory) {
                            row.style.display = '';
                            visibleCount++;
                            
                            // Highlight search terms
                            if (searchTerm) {
                                highlightText(row, searchTerm);
                            }
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update search results counter
                    searchResults.textContent = `Showing ${visibleCount} of ${allRows.length} courses`;
                    
                    // Show/hide no results message
                    const table = document.getElementById('coursesTable');
                    if (visibleCount === 0) {
                        noResults.style.display = 'block';
                        table.style.display = 'none';
                    } else {
                        noResults.style.display = 'none';
                        table.style.display = 'table';
                    }
                }

                function highlightText(element, searchTerm) {
                    // Simple highlight implementation
                    const textElements = element.querySelectorAll('h6, .text-muted');
                    textElements.forEach(el => {
                        const text = el.textContent;
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        if (text.match(regex)) {
                            el.innerHTML = text.replace(regex, '<mark>$1</mark>');
                        }
                    });
                }

                // Event listeners
                searchInput.addEventListener('input', performSearch);
                categoryFilter.addEventListener('change', performSearch);

                // Clear filters function
                window.clearFilters = function() {
                    searchInput.value = '';
                    categoryFilter.value = '';
                    performSearch();
                };

                // Stats animation
                document.querySelectorAll('.stats-number').forEach(number => {
                    const finalValue = parseInt(number.textContent);
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 30);
                    
                    const counter = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(counter);
                        }
                        number.textContent = currentValue;
                    }, 50);
                });
            });

            // Enhanced delete course function
            function deleteCourse(id) {
                if (confirm('⚠️ Are you sure you want to delete this course?\n\nThis action cannot be undone and will affect all related data.')) {
                    const btn = event.target.closest('button');
                    const row = btn.closest('tr');
                    
                    // Loading state
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btn.disabled = true;

                    fetch('delete_courses.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            // Animate row removal
                            row.style.transition = 'all 0.5s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-100%)';
                            
                            setTimeout(() => {
                                row.remove();
                                // Update counter
                                const currentCount = document.querySelectorAll('#courseTableBody tr').length;
                                document.querySelector('.stats-number').textContent = currentCount - 1;
                                
                                // Show success message
                                showNotification('Course deleted successfully!', 'success');
                            }, 500);
                        } else {
                            showNotification('Error deleting course: ' + data, 'error');
                            btn.innerHTML = originalHtml;
                            btn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error deleting course', 'error');
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    });
                }
            }

            // Notification system
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }

            // Enhanced print report function
            function printReport() {
                const printWindow = window.open('', '', 'height=800,width=1200');
                const currentDate = new Date().toLocaleDateString();
                
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>PSU Asingan Campus - Courses Report</title>
                        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .header { text-align: center; margin-bottom: 30px; }
                            .logo { width: 80px; height: 80px; margin-bottom: 10px; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                            th { background-color: #0A27D8; color: white; }
                            .footer { margin-top: 30px; text-align: center; color: #666; }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h2>PANGASINAN STATE UNIVERSITY</h2>
                            <h3>ASINGAN CAMPUS</h3>
                            <h4>COURSES AND PROGRAMS REPORT</h4>
                            <p>Generated on: ${currentDate}</p>
                        </div>
                        <div class="content">
                            ${document.querySelector('.table-responsive').innerHTML}
                        </div>
                        <div class="footer">
                            <p>© 2024 PSU Asingan Campus - Official Academic Report</p>
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
        </script>

        <!-- Additional Styling -->
        <style>
            .search-wrapper {
                position: relative;
            }
            
            .course-thumb {
                border: 2px solid var(--border-color);
                transition: all 0.3s ease;
            }
            
            .course-thumb:hover {
                transform: scale(1.05);
                border-color: var(--psu-blue);
            }
            
            .empty-state {
                padding: 40px 20px;
            }
            
            mark {
                background: #fff3cd;
                color: #856404;
                padding: 2px 4px;
                border-radius: 3px;
                font-weight: 600;
            }
            
            .filter-options select {
                border-radius: 8px;
                border: 2px solid var(--border-color);
                padding: 12px 15px;
                background: white;
            }
            
            .search-stats {
                margin-top: 5px;
                font-size: 0.9rem;
                color: var(--text-muted);
            }

            /* Fix table row hover effects */
            .table tbody tr:hover {
                background: var(--light-gray);
                transform: none;
            }

            /* Ensure proper text visibility */
            .card-header h5 {
                color: white !important;
            }

            /* Clean notification styling */
            .alert {
                border-radius: 8px;
                border: 1px solid;
            }
        </style>

    </body>
</html>