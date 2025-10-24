let autoScrollEnabled = true;

function loadMessages() {
    const receiverId = document.getElementById('receiverId')?.value;
    const messageContainer = document.querySelector('.messages-content');
    const newMessageBadge = document.getElementById('newMessageBadge');

    if (!receiverId || !messageContainer) return;

    fetch('ajax/load_messages.php?chat_with=' + receiverId)
        .then(response => response.text())
        .then(html => {
            const oldHTML = messageContainer.innerHTML.trim();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newHTML = tempDiv.innerHTML.trim();

            if (oldHTML !== newHTML) {
                const atBottom = autoScrollEnabled;
                messageContainer.innerHTML = newHTML;

                if (atBottom) {
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                } else if (newMessageBadge) {
                    newMessageBadge.style.display = 'block';
                }
            }
        })
        .catch(error => console.error('Load error:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    setInterval(loadMessages, 5000);
    loadMessages(); // initial
});
