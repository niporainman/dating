<?php include("../../minks1.php");
$page_name = "testimonials.php"; $table_name = "testimonials";
	$stmt = $con -> prepare("SELECT * FROM $table_name"); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id,$name,$occupation,$body,$picture,$display); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		while ($stmt -> fetch()) { ?>
            <div class="col-md-4 col-lg-4 col-xxl-4">

                <div class="card blog-card overflow-hidden">
                    <a class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;"
                        href="../site_img/<?= $table_name ?>/<?= $picture ?>">
                        <img alt="..." class="card-img-top" src="../site_img/<?= $table_name ?>/<?= $picture ?>">
                    </a>
                    
                    <div class="card-body">
                       <h5><?= $name ?></h5> <hr>
                        <p class="card-text text-secondary">
                            <?= $occupation ?>
                        </p>
                        <hr>
                        <p class="card-text text-secondary">
                            <?= $body ?>
                        </p>
                        <p style='color:cornflowerblue;'>Displayed on site: <?= $display ?></p>
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
                                        <li class="delete-btn" data-id="<?= $id ?>" data-picture="<?= $picture ?>">
                                            <a class="dropdown-item text-danger" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i> Delete 
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

                                
                                <div class="form-floating mb-3">
                                    <input class="form-control" id='name' placeholder="Name" name='name' type="text" value="<?= $name ?>" required>
                                    <label for="name">Name</label> 
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id='occupation' placeholder="Occupation" name='occupation' type="text" value="<?= $occupation ?>" required>
                                    <label for="occupation">Occupation</label> 
                                </div>
                                <div class="form-floating mb-3">
                                    <label>Body</label>
                                    <textarea name='body' id='body' class="form-control summernote" placeholder="Body" required><?= $body ?></textarea>  
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="display" id="display" required>
                                        <option selected value="<?= $display ?>"><?= $display ?></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <label class="form-floating form-label">Display on Site</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">File</label> <br>
                                    <img src="../site_img/<?= $table_name ?>/<?= $picture ?>" alt="..." class="img-fluid mb-2" style="max-width: 100px;">
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

<script>
  $(document).off("submit", ".ajax-form").on("submit", ".ajax-form", function (e) {
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

<script>
$(document).on('click', '.delete-btn', function () {
  const id = $(this).data('id');
  const picture = $(this).data('picture');

  Swal.fire({
    title: 'Are you sure?',
    text: "This item will be permanently deleted",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "ajax/<?= $page_name ?>",
        data: {
          id: id,
          picture: picture,
          action: 'delete'
        },
        success: function (response) {
          Swal.fire(
            'Deleted!',
            response,
            'success'
          );
          loadData(); // Refresh the list
        },
        error: function () {
          Swal.fire(
            'Failed!',
            'Could not delete the item.',
            'error'
          );
        }
      });
    }
  });
});
</script>