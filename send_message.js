document.addEventListener('DOMContentLoaded', function () {
    const sendBtn = document.getElementById('sendBtn');
    const messageInput = document.getElementById('messageInput');
    
    const messageContainer = document.querySelector('.messages-content');
    const newMessageBadge = document.getElementById('newMessageBadge');

    

    let autoScrollEnabled = true;

    // Send message
    sendBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const receiverId = document.getElementById('receiverId').value;
        const message = messageInput.value.trim();
        if (message === '') return;

        fetch('send_message.php', {
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
                loadMessages(); // optional force reload
            } else {
                alert("Error: " + response);
            }
        })
        .catch(error => console.error('Send error:', error));
    });

    messageInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); // prevent new line
        sendBtn.click();    // trigger click on the send icon
        console.log("Key pressed:", e.key);
    }
    });

    // Detect manual scroll
    messageContainer.addEventListener('scroll', () => {
        const atBottom = messageContainer.scrollTop + messageContainer.clientHeight >= messageContainer.scrollHeight - 50;
        autoScrollEnabled = atBottom;

        if (atBottom) {
            newMessageBadge.style.display = 'none';
        }
    });

    // Badge click scroll
    newMessageBadge.addEventListener('click', () => {
        messageContainer.scrollTop = messageContainer.scrollHeight;
        autoScrollEnabled = true;
        newMessageBadge.style.display = 'none';
    });

    // Load messages
    function loadMessages() {
        fetch('load_messages.php?chat_with=' + receiverId)
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
                    } else {
                        newMessageBadge.style.display = 'block';
                    }
                }
            })
            .catch(error => console.error('Load error:', error));
    }

    // Load every 5 seconds
    setInterval(loadMessages, 5000);
    loadMessages(); // initial load
});


