# 🎫 PSU Ticket Support System - Enhanced Version

## Overview

The PSU Ticket Support System is a comprehensive support ticketing solution designed for Pangasinan State University Asingan Campus. This system allows students and faculty to submit technical support requests and enables administrators to efficiently manage and respond to these tickets.

## 🚀 Features

### User Features
- **Modern Dashboard Interface**: Clean, responsive design with PSU branding
- **Ticket Submission**: Easy-to-use form with validation
- **File Attachments**: Support for multiple file types (images, PDFs, documents)
- **Priority Levels**: Low, Medium, High, Critical priority options
- **Department Selection**: Specific department/program selection
- **Ticket History**: View all submitted tickets with status tracking
- **Real-time Updates**: Auto-refresh ticket status every 30 seconds
- **Mobile Responsive**: Works perfectly on all devices

### Admin Features
- **Comprehensive Dashboard**: Statistics and overview of all tickets
- **Advanced Search & Filtering**: Search by subject, description, status, priority
- **Status Management**: Update ticket status (Open, In Progress, Resolved, Closed)
- **Admin Response**: Add responses and notes to tickets
- **File Management**: View and download user-submitted attachments
- **Bulk Operations**: Print reports and export data
- **Quick Actions**: Floating action buttons for common tasks
- **Modern UI**: Enhanced interface matching the overall admin theme

## 📁 File Structure

```
/
├── user_ticketsupport1.php          # Main user interface for tickets
├── submit_ticket.php                # Handles ticket submission
├── setup_ticket_system.php          # Database setup script
├── Admin/
│   ├── ticketsupport.php           # Admin ticket management interface
│   ├── view_ticket.php             # Detailed ticket view (AJAX)
│   ├── update_status.php           # Handle status updates
│   ├── delete_ticket.php           # Handle ticket deletion
│   ├── admin_feedback.php          # Feedback management (enhanced)
│   └── assets/
│       └── css/
│           └── admin-modern.css    # Modern admin styling
└── uploads/
    └── tickets/                    # Uploaded attachments storage
```

## 🛠️ Installation & Setup

### 1. Run the Setup Script

Navigate to your website and run the setup script:
```
http://yoursite.com/setup_ticket_system.php
```

This script will:
- Create/update all necessary database tables
- Set up proper indexes for performance
- Create upload directories
- Add sample data for testing
- Verify table structures

### 2. Database Tables Created

#### `tickets` Table
- **id**: Auto-increment primary key
- **user_id**: Links to user session
- **name**: User's full name
- **email**: User's email address
- **subject**: Ticket subject/title
- **description**: Detailed issue description
- **priority**: Low, Medium, High, Critical
- **department**: User's department/program
- **status**: Open, In Progress, Resolved, Closed
- **attachments**: JSON array of uploaded files
- **admin_response**: Admin's response/notes
- **created_at**: Ticket creation timestamp
- **updated_at**: Last modification timestamp
- **resolved_at**: Resolution timestamp

#### `ticket_logs` Table
- **id**: Log entry ID
- **ticket_id**: Reference to ticket
- **action**: Type of action performed
- **details**: JSON details of the action
- **admin_id**: Admin who performed action
- **created_at**: Action timestamp

#### `feedback` Table (Enhanced)
- Enhanced with status tracking and admin responses
- Compatible with existing feedback system

### 3. File Permissions

Ensure proper permissions for upload directories:
```bash
chmod 755 uploads/
chmod 755 uploads/tickets/
chmod 755 uploads/feedback/
```

## 🎨 Features in Detail

### User Interface Enhancements

