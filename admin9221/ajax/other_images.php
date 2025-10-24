<?php include("../../minks1.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$action = $_POST['action'] ?? '';
	if($action === 'edit') {
		
		$id = $_POST['id'];
		$picture = $_POST['picture'];
		if (!empty($_FILES["fileField"]["name"])) {
			unlink("../../site_img/general/$picture");
			move_uploaded_file( $_FILES["fileField"]['tmp_name'], "../../site_img/general/$picture");
			echo"Picture was successfully updated.";
		}
	}
}
?>