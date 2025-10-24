<?php include("../../minks1.php");
$page_name = "other_images.php";
$x="x";
	$stmt = $con -> prepare('SELECT * FROM general_images ORDER by photo_order'); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id,$po,$picture,$size);
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		while ($stmt -> fetch()) {
      $imagePath = "../../site_img/general/$picture";
			$imageInfo = getimagesize($imagePath);
			if ($imageInfo) {
				$width = $imageInfo[0];
				$height = $imageInfo[1];
				$pic_info = "$width$x$height";
			} else {
				$pic_info = "Failed to get image size";
			}

			if($pic_info == $size){
				$pic_info_color = "forestgreen";
			}
			else{
				$pic_info_color = "red";
			}
      ?>
            <div class="col-md-6 col-lg-4 col-xxl-3">

                <div class="card blog-card overflow-hidden">
                    <a class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;"
                        href="../site_img/general/<?= $picture ?>">
                        <img alt="" class="card-img-top" src="../site_img/general/<?= $picture ?>">
                    </a>
                    
                    <div class="card-body">
                       <h5><?= $picture ?></h5> <hr>
                       <label style='font-weight:900;'>Recommended Size - <?= $size ?></label>
					             <label style='font-weight:900;color:<?= $pic_info_color ?> !important;'>Current Size - <?= $pic_info ?></label>
                        <div class="app-divider-v dashed py-3"></div>
                        <div class="d-flex justify-content-between align-items-center gap-2 position-relative">
                           
                            
                            <div>
                                <div class="btn-group dropdown-icon-none">
                                    <button aria-expanded="false"
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-auto-close="true"
                                            data-bs-toggle="dropdown" type="button">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li data-bs-target="#Modal<?= $id ?>" data-bs-toggle="modal">
                                            <a class="dropdown-item text-success" href="javascript:void(0)">
                                                <i class="fa fa-wrench"></i> Edit 
                                            </a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="Modal<?= $id ?>Label" class="modal fade" id="Modal<?= $id ?>"
                 tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="Modal<?= $id ?>Label">Edit Item</h1>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form<?= $id ?>" class="app-form ajax-form" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label class="form-label">File</label>
                                    <input class="form-control" type="file" name='fileField' accept="image/*">
                                </div>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="picture" value="<?= $picture ?>">
                                <input type="hidden" name="action" value="edit">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                            <button form="form<?= $id ?>" class="btn btn-primary submit-btn" type="submit" name="action" value="edit">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php } } ?>
<script src="../assets/js/jquery-3.6.3.min.js"></script>
<script>
  $(document).on("submit", ".ajax-form", function (e) {
  e.preventDefault();
  
  var $form = $(this);
  var formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/<?= $page_name ?>",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      Swal.fire({
        icon: 'success',
        title: 'Updated',
        text: response
      });
      $form[0].reset();
      let modal = bootstrap.Modal.getInstance($form.closest('.modal')[0]);
      modal.hide();
      loadData();
    },
    error: function () {
      Swal.fire({
        icon: 'error',
        title: 'Update failed',
        text: 'Something went wrong!'
      });
    }
  });
});

// Detect which submit button was clicked
$(document).on("click", ".ajax-form button[type=submit]", function () {
  // Reset all buttons in all forms first
  $(".ajax-form button[type=submit]").removeAttr("clicked");
  $(this).attr("clicked", "true");
});

</script>