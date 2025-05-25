// Modern Animations and Interactions

document.addEventListener('DOMContentLoaded', function() {
    
    // Enhanced loading animation with PSU logo
    const loadingContainer = document.querySelector('.loading-container');
    if (loadingContainer) {
        // Create the loading content with PSU logo
        loadingContainer.innerHTML = `
            <div class="loading-content">
                <img src="assets/images/logotitle.png" alt="PSU Logo" class="loading-logo">
                <div class="loading-text">Pangasinan State University</div>
                <div class="loading-subtitle">Loading Virtual Tour System...</div>
                <div class="loading-progress">
                    <div class="loading-progress-bar"></div>
                </div>
            </div>
        `;
        
        setTimeout(() => {
            loadingContainer.style.opacity = '0';
            setTimeout(() => {
                loadingContainer.style.display = 'none';
            }, 500);
        }, 2500); // Increased time to show the PSU logo properly
    }

    // Create page transition loading for navigation
    const pageLoadingHTML = `
        <div class="page-loading" id="pageLoading">
            <div class="loading-content">
                <img src="assets/images/logotitle.png" alt="PSU Logo" class="loading-logo">
                <div class="loading-text">Loading...</div>
                <div class="loading-subtitle">Please wait</div>
                <div class="loading-progress">
                    <div class="loading-progress-bar"></div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', pageLoadingHTML);

    // Page transition functionality
    function showPageLoading() {
        const pageLoading = document.getElementById('pageLoading');
        if (pageLoading) {
            pageLoading.classList.add('active');
        }
    }

    function hidePageLoading() {
        const pageLoading = document.getElementById('pageLoading');
        if (pageLoading) {
            pageLoading.classList.remove('active');
        }
    }

    // Add loading animation to all internal links
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        
        // Skip external links, hash links, and virtual tour links
        if (href && 
            !href.startsWith('http') && 
            !href.startsWith('#') && 
            !href.includes('Vtour') &&
            !href.includes('mailto') &&
            !href.includes('tel')) {
            
            link.addEventListener('click', function(e) {
                // Show loading animation
                showPageLoading();
                
                // Small delay to show the animation before navigation
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
                
                e.preventDefault();
            });
        }
    });

    // Hide page loading when page loads
    window.addEventListener('load', hidePageLoading);

    // Parallax scrolling effect
    function parallaxScroll() {
        const parallaxElements = document.querySelectorAll('.hero-parallax, .parallax-section');
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            const yPos = -(window.scrollY * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    }

    // Advanced parallax with different layers
    function layeredParallax() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        // Hero parallax
        const hero = document.querySelector('.hero-parallax');
        if (hero) {
            hero.style.transform = `translateY(${rate}px)`;
        }

        // Floating elements
        const floatingElements = document.querySelectorAll('.floating');
        floatingElements.forEach((element, index) => {
            const speed = 0.1 + (index * 0.02);
            const yPos = scrolled * speed;
            element.style.transform = `translateY(${yPos}px)`;
        });
    }

    // Scroll animations observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                
                // Stagger animation for child elements
                const children = entry.target.querySelectorAll('.feature-card, .course-card-modern, .testimonial-card');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.style.animationDelay = `${index * 0.1}s`;
                        child.classList.add('animated');
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe scroll animate elements
    document.querySelectorAll('.scroll-animate').forEach(el => {
        observer.observe(el);
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Header scroll effect
    function headerScrollEffect() {
        const header = document.querySelector('.header-main');
        if (!header) return;

        if (window.scrollY > 100) {
            header.classList.add('header-modern', 'scrolled');
        } else {
            header.classList.remove('scrolled');
            if (window.scrollY <= 50) {
                header.classList.remove('header-modern');
            }
        }
    }

    // Typing animation for hero text
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.innerHTML = '';
        
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        
        type();
    }

    // Initialize typing animation for hero title
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const titleText = heroTitle.textContent;
        setTimeout(() => {
            typeWriter(heroTitle, titleText, 100);
        }, 1000);
    }

    // Mouse move parallax for cards
    function cardParallax() {
        const cards = document.querySelectorAll('.feature-card, .course-card-modern');
        
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const deltaX = (x - centerX) / centerX;
                const deltaY = (y - centerY) / centerY;
                
                card.style.transform = `perspective(1000px) rotateX(${deltaY * 5}deg) rotateY(${deltaX * 5}deg) translateZ(10px)`;
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
            });
        });
    }

    // Number counter animation
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        function updateCounter() {
            start += increment;
            if (start < target) {
                element.textContent = Math.floor(start);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        }
        
        updateCounter();
    }

    // Initialize counters when they come into view
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.dataset.target);
                animateCounter(entry.target, target);
                counterObserver.unobserve(entry.target);
            }
        });
    });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });

    // Magnetic buttons effect
    function magneticEffect() {
        const buttons = document.querySelectorAll('.btn-modern, .sale-parice');
        
        buttons.forEach(button => {
            button.addEventListener('mousemove', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                button.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translate(0px, 0px)';
            });
        });
    }

    // Reveal animation on scroll
    function revealOnScroll() {
        const reveals = document.querySelectorAll('.reveal');
        
        reveals.forEach(reveal => {
            const windowHeight = window.innerHeight;
            const elementTop = reveal.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < windowHeight - elementVisible) {
                reveal.classList.add('active');
            }
        });
    }

    // Particle background effect
    function createParticles() {
        const particleContainer = document.querySelector('.particle-container');
        if (!particleContainer) return;

        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(255, 224, 71, 0.5);
                border-radius: 50%;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                animation-delay: ${Math.random() * 2}s;
            `;
            particleContainer.appendChild(particle);
        }
    }

    // Text reveal animation
    function textRevealAnimation() {
        const textElements = document.querySelectorAll('.text-reveal');
        
        textElements.forEach(element => {
            const text = element.textContent;
            element.innerHTML = '';
            
            text.split('').forEach((char, index) => {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.style.cssText = `
                    opacity: 0;
                    transform: translateY(50px);
                    animation: textReveal 0.5s ease forwards;
                    animation-delay: ${index * 0.03}s;
                `;
                element.appendChild(span);
            });
        });
    }

    // Gradient background animation
    function animateGradient() {
        const gradientElements = document.querySelectorAll('.animated-gradient');
        
        gradientElements.forEach(element => {
            let angle = 0;
            
            setInterval(() => {
                angle += 1;
                element.style.background = `linear-gradient(${angle}deg, #FFE047, #0A27D8, #FFE047)`;
            }, 50);
        });
    }

    // Scroll progress indicator
    function scrollProgress() {
        const progressBar = document.querySelector('.scroll-progress');
        if (!progressBar) return;

        const totalHeight = document.body.scrollHeight - window.innerHeight;
        const progress = (window.pageYOffset / totalHeight) * 100;
        progressBar.style.width = progress + '%';
    }

    // Event listeners
    window.addEventListener('scroll', () => {
        layeredParallax();
        headerScrollEffect();
        revealOnScroll();
        scrollProgress();
    });

    window.addEventListener('resize', () => {
        // Recalculate parallax on resize
        layeredParallax();
    });

    // Initialize functions
    cardParallax();
    magneticEffect();
    createParticles();
    textRevealAnimation();
    animateGradient();

    // CSS animations for particles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(-15px) rotate(240deg); }
        }
        
        @keyframes textReveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .particle-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #FFE047, #0A27D8);
            z-index: 1000;
            transition: width 0.1s ease;
        }
    `;
    document.head.appendChild(style);

    // Add scroll progress bar to page
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);
}); 