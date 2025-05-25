<?php
include "db_conn.php";
 
$id = $_POST['id'];
 
$sql = "SELECT * FROM tickets WHERE id=".$id;
$result = mysqli_query($conn,$sql);
while( $row = mysqli_fetch_array($result) ){
    // Decode the JSON array of image paths
    $screenshots = json_decode($row['screenshot'], true);
?>
<table border='0' width='100%'>
<tr>
    <td style="padding:20px;">
        <p>FirstName : <?php echo $row['first_name']; ?></p>
        <p>Last Name : <?php echo $row['last_name']; ?></p>
        <p>Email : <?php echo $row['email']; ?></p>
        <p>Department : <?php echo $row['department']; ?></p>
        <p>Computer ID : <?php echo $row['id']; ?></p>
        <p>Description : <?php echo $row['description']; ?></p>
        
        <!-- Image Gallery -->
        <div class="image-gallery" style="margin-top: 20px;">
            <?php
            if (is_array($screenshots) && !empty($screenshots)) {
                foreach ($screenshots as $screenshot) {
                    if (!empty($screenshot)) {
                        echo "<img src='../uploads/" . htmlspecialchars($screenshot) . "' 
                              class='gallery-img' 
                              style='width: 150px; height: auto; margin: 5px; cursor: pointer; border: 1px solid #ddd; padding: 5px;' 
                              onclick='openFullscreen(this.src)'>";
                    }
                }
            } else if (!empty($row['screenshot'])) {
                // Fallback for single image
                echo "<img src='../uploads/" . htmlspecialchars($row['screenshot']) . "' 
                      class='gallery-img' 
                      style='width: 150px; height: auto; margin: 5px; cursor: pointer; border: 1px solid #ddd; padding: 5px;' 
                      onclick='openFullscreen(this.src)'>";
            }
            ?>
        </div>

        <!-- Respond Button -->
        <div style="margin-top: 20px; text-align: right;">
            <button onclick="composeEmail('<?php echo htmlspecialchars($row['email']); ?>', 
                                        '<?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>', 
                                        '<?php echo htmlspecialchars($row['description']); ?>')" 
                    class="btn btn-primary">
                <i class="fas fa-reply"></i> Respond
            </button>
        </div>
    </td>
</tr>
</table>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); z-index: 1000;">
    <span class="close-modal" onclick="closeFullscreen()" style="position: absolute; right: 35px; top: 15px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="fullscreenImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; position: relative; top: 50%; transform: translateY(-50%);">
</div>

<script>
function openFullscreen(imgSrc) {
    const modal = document.getElementById('fullscreenModal');
    const modalImg = document.getElementById('fullscreenImage');
    modal.style.display = "block";
    modalImg.src = imgSrc;
}

function closeFullscreen() {
    document.getElementById('fullscreenModal').style.display = "none";
}

// Close modal when clicking outside the image
document.getElementById('fullscreenModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFullscreen();
    }
});

function composeEmail(email, name, description) {
    // Create the email subject
    const subject = `Re: IT Support Ticket - ${name}`;
    
    // Create the email body with the original message quoted
    const body = `\n\n----------\nOriginal Message:\n${description}`;
    
    // Create the Gmail compose URL
    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(email)}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    
    // Open Gmail in a new window
    window.open(gmailUrl, '_blank');
}
</script>
 
<?php } ?>