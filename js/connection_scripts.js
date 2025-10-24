
$(document).on('click', '.toggle-friend', function (e) {
    e.preventDefault();
    const receiver = $(this).data('receiver');

    $.post('ajax/toggle_friend.php', { receiver }, function (res) {
        if (res.success) {
            // Reload the search results or card
            $('#searchForm').trigger('submit');
        } else {
            alert(res.message || 'Action failed.');
        }
    }, 'json');
});

$(document).on('click', '.accept-friend', function (e) {
    e.preventDefault();
    const sender = $(this).data('sender');

    $.post('ajax/toggle_friend.php', { sender, action: 'accept' }, function (res) {
        if (res.success) {
            $('#searchForm').trigger('submit');
        } else {
            alert(res.message || 'Action failed.');
        }
    }, 'json');
});

$(document).on('click', '.reject-friend', function (e) {
    e.preventDefault();
    const sender = $(this).data('sender');

    $.post('ajax/toggle_friend.php', { sender, action: 'reject' }, function (res) {
        if (res.success) {
            $('#searchForm').trigger('submit');
        } else {
            alert(res.message || 'Action failed.');
        }
    }, 'json');
});