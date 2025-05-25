<?php
include 'db_conn.php'; 

$sql = "SELECT COUNT(*) as count FROM students";
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
        <title>Student Management - PSU ASINGAN CAMPUS</title>
        <meta content="Admin Dashboard - Student Management" name="description" />
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

    
 <!-- oncontextmenu="return false" -->
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

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('leftnavbar.php') ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                   
                    <?php include('topnavbar.php') ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper">

                        <div class="container-fluid"  style="padding-top:30px;">

                        
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                
                                        <div class="card-body">
                                           <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <!-- Title -->
                    <h5 class="text-center header-title pb-3 mt-0">All Students (<span style="color:#0A27D8"><?php echo $count; ?></span>)</h5>
                    
                    <!-- Right-aligned elements for desktop, centered for mobile -->
                    <div class="d-flex flex-column flex-md-row align-items-md-center mt-3 mt-md-0">
                        <!-- Button and input container -->
                        <div class="text-center text-md-end" style="margin-right: 10px;">
                            <button class="btn btn-primary me-md-2 mb-2 mb-md-0" data-toggle="modal" data-target="#newStudentModal">Add New Student</button>
                            <button class="btn btn-success me-md-2 mb-2 mb-md-0" onclick="printReport()">Print Report</button>
                        </div>


                        <div class="modal fade" id="newStudentModal" tabindex="-1" role="dialog" aria-labelledby="newStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newStudentModalLabel">Add New Student</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="newStudentForm" action="add_students.php" method="POST">
                                            <div class="form-group">
                                                <label for="studentName">Full Name</label>
                                                <input type="text" class="form-control" id="studentName" name="studentName"  required>
                                            </div>
                                     
                                            <div class="form-group">
                                                <label for="studentEmail">Email Address</label>
                                                <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="studentGender">Gender</label>
                                                <select class="form-control" id="studentGender" name="studentGender" required>
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="studentProgram">Bachelor Program</label>
                                                <select class="form-control" id="studentProgram" name="studentProgram" required>
                                                    <option value="" disabled selected>Select Program</option>
                                                    <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                                                    <option value="Bachelor of Industrial Technology (BIT)">Bachelor of Industrial Technology (BIT)</option>
                                                    <option value="Bachelor of Science in Business Administration (BSBA)"> Bachelor of Science in Business Administration (BSBA)</option>
                                                    <option value="Bachelor of Technology and Livelihood Education (BTLE)">Bachelor of Technology and Livelihood Education (BTLE)</option>
                                                    <option value="Bachelor of Elementary Education (BEE)">Bachelor of Elementary Education (BEE)</option>
                                                    <option value="Bachelor of Secondary Education (BSE)">Bachelor of Secondary Education (BSE)</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="studentBirthdate">Birthdate</label>
                                                <input type="date" class="form-control" id="studentBirthdate" name="studentBirthdate" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="studentAge">Age</label>
                                                <input type="number" class="form-control" id="studentAge" name="studentAge" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="studentAddress">Address</label>
                                                <input type="text" class="form-control" id="studentAddress" name="studentAddress" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="studentPhone">Phone Number</label>
                                                <input type="text" class="form-control" id="studentPhone" name="studentPhone" required>
                                            </div>
                                            <button type="submit" id="submitButton" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form id="editStudentForm" action="update_student.php" method="POST">
                                        <input type="hidden" id="editStudentID" name="studentID">
                                        <div class="form-group">
                                            <label for="editStudentName">Full Name</label>
                                            <input type="text" class="form-control" id="editStudentName" name="studentName" >
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentEmail">Email Address</label>
                                            <input type="email" class="form-control" id="editStudentEmail" name="studentEmail" >
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentGender">Gender</label>
                                            <select class="form-control" id="editStudentGender" name="studentGender" >
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentBirthdate">Birthdate</label>
                                            <input type="date" class="form-control" id="editStudentBirthdate" name="studentBirthdate" >
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentAge">Age</label>
                                            <input type="number" class="form-control" id="editStudentAge" name="studentAge" >
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentProgram">Bachelor Program</label>
                                            <select class="form-control" id="editStudentProgram" name="studentProgram" >
                                            <option value="" disabled selected>Select Program</option>
                                                    <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                                                    <option value="Bachelor of Industrial Technology (BIT)">Bachelor of Industrial Technology (BIT)</option>
                                                    <option value="Bachelor of Science in Business Administration (BSBA)"> Bachelor of Science in Business Administration (BSBA)</option>
                                                    <option value="Bachelor of Technology and Livelihood Education (BTLE)">Bachelor of Technology and Livelihood Education (BTLE)</option>
                                                    <option value="Bachelor of Elementary Education (BEE)">Bachelor of Elementary Education (BEE)</option>
                                                    <option value="Bachelor of Secondary Education (BSE)">Bachelor of Secondary Education (BSE)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentAddress">Address</label>
                                            <input type="text" class="form-control" id="editStudentAddress" name="studentAddress" >
                                        </div>
                                        <div class="form-group">
                                            <label for="editStudentPhoneNumber">Phone Number</label>
                                            <input type="text" class="form-control" id="editStudentPhoneNumber" name="studentPhoneNumber">
                                        </div>

                                        <button type="submit" id="submitButton" class="btn btn-primary">Save Changes</button>
                                    </form>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="text-center text-md-end" style="margin: auto;">
                            <input type="text" id="searchInput" class="form-control" autocomplete="off" placeholder="Search Here" style="max-width: 200px;">
                        </div>
                    </div>
                </div>
                                            <div class="table-responsive" style="margin-top: 20px;">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr class="align-self-center">
                                                            <th>Full Name</th>
                                                            <th>Email Address</th>
                                                            <th>Gender</th>
                                                            <th>Bachelor Program</th>
                                                            <th>Phone Number</th>
                                                            <th>Birthdate</th>
                                                            <th>Age</th>
                                                            <th>Address</th>
                                                            <th>Actions</th>                                                                                  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        include 'db_conn.php';
                                                         
                                                        // Fetch student data along with BachelorProgram from the courses table via enrollment table
                                                        $sql = "SELECT * FROM students";
                                                        $result = $conn->query($sql);
                                                        
                                                        if ($result === false) {
                                                            echo "Error: " . $conn->error;
                                                        } elseif ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<tr>';
                                                                echo '<td><img src="assets/images/student.png" alt="" class="rounded-circle thumb-sm mr-1"> ' . htmlspecialchars($row['FullName']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['EmailAddress']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['Gender']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['BachelorProgram']) . '</td>';  // Display the Bachelor Program
                                                                echo '<td>' . htmlspecialchars($row['PhoneNumber']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['Birthdate']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['Age']) . '</td>';
                                                                echo '<td>' . htmlspecialchars($row['Address']) . '</td>';
                                                                echo '<td>';
                                                                echo '<div class="d-flex">';
                                                                echo '<button type="button" class="edit-button btn btn-sm" style="margin:5px;background:#FFD500" data-toggle="modal" data-target="#editStudentModal" onclick="editStudent(' . $row['StudentID'] . ')"><i class="fas fa-edit"></i> Edit</button>';
                                                                echo '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRecord(' . $row['StudentID'] . ')"><i class="fas fa-trash-alt"></i></button>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                echo '</tr>';
                                                            }
                                                        } else {
                                                            echo '<tr><td colspan="9">No students found</td></tr>';
                                                        }
                                                    ?>

                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                           
                                        </div>
                                    </div>                                                                   
                                </div> 
                            </div>
                            <!-- end row -->
                            
                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    © 2024 PSU ASINGAN CAMPUS
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
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

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('datatable');
    const tableRows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    searchInput.addEventListener('input', function() {
        const query = searchInput.value.toLowerCase();
        
        Array.from(tableRows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            let match = false;
            
            Array.from(cells).forEach(cell => {
                if (cell.textContent.toLowerCase().includes(query)) {
                    match = true;
                }
            });
            
            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
    });
});

