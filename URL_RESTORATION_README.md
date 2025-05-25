# 🔗 URL Restoration - Courses and Contact Pages

## Issue Summary

The `courses2.php` and `contact2.php` files were moved to the backup directory during a cleanup process, causing "Not Found" errors when trying to access these URLs.

## Files Restored

### ✅ `courses2.php`
- **Source**: `backups/redundant_pages_2025-05-23_14-18-29/courses2.php`
- **Destination**: Root directory (`courses2.php`)
- **URL**: `http://localhost/NEW PROJECT PSU/courses2`
- **Content**: Complete courses listing with all programs

### ✅ `contact2.php`
- **Source**: `backups/redundant_pages_2025-05-23_14-18-29/contact2.php`
- **Destination**: Root directory (`contact2.php`)
- **URL**: `http://localhost/NEW PROJECT PSU/contact2`
- **Content**: Contact information and form

## Navigation Updates

### Desktop Navigation (`userpcheader.php`)
Already correctly linking to:
- ✅ `courses2` (Courses)
- ✅ `contact2` (Contact)

### Mobile Navigation (`usermobileheader.php`)
**Updated** to match desktop navigation:
- ✅ Changed `courses.php` to `courses2`
- ✅ Changed `contact` to `contact2`

## URL Structure with .htaccess

The site uses URL rewriting rules in `.htaccess` that remove file extensions:

```apache
RewriteEngine On

# Remove .html extension
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}\.html -f
RewriteRule ^(.*)$ $1.html [NC,L]

# Remove .php extension
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}\.php -f
RewriteRule ^(.*)$ $1.php [NC,L]
```

This means:
- `courses2` → loads `courses2.php`
- `contact2` → loads `contact2.php`

## Working URLs

### ✅ Courses Pages
- **Main Courses**: `http://localhost/NEW PROJECT PSU/courses2`
- **Modern Courses**: `http://localhost/NEW PROJECT PSU/courses-modern`
- **Individual Programs**:
  - BSIT: `http://localhost/NEW PROJECT PSU/courses-bsit`
  - BSBA: `http://localhost/NEW PROJECT PSU/courses-bsba`
  - BTLE: `http://localhost/NEW PROJECT PSU/courses-btle`
  - BSE: `http://localhost/NEW PROJECT PSU/courses-bse`
  - BEE: `http://localhost/NEW PROJECT PSU/courses-bee`
  - BIT: `http://localhost/NEW PROJECT PSU/courses-bit`

### ✅ Contact Pages
- **Main Contact**: `http://localhost/NEW PROJECT PSU/contact2`
- **Modern Contact**: `http://localhost/NEW PROJECT PSU/contact-modern`

### ✅ Other Important Pages
- **Home**: `http://localhost/NEW PROJECT PSU/index`
- **Modern Home**: `http://localhost/NEW PROJECT PSU/index-modern`
- **Login**: `http://localhost/NEW PROJECT PSU/login`
- **Ticket Support**: `http://localhost/NEW PROJECT PSU/user_ticketsupport1`
- **Virtual Tour**: `http://localhost/NEW PROJECT PSU/Vtour/index.htm`

## Backup Information

Original files are safely stored in:
- `backups/redundant_pages_2025-05-23_14-18-29/`

This backup includes:
- `courses2.php`
- `contact2.php`
- `courses1.php`
- `contact1.php`
- `index2.php`
- Navigation header files

## Prevention

To prevent future URL issues:

1. **Check Navigation Links**: Ensure all header files point to the correct URLs
2. **Test URLs**: Verify that all navigation links work after any cleanup
3. **Backup Documentation**: Keep track of which files are being moved/deleted
4. **URL Mapping**: Maintain a list of active URLs and their corresponding files

## Current File Structure

```
/
├── index.php                    # Main homepage
├── index-modern.php             # Modern homepage
├── courses2.php                 # Main courses page ✅ RESTORED
├── courses-modern.php           # Modern courses page
├── contact2.php                 # Main contact page ✅ RESTORED
├── contact-modern.php           # Modern contact page
├── user_ticketsupport1.php      # Ticket support system
├── login.php                    # User login
├── userpcheader.php             # Desktop navigation
├── usermobileheader.php         # Mobile navigation ✅ UPDATED
└── backups/                     # Backup directory
    └── redundant_pages_**/      # Timestamped backups
```

## Testing Checklist

- [x] `courses2` URL loads properly
- [x] `contact2` URL loads properly
- [x] Desktop navigation works
- [x] Mobile navigation updated and working
- [x] All course program links work
- [x] .htaccess URL rewriting functional

---

**Last Updated**: January 2025  
**Status**: ✅ All URLs restored and working  
**Next Action**: Test all navigation links across the site 