document.addEventListener('DOMContentLoaded', function () {
    const previewList = document.getElementById('messagePreviewList');
    const searchInput = document.getElementById('messageSearchInput');
    const messageCount = document.getElementById('messageCount');

    function loadDropdownMessages() {
        fetch('load_dropdown_messages.php')
            .then(response => response.text())
            .then(html => {
                previewList.innerHTML = html;

                // Count unread messages
                const unread = previewList.querySelectorAll('.has-unread').length;
                messageCount.textContent = unread;
                messageCount.style.display = unread > 0 ? 'inline-block' : 'none';
                feather.replace();
            });
    }

    searchInput.addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const items = previewList.querySelectorAll('li');
        items.forEach(item => {
            const name = item.querySelector('h5')?.textContent?.toLowerCase() || '';
            item.style.display = name.includes(filter) ? 'block' : 'none';
        });
    });

    loadDropdownMessages();
    setInterval(loadDropdownMessages, 10000); // refresh every 10 sec
});
