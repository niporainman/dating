function updateFriendRequestBadge() {
    fetch('get_pending_requests_count.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('friendRequestBadge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(err => console.error('Badge load error:', err));
}

// Call on page load and every 10 seconds
document.addEventListener('DOMContentLoaded', () => {
    updateFriendRequestBadge();
    setInterval(updateFriendRequestBadge, 10000);
});