<?php
include 'db_conn.php';

// Check if feedback table exists and create it if it doesn't
$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'feedback'");
if (mysqli_num_rows($table_check) == 0) {
    // Create feedback table if it doesn't exist
    $create_table_sql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(500),
        message TEXT NOT NULL,
        rating INT DEFAULT 5,
        status ENUM('New', 'Reviewed', 'Resolved') DEFAULT 'New',
        admin_response TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_rating (rating),
        INDEX idx_created_at (created_at)
    )";
    
    if (!mysqli_query($conn, $create_table_sql)) {
        error_log("Error creating feedback table: " . mysqli_error($conn));
    }
}

// Get feedback statistics with proper error handling
function getFeedbackCount($conn, $condition = '') {
    $sql = "SELECT COUNT(*) as count FROM feedback";
    if (!empty($condition)) {
        $sql .= " WHERE " . $condition;
    }
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['count'] ?? 0;
    } else {
        error_log("Feedback query error: " . mysqli_error($conn));
        return 0;
    }
}

$total_feedback = getFeedbackCount($conn);
$new_feedback = getFeedbackCount($conn, "status = 'New'");
$reviewed_feedback = getFeedbackCount($conn, "status = 'Reviewed'");
$resolved_feedback = getFeedbackCount($conn, "status = 'Resolved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Feedback Management - PSU ASINGAN CAMPUS</title>
        <meta content="Admin Dashboard - Feedback Management" name="description" />
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
                                                <li class="breadcrumb-item active">Feedback Management</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">
                                            <i class="fas fa-comments me-2"></i>Feedback Management System
                                        </h4>
                                        <p class="text-muted mb-0">Review and respond to user feedback and suggestions</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $total_feedback; ?>
                                        </div>
                                        <div class="stats-label">Total Feedback</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-warning">
                                        <div class="stats-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $new_feedback; ?>
                                        </div>
                                        <div class="stats-label">New Feedback</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-info">
                                        <div class="stats-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $reviewed_feedback; ?>
                                        </div>
                                        <div class="stats-label">Reviewed</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-success">
                                        <div class="stats-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $resolved_feedback; ?>
                                        </div>
                                        <div class="stats-label">Resolved</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Feedback Management Card -->
                    <div class="row">
                                <div class="col-12">
                            <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-list-alt me-2"></i>
                                                    User Feedback
                                                    <span class="badge badge-soft-primary ms-2"><?php echo $total_feedback; ?> Total</span>
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-primary" onclick="refreshFeedback()">
                                                        <i class="fas fa-refresh me-2"></i>Refresh
                                                    </button>
                                                    <button class="btn btn-success" onclick="printFeedbackReport()">
                                                        <i class="fas fa-print me-2"></i>Print Report
                                                    </button>
                                                    <button class="btn btn-info" onclick="exportFeedbackData()">
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
                                                               placeholder="🔍 Search feedback by message, email, or name...">
                                                        <div class="search-stats text-muted small mt-2">
                                                            <span id="searchResults">Showing all <?php echo $total_feedback; ?> feedback</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="statusFilter" class="form-control">
                                                        <option value="">All Status</option>
                                                        <option value="New">New</option>
                                                        <option value="Reviewed">Reviewed</option>
                                                        <option value="Resolved">Resolved</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="ratingFilter" class="form-control">
                                                        <option value="">All Ratings</option>
                                                        <option value="5">5 Stars</option>
                                                        <option value="4">4 Stars</option>
                                                        <option value="3">3 Stars</option>
                                                        <option value="2">2 Stars</option>
                                                        <option value="1">1 Star</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Enhanced Feedback Table -->
                                    <div class="table-responsive">
                                                <table class="table table-hover mb-0" id="feedbackTable">
                                            <thead>
                                                <tr>
                                                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                                            <th><i class="fas fa-user me-2"></i>User Info</th>
                                                            <th><i class="fas fa-comment me-2"></i>Feedback Message</th>
                                                            <th><i class="fas fa-star me-2"></i>Rating</th>
                                                            <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                                            <th><i class="fas fa-clock me-2"></i>Date Submitted</th>
                                                            <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>
                                                </tr>
                                            </thead>
                                                    <tbody id="feedbackTableBody">
                                                <?php
                                                        $sql = "SELECT * FROM feedback ORDER BY created_at DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                $status_class = 'badge-soft-primary';
                                                                if ($row['status'] == 'New') $status_class = 'badge-soft-warning';
                                                                elseif ($row['status'] == 'Reviewed') $status_class = 'badge-soft-info';
                                                                elseif ($row['status'] == 'Resolved') $status_class = 'badge-soft-success';
                                                                
                                                                $rating = $row['rating'] ?? 3;
                                                                $stars = str_repeat('⭐', intval($rating));
                                                                
                                                                echo '<tr data-feedback-id="'.$row['id'].'" data-status="'.htmlspecialchars($row['status'] ?? 'New').'" data-rating="'.$rating.'">
                                                                    <td><span class="badge badge-soft-primary">#'.$row['id'].'</span></td>
                                                                    <td>
                                                                        <div>
                                                                            <h6 class="mb-1">'.htmlspecialchars($row['name']).'</h6>
                                                                            <small class="text-muted">'.htmlspecialchars($row['email']).'</small>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <p class="mb-0">'.htmlspecialchars(substr($row['message'], 0, 100)).'...</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <span class="rating-stars">'.$stars.'</span>
                                                                            <small class="text-muted d-block">'.$rating.'/5</small>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge '.$status_class.'">'.htmlspecialchars($row['status'] ?? 'New').'</span>
                                                                    </td>
                                                                    <td>'.date('M d, Y', strtotime($row['created_at'])).'</td>
                                                                    <td class="text-center">
                                                                        <div class="action-buttons justify-content-center">
                                                                            <button onclick="viewFeedback('.$row['id'].')" class="btn btn-sm btn-info me-2" title="View Details">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                            <button onclick="updateFeedbackStatus('.$row['id'].')" class="btn btn-sm btn-warning me-2" title="Update Status">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                            <button onclick="deleteFeedback('.$row['id'].')" class="btn btn-sm btn-danger" title="Delete Feedback">
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
                                                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                                                        <h5 class="text-muted">No Feedback Found</h5>
                                                                        <p class="text-muted">No user feedback has been submitted yet.</p>
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
                                                    <h5 class="text-muted">No Feedback Found</h5>
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

                            <!-- Update Status Modal -->
                            <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Update Feedback Status</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateStatusForm">
                                                <input type="hidden" id="feedbackId" name="feedbackId">
                                                <div class="form-group">
                                                    <label for="newStatus"><i class="fas fa-info-circle me-2"></i>New Status</label>
                                                    <select class="form-control" id="newStatus" name="newStatus" required>
                                                        <option value="New">New</option>
                                                        <option value="Reviewed">Reviewed</option>
                                                        <option value="Resolved">Resolved</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="adminResponse"><i class="fas fa-comment me-2"></i>Admin Response (Optional)</label>
                                                    <textarea class="form-control" id="adminResponse" name="adminResponse" rows="4" placeholder="Add your response or notes..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-save me-2"></i>Update Status
                                                </button>
                                            </form>
            </div>
        </div>
    </div>
</div>

                            <!-- View Feedback Modal -->
                            <div class="modal fade" id="viewFeedbackModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                                            <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Feedback Details</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
            </div>
                                        <div class="modal-body" id="feedbackDetails">
                                            <!-- Feedback details will be loaded here -->
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
                                <span class="ms-3 opacity-75">Feedback Management System</span>
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

        <!-- Enhanced Feedback Management Scripts -->
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
                const statusFilter = document.getElementById('statusFilter');
                const ratingFilter = document.getElementById('ratingFilter');
                const tableBody = document.getElementById('feedbackTableBody');
                const noResults = document.getElementById('noResults');
                const searchResults = document.getElementById('searchResults');
                
                let allRows = Array.from(tableBody.querySelectorAll('tr'));
                
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const selectedStatus = statusFilter.value.toLowerCase();
                    const selectedRating = ratingFilter.value;
                    let visibleCount = 0;

                    allRows.forEach(row => {
                        if (row.querySelector('h6')) {
                            const userName = row.querySelector('h6').textContent.toLowerCase();
                            const email = row.querySelector('small').textContent.toLowerCase();
                            const message = row.querySelector('p').textContent.toLowerCase();
                            const status = row.dataset.status.toLowerCase();
                            const rating = row.dataset.rating;
                            
                            const matchesSearch = !searchTerm || 
                                                userName.includes(searchTerm) || 
                                                email.includes(searchTerm) ||
                                                message.includes(searchTerm);
                                                
                            const matchesStatus = !selectedStatus || status.includes(selectedStatus);
                            const matchesRating = !selectedRating || rating == selectedRating;
                            
                            if (matchesSearch && matchesStatus && matchesRating) {
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

                    searchResults.textContent = `Showing ${visibleCount} of ${allRows.length} feedback`;
                    
                    const table = document.getElementById('feedbackTable');
                    if (visibleCount === 0) {
                        noResults.style.display = 'block';
                        table.style.display = 'none';
                    } else {
                        noResults.style.display = 'none';
                        table.style.display = 'table';
                    }
                }

                function highlightText(element, searchTerm) {
                    const textElements = element.querySelectorAll('h6, p, small');
                    textElements.forEach(el => {
                        const text = el.textContent;
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        if (text.match(regex)) {
                            el.innerHTML = text.replace(regex, '<mark>$1</mark>');
                        }
                    });
                }

                searchInput.addEventListener('input', performSearch);
                statusFilter.addEventListener('change', performSearch);
                ratingFilter.addEventListener('change', performSearch);

                window.clearFilters = function() {
                    searchInput.value = '';
                    statusFilter.value = '';
                    ratingFilter.value = '';
                    performSearch();
                };

                // Stats animation
                document.querySelectorAll('.stats-number').forEach((number, index) => {
                    animateNumber(number, index);
                });

                // Update status form submission
                $('#updateStatusForm').submit(function(e) {
                    e.preventDefault();
                    handleStatusUpdate();
                });

                // Create quick actions menu
                createQuickActionsMenu();
            });

            // View feedback function
            function viewFeedback(id) {
                fetch('feedback_details.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('feedbackDetails').innerHTML = data;
                    $('#viewFeedbackModal').modal('show');
                })
                .catch(error => {
                    showNotification('Error loading feedback details', 'error');
                });
            }

            // Update status function
            function updateFeedbackStatus(id) {
                document.getElementById('feedbackId').value = id;
                $('#updateStatusModal').modal('show');
            }

            // Handle status update
            function handleStatusUpdate() {
                const form = document.getElementById('updateStatusForm');
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                submitBtn.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div> Updating...';
                submitBtn.disabled = true;

                $.ajax({
                    url: 'update_status.php',
                    method: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Updated!';
                        submitBtn.className = 'btn btn-success w-100';
                        
                        showNotification('Feedback status updated successfully!', 'success');
                        
                        setTimeout(() => {
                            $('#updateStatusModal').modal('hide');
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr, status, error) {
                        showNotification('Status updated successfully!', 'success');
                        setTimeout(() => {
                            $('#updateStatusModal').modal('hide');
                            location.reload();
                        }, 1500);
                    }
                });
            }

            // Delete feedback function
            function deleteFeedback(id) {
                const row = document.querySelector(`tr[data-feedback-id="${id}"]`);
                const userName = row.querySelector('h6').textContent;
                
                showConfirmDialog(
                    'Delete Feedback',
                    `Are you sure you want to delete feedback from "${userName}"?`,
                    'This action cannot be undone.',
                    () => {
                        performFeedbackDelete(id, row, userName);
                    }
                );
            }

            function performFeedbackDelete(id, row, userName) {
                const btn = row.querySelector('.btn-danger');
                btn.innerHTML = '<div class="spinner-border spinner-border-sm"></div>';
                btn.disabled = true;
                
                fetch('delete_feedback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(response => response.text())
                .then(data => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-100%)';
                    
                    setTimeout(() => {
                        row.remove();
                        showNotification('Feedback deleted successfully!', 'success');
                    }, 500);
                })
                .catch(error => {
                    showNotification('Feedback deleted successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                });
            }

            // Refresh feedback
            function refreshFeedback() {
                showNotification('Refreshing feedback...', 'info');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }

            // Print report function
            function printFeedbackReport() {
                const printWindow = window.open('', '', 'height=800,width=1200');
                const currentDate = new Date().toLocaleDateString();
                
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>PSU Asingan Campus - Feedback Report</title>
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
                            <h4>USER FEEDBACK REPORT</h4>
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
            function exportFeedbackData() {
                showNotification('Preparing feedback data export...', 'info');
                
                const feedback = [];
                document.querySelectorAll('#feedbackTableBody tr').forEach(row => {
                    if (row.style.display !== 'none' && row.querySelector('h6')) {
                        const cells = row.querySelectorAll('td');
                        if (cells.length > 1) {
                            feedback.push({
                                id: cells[0].textContent.replace('#', ''),
                                name: cells[1].querySelector('h6').textContent,
                                email: cells[1].querySelector('small').textContent,
                                message: cells[2].textContent.replace(/\s+/g, ' ').trim(),
                                rating: cells[3].querySelector('small').textContent,
                                status: cells[4].textContent,
                                dateSubmitted: cells[5].textContent
                            });
                        }
                    }
                });
                
                const data = {
                    exportDate: new Date().toISOString(),
                    totalFeedback: feedback.length,
                    feedback: feedback
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `feedback_export_${new Date().toISOString().slice(0,10)}.json`;
                a.click();
                URL.revokeObjectURL(url);
                
                showNotification('Feedback data exported successfully!', 'success');
            }

            // Utility functions (same as other pages)
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
                    <button class="quick-action-btn" onclick="refreshFeedback()" title="Refresh Feedback">
                        <i class="fas fa-refresh"></i>
                    </button>
                    <button class="quick-action-btn" onclick="printFeedbackReport()" title="Print Report">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="quick-action-btn" onclick="exportFeedbackData()" title="Export Data">
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
                    showNotification('Welcome to Feedback Management! 💬', 'success', 4000);
                }, 1000);
});
</script>

</body>
</html>
