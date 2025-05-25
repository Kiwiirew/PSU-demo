<?php
header('Content-Type: application/json');

if (!isset($_POST['abbr'])) {
    echo json_encode(['success' => false, 'message' => 'Course abbreviation not provided']);
    exit;
}

$course_abbr = $_POST['abbr'];
$course_file = "../courses-" . $course_abbr . ".php";
$courses_file = "../courses.php";

// Check if course file exists
if (!file_exists($course_file)) {
    echo json_encode(['success' => false, 'message' => 'Course file not found']);
    exit;
}

try {
    // Read course file content before deletion
    $content = file_get_contents($course_file);
    
    // Delete the course file
    if (!unlink($course_file)) {
        throw new Exception('Failed to delete course file');
    }
    
    // Delete course images
    if (preg_match('/src="assets\/images\/courses\/(.*?)"/', $content, $matches)) {
        $image_file = "../assets/images/courses/" . $matches[1];
        if (file_exists($image_file)) {
            unlink($image_file);
        }
    }
    
    // Delete instructor images
    if (preg_match_all('/src="assets\/images\/courses\/instructors\/(.*?)"/', $content, $matches)) {
        foreach ($matches[1] as $instructor_image) {
            $instructor_image_file = "../assets/images/courses/instructors/" . $instructor_image;
            if (file_exists($instructor_image_file)) {
                unlink($instructor_image_file);
            }
        }
    }
    
    // Update courses.php
    if (file_exists($courses_file)) {
        $courses_content = file_get_contents($courses_file);
        
        // Define the base structure
        $base_structure = '<div class="tab-pane fade show active" id="tabs1">' . "\n" .
                         '                    <div class="courses-wrapper">' . "\n" .
                         '                    <div class="row" style="justify-content: center;">';
        
        // Find and remove the specific course card
        $pattern = '/<div class="col-lg-4 col-md-6">\s*<div class="single-courses">[\s\S]*?href="courses-' . preg_quote($course_abbr) . '"[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/';
        $courses_content = preg_replace($pattern, '', $courses_content);
        
        // Fix the tab structure if it's broken
        if (strpos($courses_content, '<div class="courses-wrapper">') === false) {
            $tab_content_pos = strpos($courses_content, '<div class="tab-content courses-tab-content">');
            if ($tab_content_pos !== false) {
                $insert_pos = strpos($courses_content, '>', $tab_content_pos) + 1;
                $courses_content = substr_replace($courses_content, "\n" . $base_structure, $insert_pos, 0);
            }
        }
        
        // Clean up any malformed div structures
        $courses_content = preg_replace('/<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*(?=<div)/', "</div>\n                    </div>\n                    </div>\n", $courses_content);
        
        // Ensure proper closing of the course section
        if (substr_count($courses_content, '<div class="courses-wrapper">') > substr_count($courses_content, '</div>')) {
            $courses_content = preg_replace('/<\/div>\s*$/', "</div>\n                    </div>\n                    </div>\n", $courses_content);
        }
        
        // Clean up excessive whitespace while maintaining indentation
        $courses_content = preg_replace("/(\r?\n\s*){3,}/", "\n\n", $courses_content);
        
        // Write the updated content back
        if (file_put_contents($courses_file, $courses_content) === false) {
            throw new Exception('Failed to update courses.php');
        }
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log("Error deleting course: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
