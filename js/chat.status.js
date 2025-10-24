function checkChatPartnerStatus() {
    const chatWith = document.getElementById('receiverId')?.value;
    if (!chatWith) return;

    fetch('ajax/check_status.php?user_id=' + chatWith)
        .then(res => res.text())
        .then(status => {
            const statusEl = document.getElementById('chatStatus');
            if (statusEl) {
                statusEl.textContent = status;

                statusEl.classList.toggle('text-success', status === 'online');
                statusEl.classList.toggle('text-muted', status !== 'online');
            }
        })
        .catch(err => console.error('Status check error:', err));
}

document.addEventListener('DOMContentLoaded', function () {
    checkChatPartnerStatus();
    setInterval(checkChatPartnerStatus, 10000); // every 10 seconds
});