function deleteRecord(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        fetch('delete_students1.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(responseText => {
            if (responseText.trim() === 'success') {
                alert('Record deleted successfully');
                location.reload(); // Reload to update the table
            } else {
                alert('Error deleting record: ' + responseText);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete record.');
        });
    }
}

function editStudent(studentID) {
    // Make an AJAX request to fetch student data by ID
    $.ajax({
        url: 'get_student.php', // Create this PHP script to fetch student data by ID
        type: 'POST',
        data: { studentID: studentID },
        success: function(response) {
            // Parse the JSON response
            let student = JSON.parse(response);

            // Populate the modal fields with the student's current data
            $('#editStudentID').val(student.StudentID);
            $('#editStudentName').val(student.FullName);
            $('#editStudentEmail').val(student.EmailAddress);
            $('#editStudentAge').val(student.Age);
            $('#editStudentGender').val(student.Gender);
            $('#editStudentAddress').val(student.Address);
            $('#editStudentPhoneNumber').val(student.PhoneNumber);
            // Add more fields as needed
        }
    });
}

$('#editStudentForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    console.log("Form submitted!");  // Log form submission

    // Disable the submit button to prevent multiple submissions
    $('#submitButton').prop('disabled', true);

    $.ajax({
        url: 'update_student.php', // PHP file that handles the update
        method: 'POST',
        data: $(this).serialize(), // Serialize form data, including the phone number
        success: function(response) {
            console.log(response);  // Log the response from the PHP backend to the console
            let res = JSON.parse(response); // Parse the JSON response

            // Check the response and show appropriate alert
            if (res.success) {
                alert('Student record updated successfully!');
                location.reload(); // Optionally reload the page to see the updated data
            } else {
                alert('Error: ' + res.error);
            }

            // Re-enable the submit button after the request
            $('#submitButton').prop('disabled', false);
        },
        error: function(xhr, status, error) {
            // Handle any error in the AJAX request
            alert('An error occurred while updating the student: ' + error);

            // Re-enable the submit button in case of error
            $('#submitButton').prop('disabled', false);
        }
    });
});

