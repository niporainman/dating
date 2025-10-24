document.addEventListener('DOMContentLoaded', function () {
    function loadFriendRequests() {
        fetch('load_friend_requests.php')
            .then(res => res.json())
            .then(data => {
                document.querySelector('.friend-list').innerHTML = data.html;
                const badge = document.querySelector('.add-friend .badge');
                if (badge) {
                    badge.textContent = data.badge > 0 ? data.badge : '';
                }
            });
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('confirm-request')) {
            const userId = e.target.dataset.user;
            fetch('handle_friend_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'accept', sender: userId })
            }).then(loadFriendRequests);
        }

        if (e.target.classList.contains('delete-request')) {
            const userId = e.target.dataset.user;
            fetch('handle_friend_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'delete', sender: userId })
            }).then(loadFriendRequests);
        }
    });

    // Initial load
    loadFriendRequests();
    setInterval(loadFriendRequests, 10000);
});
