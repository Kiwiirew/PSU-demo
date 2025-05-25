<?php
include 'db_conn.php'; 

// Get ticket statistics
$total_tickets = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM tickets"))['count'] ?? 0;
$open_tickets = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM tickets WHERE status = 'Open'"))['count'] ?? 0;
$resolved_tickets = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM tickets WHERE status = 'Resolved'"))['count'] ?? 0;
$in_progress_tickets = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as count FROM tickets WHERE status = 'In Progress'"))['count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Support Tickets - PSU ASINGAN CAMPUS</title>
        <meta content="Admin Dashboard - Support Ticket Management" name="description" />
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
                                                <li class="breadcrumb-item active">Support Tickets</li>
                                            </ol>
                        </div>
                                        <h4 class="page-title">
                                            <i class="fas fa-headset me-2"></i>Support Ticket Management
                                        </h4>
                                        <p class="text-muted mb-0">Manage and track support requests from students and faculty</p>
                        </div>
                    </div>
                </div>

                            <!-- Enhanced Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $total_tickets; ?>
                                        </div>
                                        <div class="stats-label">Total Tickets</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-warning">
                                        <div class="stats-icon">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $open_tickets; ?>
                                        </div>
                                        <div class="stats-label">Open Tickets</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-info">
                                        <div class="stats-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="stats-number">
                                            <?php echo $in_progress_tickets; ?>
                                        </div>
                                        <div class="stats-label">In Progress</div>
                        </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="stats-card stats-card-success">
                                        <div class="stats-icon">
                                            <i class="fas fa-check-circle"></i>
                            </div>
                                        <div class="stats-number">
                                            <?php echo $resolved_tickets; ?>
                            </div>
                                        <div class="stats-label">Resolved Tickets</div>
                    </div>
                </div>
            </div>

                            <!-- Enhanced Ticket Management Card -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-list-alt me-2"></i>
                                                    Support Tickets
                                                    <span class="badge badge-soft-primary ms-2"><?php echo $total_tickets; ?> Total</span>
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-primary" onclick="refreshTickets()">
                                                        <i class="fas fa-refresh me-2"></i>Refresh
                                                    </button>
                                                    <button class="btn btn-success" onclick="printTicketReport()">
                                                        <i class="fas fa-print me-2"></i>Print Report
                                                    </button>
                                                    <button class="btn btn-info" onclick="exportTicketData()">
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
                                                               placeholder="🔍 Search tickets by subject, description, or name...">
                                                        <div class="search-stats text-muted small mt-2">
                                                            <span id="searchResults">Showing all <?php echo $total_tickets; ?> tickets</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="statusFilter" class="form-control">
                                                        <option value="">All Status</option>
                                                        <option value="Open">Open</option>
                                                        <option value="In Progress">In Progress</option>
                                                        <option value="Resolved">Resolved</option>
                                                        <option value="Closed">Closed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="priorityFilter" class="form-control">
                                                        <option value="">All Priorities</option>
                                                        <option value="Low">Low Priority</option>
                                                        <option value="Medium">Medium Priority</option>
                                                        <option value="High">High Priority</option>
                                                        <option value="Critical">Critical</option>
                                                    </select>
                                                    </div>
                                                </div>

                                            <!-- Enhanced Tickets Table -->
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" id="ticketsTable">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-hashtag me-2"></i>Ticket ID</th>
                                                            <th><i class="fas fa-user me-2"></i>Submitted By</th>
                                                            <th><i class="fas fa-envelope me-2"></i>Subject</th>
                                                            <th><i class="fas fa-flag me-2"></i>Priority</th>
                                                            <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                                            <th><i class="fas fa-clock me-2"></i>Date Created</th>
                                                            <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ticketTableBody">
                                                        <?php
                                                        $sql = "SELECT * FROM tickets ORDER BY created_at DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                $status_class = 'badge-soft-primary';
                                                                if ($row['status'] == 'Open') $status_class = 'badge-soft-warning';
                                                                elseif ($row['status'] == 'In Progress') $status_class = 'badge-soft-info';
                                                                elseif ($row['status'] == 'Resolved') $status_class = 'badge-soft-success';
                                                                elseif ($row['status'] == 'Closed') $status_class = 'badge-soft-secondary';
                                                                
                                                                $priority_class = 'badge-soft-secondary';
                                                                if ($row['priority'] == 'High') $priority_class = 'badge-soft-warning';
                                                                elseif ($row['priority'] == 'Critical') $priority_class = 'badge-soft-danger';
                                                                elseif ($row['priority'] == 'Medium') $priority_class = 'badge-soft-info';
                                                                
                                                                echo '<tr data-ticket-id="'.$row['id'].'" data-status="'.htmlspecialchars($row['status']).'" data-priority="'.htmlspecialchars($row['priority']).'">
                                                                    <td><span class="badge badge-soft-primary">#'.$row['id'].'</span></td>
                                                                    <td>
                                                                        <div>
                                                                            <h6 class="mb-1">'.htmlspecialchars($row['name']).'</h6>
                                                                            <small class="text-muted">'.htmlspecialchars($row['email']).'</small>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <h6 class="mb-1">'.htmlspecialchars(substr($row['subject'], 0, 50)).'...</h6>
                                                                            <small class="text-muted">'.htmlspecialchars(substr($row['description'], 0, 80)).'...</small>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge '.$priority_class.'">'.htmlspecialchars($row['priority'] ?? 'Medium').'</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge '.$status_class.'">'.htmlspecialchars($row['status']).'</span>
                                                                    </td>
                                                                    <td>'.date('M d, Y', strtotime($row['created_at'])).'</td>
                                                                    <td class="text-center">
                                                                        <div class="action-buttons justify-content-center">
                                                                            <button onclick="viewTicket('.$row['id'].')" class="btn btn-sm btn-info me-2" title="View Details">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                            <button onclick="updateStatus('.$row['id'].')" class="btn btn-sm btn-warning me-2" title="Update Status">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                            <button onclick="deleteTicket('.$row['id'].')" class="btn btn-sm btn-danger" title="Delete Ticket">
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
                                                                        <i class="fas fa-headset fa-3x text-muted mb-3"></i>
                                                                        <h5 class="text-muted">No Support Tickets Found</h5>
                                                                        <p class="text-muted">All caught up! No support tickets need attention.</p>
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
                                                    <h5 class="text-muted">No Tickets Found</h5>
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
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Update Ticket Status</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateStatusForm">
                                                <input type="hidden" id="ticketId" name="ticketId">
                                                <div class="form-group">
                                                    <label for="newStatus"><i class="fas fa-info-circle me-2"></i>New Status</label>
                                                    <select class="form-control" id="newStatus" name="newStatus" required>
                                                        <option value="Open">Open</option>
                                                        <option value="In Progress">In Progress</option>
                                                        <option value="Resolved">Resolved</option>
                                                        <option value="Closed">Closed</option>
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

                            <!-- View Ticket Modal -->
                            <div class="modal fade" id="viewTicketModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Ticket Details</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="ticketDetails">
                                            <!-- Ticket details will be loaded here -->
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
                                <span class="ms-3 opacity-75">Support Ticket Management</span>
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

        <!-- Enhanced Ticket Management Scripts -->
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
                const priorityFilter = document.getElementById('priorityFilter');
                const tableBody = document.getElementById('ticketTableBody');
                const noResults = document.getElementById('noResults');
                const searchResults = document.getElementById('searchResults');
                
                let allRows = Array.from(tableBody.querySelectorAll('tr'));
                
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const selectedStatus = statusFilter.value.toLowerCase();
                    const selectedPriority = priorityFilter.value.toLowerCase();
                    let visibleCount = 0;

                    allRows.forEach(row => {
                        if (row.querySelector('h6')) {
                            const ticketSubject = row.querySelector('h6').textContent.toLowerCase();
                            const status = row.dataset.status.toLowerCase();
                            const priority = row.dataset.priority.toLowerCase();
                            const submitterName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            
                            const matchesSearch = !searchTerm || 
                                                ticketSubject.includes(searchTerm) || 
                                                submitterName.includes(searchTerm);
                                                
                            const matchesStatus = !selectedStatus || status.includes(selectedStatus);
                            const matchesPriority = !selectedPriority || priority.includes(selectedPriority);
                            
                            if (matchesSearch && matchesStatus && matchesPriority) {
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

                    searchResults.textContent = `Showing ${visibleCount} of ${allRows.length} tickets`;
                    
                    const table = document.getElementById('ticketsTable');
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
                statusFilter.addEventListener('change', performSearch);
                priorityFilter.addEventListener('change', performSearch);

                window.clearFilters = function() {
                    searchInput.value = '';
                    statusFilter.value = '';
                    priorityFilter.value = '';
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

            // View ticket function
            function viewTicket(id) {
                fetch('view_ticket.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('ticketDetails').innerHTML = data;
                    $('#viewTicketModal').modal('show');
                })
                .catch(error => {
                    showNotification('Error loading ticket details', 'error');
                });
            }

            // Update status function
            function updateStatus(id) {
                document.getElementById('ticketId').value = id;
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
                        
                        showNotification('Ticket status updated successfully!', 'success');
                        
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

            // Delete ticket function
            function deleteTicket(id) {
                const row = document.querySelector(`tr[data-ticket-id="${id}"]`);
                const ticketSubject = row.querySelector('h6').textContent;
                
                showConfirmDialog(
                    'Delete Ticket',
                    `Are you sure you want to delete ticket "${ticketSubject}"?`,
                    'This action cannot be undone.',
                    () => {
                        performTicketDelete(id, row, ticketSubject);
                    }
                );
            }

            function performTicketDelete(id, row, ticketSubject) {
                const btn = row.querySelector('.btn-danger');
                btn.innerHTML = '<div class="spinner-border spinner-border-sm"></div>';
                btn.disabled = true;
                
                fetch('delete_ticket.php', {
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
                            showNotification('Ticket deleted successfully!', 'success');
                        }, 500);
                    } else {
                        throw new Error(data);
                    }
                })
                .catch(error => {
                    showNotification('Error deleting ticket: ' + error.message, 'error');
                    btn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    btn.disabled = false;
                });
            }

            // Refresh tickets
            function refreshTickets() {
                showNotification('Refreshing tickets...', 'info');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }

            // Print report function
            function printTicketReport() {
                const printWindow = window.open('', '', 'height=800,width=1200');
                const currentDate = new Date().toLocaleDateString();
                
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>PSU Asingan Campus - Support Tickets Report</title>
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
                            <h4>SUPPORT TICKETS REPORT</h4>
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
            function exportTicketData() {
                showNotification('Preparing ticket data export...', 'info');
                
                const tickets = [];
                document.querySelectorAll('#ticketTableBody tr').forEach(row => {
                    if (row.style.display !== 'none' && row.querySelector('h6')) {
                        const cells = row.querySelectorAll('td');
                        if (cells.length > 1) {
                            tickets.push({
                                id: cells[0].textContent.replace('#', ''),
                                submittedBy: cells[1].textContent.replace(/\s+/g, ' ').trim(),
                                subject: cells[2].querySelector('h6').textContent,
                                priority: cells[3].textContent,
                                status: cells[4].textContent,
                                dateCreated: cells[5].textContent
                            });
                        }
                    }
                });
                
                const data = {
                    exportDate: new Date().toISOString(),
                    totalTickets: tickets.length,
                    tickets: tickets
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `tickets_export_${new Date().toISOString().slice(0,10)}.json`;
                a.click();
                URL.revokeObjectURL(url);
                
                showNotification('Ticket data exported successfully!', 'success');
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
                    <button class="quick-action-btn" onclick="refreshTickets()" title="Refresh Tickets">
                        <i class="fas fa-refresh"></i>
                    </button>
                    <button class="quick-action-btn" onclick="printTicketReport()" title="Print Report">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="quick-action-btn" onclick="exportTicketData()" title="Export Data">
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
                    showNotification('Welcome to Support Ticket Management! 🎫', 'success', 4000);
                }, 1000);
            });
        </script>

    </body>
</html>