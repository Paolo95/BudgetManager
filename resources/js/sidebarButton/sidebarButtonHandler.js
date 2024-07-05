// resources/js/sidebar.js

// JavaScript to toggle sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');

    // Toggle class to show/hide sidebar
    sidebar.classList.toggle('sidebar-opened');

    // Toggle text/icon on the toggle button
    if (sidebar.classList.contains('sidebar-opened')) {
        toggleBtn.textContent = '✕ Chiudi';
    } else {
        toggleBtn.textContent = '☰ Menu';
    }
}

// Attach click event listener to toggle button
const toggleBtn = document.querySelector('.toggle-sidebar-btn');
toggleBtn.addEventListener('click', toggleSidebar);
