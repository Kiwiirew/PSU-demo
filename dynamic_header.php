<?php
// Include session manager
require_once 'session_manager.php';

// Get navigation menu and auth buttons based on login status
$navigationMenu = SessionManager::getNavigationMenu();
$authButtons = SessionManager::getAuthButtons();
$userGreeting = SessionManager::getUserGreeting();
?>

<div class="header-section">
    <div class="header-main">
        <div class="container">
            <div class="header-main-wrapper" style="background: white;">
                
                <!-- Logo -->
                <div class="header-logo">
                    <a href="index.php">
                        <img src="assets/images/fulllogo.png" style="width:200px;" alt="PSU Logo">
                    </a>
                </div>
                
                <!-- Desktop Navigation Menu -->
                <div class="header-menu d-none d-lg-block">
                    <ul class="nav-menu">
                        <?php foreach ($navigationMenu as $menuItem): ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($menuItem['url']); ?>">
                                    <?php echo htmlspecialchars($menuItem['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Authentication Buttons -->
                <div class="header-sign-in-up d-none d-lg-block">
                    <?php if ($authButtons['type'] === 'logged_in'): ?>
                        <!-- Logged in user -->
                        <div class="user-info-wrapper">
                            <div class="user-greeting">
                                <span class="welcome-text">
                                    <i class="icofont-user-alt-3"></i>
                                    <?php echo htmlspecialchars($authButtons['user_name']); ?>
                                </span>
                            </div>
                            <div class="logout-wrapper">
                                <a class="logout-btn" href="<?php echo $authButtons['logout_url']; ?>">
                                    <i class="icofont-logout"></i> Log Out
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Guest user -->
                        <ul class="auth-buttons-list">
                            <li>
                                <a class="sign-in" href="<?php echo $authButtons['login_url']; ?>">
                                    <i class="icofont-login"></i> Sign In
                                </a>
                            </li>
                            <li>
                                <a class="sign-up" href="<?php echo $authButtons['register_url']; ?>">
                                    <i class="icofont-user-plus"></i> Sign Up
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <div class="header-toggle d-lg-none">
                    <a class="menu-toggle" href="javascript:void(0)">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Styles for Dynamic Header -->
<style>
.user-info-wrapper {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-greeting {
    display: flex;
    align-items: center;
}

.welcome-text {
    color: #0A27D8;
    font-weight: 600;
    padding: 8px 15px;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border-radius: 25px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    white-space: nowrap;
    font-size: 0.95rem;
}

.welcome-text:hover {
    background: linear-gradient(45deg, #e9ecef, #dee2e6);
    transform: translateY(-2px);
}

.logout-wrapper {
    display: flex;
    align-items: center;
}

.logout-btn {
    background: linear-gradient(45deg, #dc3545, #c82333) !important;
    color: white !important;
    padding: 8px 20px;
    border-radius: 25px;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    white-space: nowrap;
    font-size: 0.95rem;
    font-weight: 600;
}

.logout-btn:hover {
    background: linear-gradient(45deg, #c82333, #bd2130) !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    color: white !important;
}

.auth-buttons-list {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sign-in {
    background: linear-gradient(45deg, #0A27D8, #1e40af);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    transition: all 0.3s ease;
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}

.sign-in:hover {
    background: linear-gradient(45deg, #1e40af, #3b82f6);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(10, 39, 216, 0.3);
    color: white;
}

.sign-up {
    background: linear-gradient(45deg, #FFE047, #FFB800);
    color: #000;
    padding: 8px 20px;
    border-radius: 25px;
    transition: all 0.3s ease;
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}

.sign-up:hover {
    background: linear-gradient(45deg, #FFB800, #FF8C00);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 224, 71, 0.3);
    color: #000;
}

.nav-menu li a {
    transition: all 0.3s ease;
    padding: 10px 15px;
    border-radius: 5px;
}

.nav-menu li a:hover {
    background: rgba(10, 39, 216, 0.1);
    color: #0A27D8;
}

/* Mobile Responsive */
@media (max-width: 1199px) {
    .header-main-wrapper {
        padding: 10px 15px;
        gap: 10px;
    }
    
    .header-logo img {
        width: 150px !important;
    }
    
    .user-info-wrapper {
        gap: 8px;
    }
    
    .welcome-text {
        padding: 6px 12px;
        font-size: 0.9rem;
    }
    
    .logout-btn {
        padding: 6px 15px;
        font-size: 0.9rem;
    }
}

@media (max-width: 991px) {
    .header-main-wrapper {
        justify-content: space-between;
    }
}
</style> 