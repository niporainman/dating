<?php
session_start();
include("minks1.php");
$user_id = $_SESSION['user_id'];
if (isset($_GET['other_user'])){
	$user_id_f = mysqli_real_escape_string($con,$_GET['other_user']);
} 
?>

<link id="change-link" rel="stylesheet" type="text/css" href="css/style.css">

<?php
$stmt_f = $con->prepare("SELECT sender, receiver, status FROM connections WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) LIMIT 1");
$stmt_f->bind_param("ssss", $user_id, $user_id_f, $user_id_f, $user_id);
$stmt_f->execute();
$stmt_f -> store_result(); 
$stmt_f -> bind_result($sender, $receiver, $status); 
$numrows_f = $stmt_f -> num_rows();
if ($numrows_f > 0) {
    while ($stmt_f -> fetch()) {

        if($status == "Accepted"){
            //option to unfriend
            echo"
                <form action='friend_buttons.php?other_user=$user_id_f' method='get' style='display:inline; margin-right:10px;'>
                    <input type='hidden' name='sender' value='$user_id'>
                    <input type='hidden' name='other_user' value='$user_id_f'>
                    <button type='submit' name='cancel' class='btn btn-outline toggle-friend'>Unfriend</button>
                </form>
            ";
            //option to message
            echo"<a target='_top' href='messages.php?chat_with=$user_id_f' class='btn btn-primary toggle-friend'>Message</a>";
        }

        //you can cancel your own request
        if($sender == $user_id){
            if($status == "Pending"){
                //option to cancel
                echo"
                    <form action='friend_buttons.php?other_user=$user_id_f' method='get' style='margin:0; padding:0; display:inline; margin-right:10px;'>
                        <input type='hidden' name='sender' value='$user_id'>
                        <input type='hidden' name='other_user' value='$user_id_f'>
                        <button type='submit' name='cancel' class='btn btn-outline toggle-friend'>Cancel Request</button>
                    </form>
                ";
            }
        }

        //you can reject their request or accept
        if($sender == $user_id_f){
            if($status == "Pending"){
                //option to accept
                echo"
                    <form action='friend_buttons.php?other_user=$user_id_f' method='get' style='margin:0; padding:0; display:inline; margin-right:10px;'>
                        <input type='hidden' name='sender' value='$user_id'>
                        <input type='hidden' name='other_user' value='$user_id_f'>
                        <button type='submit' name='accept' class='btn btn-primary toggle-friend'>Accept Request</button>
                    </form>
                ";
                //option to reject
                echo"
                    <form action='friend_buttons.php?other_user=$user_id_f' method='get' style='margin:0; padding:0; display:inline; margin-right:10px;'>
                        <input type='hidden' name='sender' value='$user_id'>
                        <input type='hidden' name='other_user' value='$user_id_f'>
                        <button type='submit' name='cancel' class='btn btn-danger toggle-friend'>Reject</button>
                    </form>
                ";
            }
        }
    }
} else{
    //no connection yet, add friend
    echo"
    <form action='friend_buttons.php?other_user=$user_id_f' method='get' style='margin:0; padding:0; display:inline; margin-right:10px;'>
        <input type='hidden' name='sender' value='$user_id'>
        <input type='hidden' name='other_user' value='$user_id_f'>
        <button type='submit' name='add_friend' class='btn btn-outline toggle-friend'>Add Friend</button>
    </form>
";
}

if (isset($_GET['add_friend'])) {
	$sender_form = $_GET['sender'];
    $receiver_form = $_GET['other_user'];

    //even though not possible, confirm that no connection exists before adding friend
    $stmt_g = $con->prepare("SELECT id FROM connections WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) LIMIT 1");
    $stmt_g->bind_param("ssss", $sender_form, $receiver_form, $receiver_form, $sender_form);
    $stmt_g->execute();
    $stmt_g -> store_result(); 
    $stmt_g -> bind_result($idd); 
    $numrows_g = $stmt_g -> num_rows();
    if ($numrows_g > 0) {
        while ($stmt_g -> fetch()) {}
    }else{
        $db_id=0;
        $pending_word = "Pending";
        $date = date("Y-m-d H:i:s");
		$stmt = $con -> prepare('INSERT INTO connections VALUES (?,?,?,?,?)');
		$stmt -> bind_param('issss', $db_id, $sender_form, $receiver_form, $pending_word, $date);
		$stmt -> execute();
        echo "<meta http-equiv=\"refresh\" content=\"0; url=friend_buttons.php?other_user=$user_id_f\">";
    }


}

//cancel request
if (isset($_GET['cancel'])) {
	$sender_form = $_GET['sender'];
    $receiver_form = $_GET['other_user'];

    $stmt = $con -> prepare('DELETE FROM connections WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)');	
	$stmt -> bind_param("ssss", $sender_form, $receiver_form, $receiver_form, $sender_form);
	$stmt -> execute();
    echo "<meta http-equiv=\"refresh\" content=\"0; url=friend_buttons.php?other_user=$user_id_f\">";
}

//accept request
if (isset($_GET['accept'])) {
	$sender_form = $_GET['sender'];
    $receiver_form = $_GET['other_user'];
    $accepted_word = "Accepted";
    $stmt = $con -> prepare('UPDATE connections SET status = ? WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)');	
	$stmt -> bind_param("sssss",$accepted_word, $sender_form, $receiver_form, $receiver_form, $sender_form);
	$stmt -> execute();
    echo"
    <script>
        setTimeout(function() {
            window.top.location.href = 'profile_view?user_id=$user_id_f';
        }, 0);
    </script>
    ";
}
?>