function loadFriends(search = "") {
    $.get("ajax/load_friends.php", { search: search }, function (data) {
        $(".friend-list1").html(data);
        feather.replace();
    });
}

// Initial load
loadFriends();

// Search input
$(".search-input input").on("input", function () {
    const query = $(this).val().trim();
    loadFriends(query);
});

// Unfriend logic
$(document).on("click", ".unfriend", function (e) {
    e.preventDefault();
    const friendId = $(this).data("id");
    const $card = $(this).closest(".friend-card");

    $.post("ajax/unfriend.php", { friend_id: friendId }, function (response) {
        if (response.success) {
            $card.remove();
            loadFriends(); // reload to fill up to 6 again
        }
    }, "json");
});
