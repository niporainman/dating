document.addEventListener('DOMContentLoaded', function () {
    const messageContainer = document.querySelector('.messages-content');
    const newMessageBadge = document.getElementById('newMessageBadge');

    if (!messageContainer || !newMessageBadge) return;

    messageContainer.addEventListener('scroll', () => {
        const atBottom = messageContainer.scrollTop + messageContainer.clientHeight >= messageContainer.scrollHeight - 50;
        autoScrollEnabled = atBottom;

        if (atBottom) {
            newMessageBadge.style.display = 'none';
        }
    });

    newMessageBadge.addEventListener('click', () => {
        messageContainer.scrollTop = messageContainer.scrollHeight;
        autoScrollEnabled = true;
        newMessageBadge.style.display = 'none';
    });
});