function printReport() {
    // Fetch all table data
    const table = document.getElementById('datatable');
    if (!table) {
        console.error('Table not found');
        return;
    }

    const rows = Array.from(table.querySelectorAll('tbody tr'));
    if (rows.length === 0) {
        alert('No data to print');
        return;
    }
    
    // Group students by program
    const programGroups = {};
    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        if (cells.length >= 8) {  // Make sure we have enough cells
            const program = cells[3].textContent.trim(); // Bachelor Program is in 4th column
            if (!programGroups[program]) {
                programGroups[program] = [];
            }
            programGroups[program].push({
                name: cells[0].textContent.trim().replace(/^.*?\s(.*)$/, '$1'), // Remove the image text
                email: cells[1].textContent.trim(),
                gender: cells[2].textContent.trim(),
                phone: cells[4].textContent.trim(),
                birthdate: cells[5].textContent.trim(),
                age: cells[6].textContent.trim(),
                address: cells[7].textContent.trim()
            });
        }
    });

    // Create print window
    const printWindow = window.open('', '_blank');
    
    // Create print content
    let printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Student Report - PSU ASINGAN CAMPUS</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
                th { background-color: #f2f2f2; }
                h1 { text-align: center; color: #333; }
                h2 { margin-top: 20px; color: #333; font-size: 18px; }
                .program-section { margin-bottom: 30px; }
                .report-header { text-align: center; margin-bottom: 30px; }
                .date-generated { text-align: right; margin-bottom: 20px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="report-header">
                <h1>PSU ASINGAN CAMPUS</h1>
                <h2>Student Report</h2>
            </div>
            <div class="date-generated">
                <p>Date Generated: ${new Date().toLocaleDateString()}</p>
            </div>
    `;

    // Add each program section
    for (const program in programGroups) {
        printContent += `
            <div class="program-section">
                <h2>${program}</h2>
                <p>Total Students: ${programGroups[program].length}</p>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Birthdate</th>
                            <th>Age</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        programGroups[program].forEach(student => {
            printContent += `
                <tr>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.gender}</td>
                    <td>${student.phone}</td>
                    <td>${student.birthdate}</td>
                    <td>${student.age}</td>
                    <td>${student.address}</td>
                </tr>
            `;
        });

        printContent += `
                    </tbody>
                </table>
            </div>
        `;
    }

    // Close the HTML structure
    printContent += `
            <div class="no-print">
                <button onclick="window.print()">Print Report</button>
            </div>
        </body>
        </html>
    `;

    // Write to the new window and trigger print
    printWindow.document.write(printContent);
    printWindow.document.close();
}

</script>

        

    </body>
</html>