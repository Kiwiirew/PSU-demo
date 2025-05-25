<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: index.php");
    exit();
}

?>

<div class="left side-menu">
                <button type="button"  style="background: #FFAA17" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close" style="color: "></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center bg-logo">
                        <!-- <a href="index.html" class="logo"><i class="mdi mdi-bowling text-success"></i> SUPERADMIN</a> -->
                        <!-- <a href="index.html" class="logo"><img src="assets/images/logo.png" height="24" alt="logo"></a> -->
                    </div>
                </div>
                <div class="sidebar-user">
                    <img src="assets/images/logo.jpg" alt="user" class="rounded-circle img-thumbnail mb-1">
                    <h6 class="">PSU ASINGAN CAMPUS<br>ADMIN DASHBOARD</h6> 
              
                </div>

                <div class="sidebar-inner slimscrollleft">

                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Navigations</li>

                         
                            <li>
                                <a href="dashboard" class="waves-effect"><i class="dripicons-home"></i><span> Dashboard </span></a>
                            </li>


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-jewel"></i> <span> Teachers</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                   <ul class="list-unstyled">
                                    <li><a href="teachers">All teachers</a></li>
                                    <!-- <li><a href="walapa">Add teachers</a></li> -->
                                    

                                                                     
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-jewel"></i> <span> Students/ classes</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                   <ul class="list-unstyled">
                                    <li><a href="students">All students</a></li>
                                                                   
                                </ul>
                            </li>
                             <li>
                                <a href="courses" class="waves-effect"><i class="dripicons-jewel"></i><span> Courses</span></a>
                            </li>
                            
                             <li>
                                <a href="ticketsupport" class="waves-effect"><i class="dripicons-jewel"></i><span> Ticket and Support </span></a>
                            </li>

                            <li>
                                <a href="admin_feedback" class="waves-effect"><i class="dripicons-jewel"></i><span> Feedback</span></a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" onclick="backupDatabase()" class="waves-effect">
                                    <i class="fas fa-database"></i><span> Backup Database </span>
                                </a>
                            </li>

                            <li>
                                <a href="logout" class="waves-effect"><i class="mdi mdi-logout m-r-5 text-muted"></i><span> Logout</span></a>
                            </li>






                           
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> 
            </div>

<script>
function backupDatabase() {
    if (confirm('Do you want to backup the database?')) {
        // Show loading indicator
        document.body.style.cursor = 'wait';
        
        fetch('backup_db.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Backup failed');
                }
                return response.blob();
            })
            .then(blob => {
                // Create download link
                const date = new Date().toISOString().slice(0,19).replace(/[:]/g, '-');
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `database_backup_${date}.sql`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                // Show success message
                alert('Database backup completed successfully!');
            })
            .catch(error => {
                alert('Error creating backup: ' + error.message);
            })
            .finally(() => {
                document.body.style.cursor = 'default';
            });
    }
}
</script>