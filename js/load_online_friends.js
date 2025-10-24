
document.addEventListener("DOMContentLoaded", function () {
    fetch("load_online_friends.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("onlineFriends").innerHTML = html;
        });
});

    setInterval(() => {
    fetch("load_online_friends.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("onlineFriends").innerHTML = html;
        });
}, 60000); // every 60 seconds
