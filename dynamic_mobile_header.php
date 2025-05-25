<?php
// Include session manager
require_once 'session_manager.php';

// Get navigation menu and auth buttons based on login status
$navigationMenu = SessionManager::getNavigationMenu();
$authButtons = SessionManager::getAuthButtons();
?>

<div class="header-mobile d-lg-none">
    <div class="container">
        <div class="header-mobile-wrapper">
            
            <!-- Mobile Logo -->
            <div class="header-mobile-logo">
                <a href="index.php">
                    <img src="assets/images/logo.jpg" alt="PSU Logo">
                </a>
            </div>
            
            <!-- Mobile User Info (for logged in users) -->
            <?php if ($authButtons['type'] === 'logged_in'): ?>
                <div class="mobile-user-display">
                    <span class="mobile-user-name">
                        <i class="icofont-user-alt-3"></i>
                        <?php echo htmlspecialchars($authButtons['user_name']); ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <!-- Mobile Menu -->
            <div class="header-mobile-menu">
                <!-- User Status -->
                <?php if ($authButtons['type'] === 'logged_in'): ?>
                    <div class="mobile-user-info">
                        <span class="mobile-welcome">
                            <i class="icofont-user-alt-3"></i>
                            Welcome, <?php echo htmlspecialchars($authButtons['user_name']); ?>!
                        </span>
                    </div>
                <?php endif; ?>
                
                <!-- Navigation Links -->
                <ul class="mobile-nav-menu">
                    <?php foreach ($navigationMenu as $menuItem): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($menuItem['url']); ?>">
                                <?php echo htmlspecialchars($menuItem['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <!-- Auth Buttons -->
                <div class="mobile-auth-buttons">
                    <?php if ($authButtons['type'] === 'logged_in'): ?>
                        <a class="mobile-logout-btn" href="<?php echo $authButtons['logout_url']; ?>">
                            <i class="icofont-logout"></i> Log Out
                        </a>
                    <?php else: ?>
                        <a class="mobile-sign-in" href="<?php echo $authButtons['login_url']; ?>">
                            <i class="icofont-login"></i> Sign In
                        </a>
                        <a class="mobile-sign-up" href="<?php echo $authButtons['register_url']; ?>">
                            <i class="icofont-user-plus"></i> Sign Up
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Mobile Styles -->
<style>
.header-mobile {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 10px 0;
}

.header-mobile-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-mobile-logo img {
    height: 40px;
    width: auto;
}

.mobile-user-display {
    flex: 1;
    text-align: center;
    margin: 0 10px;
}

.mobile-user-name {
    color: #0A27D8;
    font-weight: 600;
    font-size: 0.9rem;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    padding: 5px 10px;
    border-radius: 15px;
    border: 1px solid #e9ecef;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
    display: inline-block;
}

.mobile-user-info {
    text-align: center;
    margin-bottom: 20px;
    padding: 15px;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border-radius: 10px;
}

.mobile-welcome {
    color: #0A27D8;
    font-weight: 600;
    font-size: 1rem;
}

.mobile-nav-menu {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.mobile-nav-menu li {
    margin-bottom: 10px;
}

.mobile-nav-menu li a {
    display: block;
    padding: 15px 20px;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.mobile-nav-menu li a:hover {
    background: #e9ecef;
    border-left-color: #0A27D8;
    color: #0A27D8;
    transform: translateX(5px);
}

.mobile-auth-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 20px;
}

.mobile-logout-btn {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    font-weight: 600;
}

.mobile-logout-btn:hover {
    background: linear-gradient(45deg, #c82333, #bd2130);
    transform: translateY(-2px);
    color: white;
}

.mobile-sign-in {
    background: linear-gradient(45deg, #0A27D8, #1e40af);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    font-weight: 600;
}

.mobile-sign-in:hover {
    background: linear-gradient(45deg, #1e40af, #3b82f6);
    transform: translateY(-2px);
    color: white;
}

.mobile-sign-up {
    background: linear-gradient(45deg, #FFE047, #FFB800);
    color: #000;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    font-weight: 600;
}

.mobile-sign-up:hover {
    background: linear-gradient(45deg, #FFB800, #FF8C00);
    transform: translateY(-2px);
    color: #000;
}

/* Mobile Menu Toggle */
.header-mobile-menu {
    position: fixed;
    top: 0;
    left: -100%;
    width: 280px;
    height: 100vh;
    background: white;
    z-index: 9999;
    transition: all 0.3s ease;
    overflow-y: auto;
    padding: 80px 0 20px 0;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}

.header-mobile-menu.active {
    left: 0;
}

/* Overlay for mobile menu */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Close button for mobile menu */
.mobile-menu-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    font-size: 24px;
    color: #666;
    cursor: pointer;
}
</style>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- JavaScript for Mobile Menu -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.header-mobile-menu');
    const overlay = document.getElementById('mobileMenuOverlay');
    
    // Add close button to mobile menu
    const closeBtn = document.createElement('button');
    closeBtn.className = 'mobile-menu-close';
    closeBtn.innerHTML = '&times;';
    mobileMenu.insertBefore(closeBtn, mobileMenu.firstChild);
    
    function openMobileMenu() {
        mobileMenu.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', openMobileMenu);
    }
    
    closeBtn.addEventListener('click', closeMobileMenu);
    overlay.addEventListener('click', closeMobileMenu);
    
    // Close menu when clicking on nav links
    const navLinks = mobileMenu.querySelectorAll('.mobile-nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
});
</script> 