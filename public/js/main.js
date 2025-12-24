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


// ==================================================



// document.addEventListener('DOMContentLoaded', function () {
// 	const notifBtn = document.getElementById('notif-btn');
// 	const notifMenu = document.getElementById('notif-menu');
// 	const notifList = document.getElementById('notif-list');
// 	const notifCount = document.getElementById('notif-count');

// 	notifBtn.addEventListener('click', function () {
// 		notifMenu.classList.toggle('show');
// 		fetchNotifications();
// 	});

// 	// Load unread count every 20 seconds
// 	setInterval(fetchUnreadCount, 20000);
// 	fetchUnreadCount();

// 	function fetchUnreadCount() {
// 		fetch(BASE_URL + "Dashboard/unread_count")

// 			// fetch("<?php echo base_url().'index.php/Dashboard/unread_count'; ?>")
// 			.then(res => res.json())
// 			.then(data => {
// 				if (data.count > 0) {
// 					notifCount.textContent = data.count;
// 					notifCount.classList.remove('hidden');
// 				} else {
// 					notifCount.classList.add('hidden');
// 				}
// 			});
// 	}

// 	function fetchNotifications() {
// 		fetch(BASE_URL + "Dashboard/get_notifications")
// 			// fetch("<?php echo base_url().'index.php/Dashboard/get_notifications'; ?>")
// 			.then(res => res.json())
// 			.then(data => {
// 				notifList.innerHTML = '';
// 				if (data.length === 0) {
// 					notifList.innerHTML = '<p class="text-center text-gray-500 p-2">No notifications</p>';
// 				} else {
// 					data.forEach(n => {
// 						const row = document.createElement('div');
// 						row.className = 'p-2 border-b hover:bg-gray-100 cursor-pointer ' + (n.read_flag == 0 ? 'bg-gray-100' : '');
// 						row.innerHTML = `
//               <div><strong>${n.message}</strong></div>
//               <small class="text-gray-400">${n.msg_date}</small>
//             `;
// 						row.addEventListener('click', () => {
// 							markAsRead(n.msg_id, n.redirect_url);
// 						});
// 						notifList.appendChild(row);
// 					});
// 				}
// 			});
// 	}

// 	function markAsRead(msg_id, url) {
// 		fetch(BASE_URL + "Dashboard/mark_as_read/" + msg_id)
// 			.then(() => window.location.href = url);
// 	}
// });




