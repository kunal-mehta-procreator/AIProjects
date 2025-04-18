document.addEventListener('DOMContentLoaded', function() {
    // Get all menu items with submenus
    const menuItems = document.querySelectorAll('.has-submenu');
    
    // Add click event listeners to each menu item
    menuItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close all other open submenus
            menuItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle the clicked submenu
            item.classList.toggle('active');
        });
    });
    
    // Close submenus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.admin-nav')) {
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
        }
    });
}); 