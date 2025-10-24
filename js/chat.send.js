document.addEventListener('DOMContentLoaded', function () {
    const sendBtn = document.getElementById('sendBtn');
    const messageInput = document.getElementById('messageInput');

    if (!sendBtn || !messageInput) return;

    sendBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const receiverId = document.getElementById('receiverId')?.value;
        const message = messageInput.value.trim();
        if (!message || !receiverId) return;

        fetch('ajax/send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                message: message,
                receiver_id: receiverId
            })
        })
        .then(response => response.text())
        .then(response => {
            if (response === "Message sent") {
                messageInput.value = '';
                if (typeof loadMessages === 'function') {
                    loadMessages();
                }
            } else {
                alert("Error: " + response);
            }
        })
        .catch(error => console.error('Send error:', error));
    });

    // Enter to send
    messageInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendBtn.click();
        }
    });
});
