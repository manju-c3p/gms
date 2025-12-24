// Sidebar toggle for mobile
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');
sidebarToggle.addEventListener('click', () => { 
  sidebar.classList.toggle('show'); 
});

// Expand/collapse submenu smoothly
document.querySelectorAll('.has-submenu > a').forEach(item => {
  item.addEventListener('click', (e) => {
    e.preventDefault();
    const parent = item.parentElement;
    parent.classList.toggle('menu-open');
  });
});

// Dropdowns
document.querySelectorAll('.dropdown-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    const dropdown = e.target.closest('.dropdown');
    dropdown.classList.toggle('show');
  });
});

// Close dropdown if clicked outside
window.addEventListener('click', e => {
  if (!e.target.matches('.dropdown-btn')) {
    document.querySelectorAll('.dropdown.show').forEach(drop => drop.classList.remove('show'));
  }
});

// Highlight active page in sidebar
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll('.sidebar nav a').forEach(link => {
  if (link.getAttribute('href') === currentPage) {
    link.classList.add('active');
  }
});
