/**
 * Course Search and Filter Functionality
 * Works for both logged in and guest users
 */

class CourseFilter {
    constructor() {
        this.filterBtns = document.querySelectorAll('.filter-btn');
        this.courseItems = document.querySelectorAll('.course-item');
        this.searchInput = document.getElementById('courseSearch');
        this.searchBtn = document.getElementById('searchBtn');
        this.noResults = document.getElementById('noResults');
        
        this.currentFilter = 'all';
        this.currentSearch = '';
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.applyFilters();
    }
    
    bindEvents() {
        // Filter button events
        this.filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleFilterClick(e));
        });
        
        // Search events
        if (this.searchBtn) {
            this.searchBtn.addEventListener('click', () => this.performSearch());
        }
        
        if (this.searchInput) {
            this.searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.performSearch();
                }
            });
            
            // Real-time search (optional)
            this.searchInput.addEventListener('input', () => {
                this.currentSearch = this.searchInput.value.toLowerCase().trim();
                this.applyFilters();
            });
        }
    }
    
    handleFilterClick(event) {
        // Remove active class from all buttons
        this.filterBtns.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        event.target.classList.add('active');
        
        this.currentFilter = event.target.getAttribute('data-filter');
        this.applyFilters();
    }
    
    performSearch() {
        if (this.searchInput) {
            this.currentSearch = this.searchInput.value.toLowerCase().trim();
            this.applyFilters();
        }
    }
    
    applyFilters() {
        let visibleCount = 0;
        
        this.courseItems.forEach(item => {
            const category = item.getAttribute('data-category') || '';
            const name = item.getAttribute('data-name') || '';
            const description = item.getAttribute('data-description') || '';
            const tag = item.querySelector('.tag')?.textContent.toLowerCase() || '';
            const title = item.querySelector('.title')?.textContent.toLowerCase() || '';
            
            // Check filter criteria
            const matchesFilter = this.currentFilter === 'all' || 
                                category === this.currentFilter ||
                                category.includes(this.currentFilter);
            
            // Check search criteria - search in multiple fields
            const searchText = `${name} ${description} ${tag} ${title} ${category}`;
            const matchesSearch = this.currentSearch === '' || 
                                searchText.includes(this.currentSearch);
            
            if (matchesFilter && matchesSearch) {
                this.showItem(item);
                visibleCount++;
            } else {
                this.hideItem(item);
            }
        });
        
        this.toggleNoResults(visibleCount === 0);
    }
    
    showItem(item) {
        item.classList.remove('hidden');
        item.style.display = '';
    }
    
    hideItem(item) {
        item.classList.add('hidden');
    }
    
    toggleNoResults(show) {
        if (this.noResults) {
            this.noResults.style.display = show ? 'block' : 'none';
        }
    }
    
    resetFilters() {
        // Reset search
        if (this.searchInput) {
            this.searchInput.value = '';
        }
        this.currentSearch = '';
        
        // Reset filter to "All Programs"
        this.filterBtns.forEach(btn => btn.classList.remove('active'));
        const allBtn = document.querySelector('[data-filter="all"]');
        if (allBtn) {
            allBtn.classList.add('active');
        }
        this.currentFilter = 'all';
        
        // Apply filters
        this.applyFilters();
    }
    
    // Public method to get current state
    getCurrentState() {
        return {
            filter: this.currentFilter,
            search: this.currentSearch,
            visibleItems: document.querySelectorAll('.course-item:not(.hidden)').length
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a page with course filtering
    if (document.querySelector('.course-item')) {
        const courseFilter = new CourseFilter();
        
        // Make reset function available globally
        window.resetFilters = () => courseFilter.resetFilters();
        
        // Store instance globally for debugging/external access
        window.courseFilterInstance = courseFilter;
    }
});

// Utility functions for course management
const CourseUtils = {
    // Categorize course based on name and tags
    categorizeCourse: function(courseName, courseTag) {
        const name = courseName.toLowerCase();
        const tag = courseTag.toLowerCase();
        
        // Education keywords
        if (name.includes('education') || name.includes('teaching') || 
            tag.includes('education') || name.includes('teacher')) {
            return 'education';
        }
        
        // Business keywords
        if (name.includes('business') || name.includes('management') || 
            name.includes('administration') || tag.includes('business') ||
            name.includes('marketing') || name.includes('economics')) {
            return 'business';
        }
        
        // Technology keywords
        if (name.includes('technology') || name.includes('information') || 
            name.includes('computer') || name.includes('programming') ||
            tag.includes('technology') || name.includes('software') ||
            name.includes('it ') || name.includes('bsit')) {
            return 'technology';
        }
        
        // Default fallback
        return 'other';
    },
    
    // Highlight search terms in text
    highlightSearchTerms: function(text, searchTerm) {
        if (!searchTerm) return text;
        
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    },
    
    // Get course statistics
    getCourseStats: function() {
        const items = document.querySelectorAll('.course-item');
        const visible = document.querySelectorAll('.course-item:not(.hidden)');
        
        const stats = {
            total: items.length,
            visible: visible.length,
            hidden: items.length - visible.length,
            categories: {}
        };
        
        // Count by category
        items.forEach(item => {
            const category = item.getAttribute('data-category') || 'other';
            stats.categories[category] = (stats.categories[category] || 0) + 1;
        });
        
        return stats;
    }
};

// Export for potential module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { CourseFilter, CourseUtils };
}