#### Modern Design
- **PSU Color Scheme**: Blue (#0A27D8) and Yellow (#FFE047)
- **Inter Font**: Modern Google Font for better readability
- **Card-based Layout**: Clean, organized information display
- **Smooth Animations**: Fade-in effects and transitions

#### Ticket Submission Form
- **Real-time Validation**: Client-side form validation
- **File Upload**: Drag-and-drop or click to upload
- **Priority Selection**: Visual priority indicators
- **Department Dropdown**: All PSU programs included
- **Loading States**: Visual feedback during submission

#### Ticket History
- **Status Badges**: Color-coded status indicators
- **Priority Badges**: Visual priority levels
- **Expandable Cards**: Hover effects and interactions
- **Date Formatting**: User-friendly date display

### Admin Interface Enhancements

#### Dashboard Statistics
- **Live Counters**: Animated number counting
- **Status Breakdown**: Total, Open, In Progress, Resolved tickets
- **Visual Cards**: Modern card design with icons

#### Advanced Search
- **Multi-field Search**: Subject, description, user name
- **Filter Options**: Status and priority filtering
- **Real-time Results**: Instant search as you type
- **Search Highlighting**: Matched terms highlighted

#### Ticket Management
- **Detailed View**: Comprehensive ticket information modal
- **Status Updates**: Quick status change with admin response
- **File Handling**: View/download attachments with icons
- **Action Buttons**: Edit, delete, view with confirmation dialogs

#### Reporting Features
- **Print Reports**: Professional PSU-branded printouts
- **Data Export**: JSON format data export
- **Bulk Operations**: Handle multiple tickets efficiently

## 🔧 Configuration Options

### Email Notifications (Optional)
You can implement email notifications by editing the `sendTicketNotification()` function in `submit_ticket.php`:

```php
function sendTicketNotification($ticketData) {
    $adminEmail = "admin@psu.edu.ph";
    $subject = "New Ticket Submitted: " . $ticketData['subject'];
    $message = "A new ticket has been submitted...\n\n";
    // Add your email sending code here
    mail($adminEmail, $subject, $message);
    return true;
}
```

### File Upload Limits
Modify upload limits in `submit_ticket.php`:

```php
$maxFileSize = 10 * 1024 * 1024; // 10MB default
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
```

### Session Configuration
The system integrates with your existing session management:
- Uses `$_SESSION['user_id']`, `$_SESSION['user_email']`, `$_SESSION['user_name']`
- Requires `session_check.php` for authentication

## 🔒 Security Features

### Input Validation
- **Server-side Validation**: All inputs validated and sanitized
- **File Type Checking**: Only allowed file types accepted
- **SQL Injection Prevention**: Prepared statements used throughout
- **XSS Protection**: All outputs properly escaped

### File Security
- **Unique Filenames**: Prevents file overwrites and conflicts
- **Directory Structure**: Organized upload storage
- **File Size Limits**: Prevents resource exhaustion
- **Type Verification**: MIME type checking

### Access Control
- **Authentication Required**: Users must be logged in
- **Session Validation**: Proper session management
- **Admin Separation**: Admin functions require admin access

## 📱 Mobile Responsiveness

The system is fully responsive and works on:
- **Desktop**: Full-featured interface
- **Tablets**: Optimized layout
- **Mobile Phones**: Touch-friendly navigation
- **Small Screens**: Simplified layout for better usability

## 🎯 Usage Examples

### For Students/Faculty
1. **Login** to the PSU system
2. **Navigate** to Ticket Support
3. **Click** "Submit New Ticket"
4. **Fill out** the form with issue details
5. **Upload** screenshots or documents if needed
6. **Select** priority and department
7. **Submit** and track progress

### For Administrators
1. **Access** Admin Dashboard
2. **View** all tickets in the support interface
3. **Filter** by status, priority, or search terms
4. **Click** on a ticket to view details
5. **Update** status and add responses
6. **Print** reports or export data as needed

## 🚨 Troubleshooting

### Common Issues

#### Upload Errors
- Check directory permissions (755 or 775)
- Verify PHP upload limits in php.ini
- Ensure adequate disk space

#### Database Errors
- Run setup script to ensure proper table structure
- Check database connection settings
- Verify user privileges

#### Session Issues
- Ensure session_start() is called
- Check session configuration
- Verify user authentication flow

## 🔄 Updates and Maintenance

### Regular Maintenance
- **Clean up old files**: Remove old uploaded files periodically
- **Database optimization**: Run OPTIMIZE TABLE commands
- **Log rotation**: Archive old ticket logs
- **Backup**: Regular database and file backups

### Adding Features
The system is designed to be extensible:
- Add new status types in ENUM definitions
- Extend ticket fields as needed
- Add notification channels (SMS, Slack, etc.)
- Implement assignment to specific admins

## 📞 Support

For technical support or questions about this system:
- **Developer**: PSU IT Team
- **Documentation**: This README file
- **Database Setup**: `setup_ticket_system.php`
- **Version**: 2.0 Professional Interface

## 🎉 Conclusion

This enhanced ticket support system provides a professional, user-friendly experience for both students/faculty and administrators. The modern interface, comprehensive features, and robust security make it an ideal solution for PSU Asingan Campus support needs.

The system integrates seamlessly with the existing PSU infrastructure while providing advanced functionality for efficient ticket management and resolution. 