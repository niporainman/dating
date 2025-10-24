function loadNotifications() {
    fetch('load_notifications.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('notificationList').innerHTML = data.html;
            const badge = document.getElementById('notifBadge');
            badge.textContent = data.unread_count > 0 ? data.unread_count : '';
            badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
        })
        .catch(err => console.error('Notification load error:', err));
}

function markNotificationsRead() {
    fetch('mark_notifications_read.php', { method: 'POST' })
        .then(() => {
            loadNotifications();
        })
        .catch(err => console.error('Mark read error:', err));
}

document.addEventListener('DOMContentLoaded', function () {
    loadNotifications();
    setInterval(loadNotifications, 15000); // refresh every 15s

    // When dropdown is opened
    const notifBtn = document.querySelector('.notification-btn .main-link');
    notifBtn?.addEventListener('click', markNotificationsRead);
});
