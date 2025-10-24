<?php include("../../minks1.php");
$page_name = "users.php"; $table_name = "users";
	$stmt = $con -> prepare("SELECT id, user_id, username, first_name, last_name, email, bio, dob, location, country, profile_pic, gender, looking_for, religion, acc_approved, email_sent, email_confirmed, date_signed_up, last_active FROM $table_name"); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id, $user_id, $username, $first_name, $last_name, $email, $bio, $dob, $location, $country, $profile_pic, $gender, $looking_for, $religion, $acc_approved, $email_sent, $email_confirmed, $date_signed_up, $last_active ); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		while ($stmt -> fetch()) { 
      $date_signed_up1 = date_create($date_signed_up);
      $date_signed_up_formatted = date_format($date_signed_up1, "jS, F Y - h:i:a");
      if($last_active){
      $last_active_formatted = date("jS, F Y - h:i:a", $last_active);
      }else{$last_active_formatted = "Never Seen";}
      ?>
            <div class="col-6 col-md-3 col-lg-3 col-xxl-3">

                <div class="card blog-card overflow-hidden">
                    <?php if($profile_pic !== ""){ ?>
                    <a class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;"
                        href="../users/<?= $user_id ?>/<?= $profile_pic ?>">
                        <img alt="..." class="card-img-top" src="../users/<?= $user_id ?>/<?= $profile_pic ?>" style='height:200px; object-fit:cover;'>
                    </a>
                    <?php } else{ ?>
                       <a class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;"
                        href="../images/profile_placeholder.jpg">
                        <img alt="..." class="card-img-top" src="../images/profile_placeholder.jpg" style='height:200px; object-fit:cover;'>
                    </a>
                   <?php } ?>
                    <div class="card-body">
                       <h5><?= "$first_name $last_name ($username)" ?></h5> <hr>
                        <p class="card-text text-secondary">
                            <?= "$location, $country" ?>
                        </p>
                        <hr>
                        <p class="card-text text-secondary">
                            
                        </p>
                        <p style='color:cornflowerblue;'>Account Approved: <?= $acc_approved ?></p>
                        <div class="app-divider-v dashed py-3"></div>
                        <div class="d-flex justify-content-between align-items-center gap-2 position-relative">
                           
                            
                            <div>
                                <div class="btn-group dropdown-icon-none">
                                    <button aria-expanded="false"
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-auto-close="true"
                                            data-bs-toggle="dropdown" type="button">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li data-bs-target="#Modal<?= $id ?>" data-bs-toggle="modal">
                                            <a class="dropdown-item text-success" href="javascript:void(0)">
                                                <i class="fa fa-eye"></i> View Details
                                            </a>
                                        </li>
                                        <?php if($acc_approved == "Yes"){ ?>
                                         <li class="block-btn" data-id="<?= $id ?>">
                                            <a class="dropdown-item text-secondary" href="javascript:void(0)">
                                                <i class="fa fa-lock"></i> Block Account 
                                            </a>
                                        </li>
                                        <?php }else{ ?>
                                          <li class="unblock-btn" data-id="<?= $id ?>">
                                            <a class="dropdown-item text-secondary" href="javascript:void(0)">
                                                <i class="fa fa-unlock"></i> Un-block Account 
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <li class="delete-btn" data-user="<?= $user_id ?>">
                                            <a class="dropdown-item text-danger" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i> Delete Account 
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
                            <h1 class="modal-title fs-5" id="Modal<?= $id ?>Label">Details</h1>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                          <b>User name:</b> <?= $username ?> <br>
                          <b>First name:</b> <?= $first_name ?> <br>
                          <b>Last name:</b> <?= $last_name ?> <br>
                          <b>Email:</b> <?= $email ?> <br>
                          <b>Bio:</b> <?= $bio ?> <br>
                          <b>DOB:</b> <?= $dob ?> <br>
                          <b>Location:</b> <?= $location ?>, <?= $country ?> <br>
                          <b>Gender:</b> <?= $gender ?> <br>
                          <b>Looking for:</b> <?= $looking_for ?> <br>
                          <b>Religion:</b> <?= $religion ?> <br>
                          <b>Email Sent:</b> <?= $email_sent ?> <br>
                          <b>Email Confirmed:</b> <?= $email_confirmed ?> <br>
                          <b>Date Signed Up:</b> <?= $date_signed_up_formatted ?> <br>
                          <b>Last Active:</b> <?= $last_active_formatted ?> <br>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                           
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
  const user_id = $(this).data('user');

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
          user_id,user_id,
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

<script>
$(document).on('click', '.block-btn', function () {
  const id = $(this).data('id');

  Swal.fire({
    title: 'Are you sure?',
    text: "This user will be barred from logging in",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, BLOCK it'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "ajax/<?= $page_name ?>",
        data: {
          id: id,
          action: 'block'
        },
        success: function (response) {
          Swal.fire(
            'Blocked!',
            response,
            'success'
          );
          loadData(); // Refresh the list
        },
        error: function () {
          Swal.fire(
            'Failed!',
            'Could not block the account.',
            'error'
          );
        }
      });
    }
  });
});
</script>

<script>
$(document).on('click', '.unblock-btn', function () {
  const id = $(this).data('id');

  Swal.fire({
    title: 'Are you sure?',
    text: "This user will be able to access this account",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, allow it fam'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "ajax/<?= $page_name ?>",
        data: {
          id: id,
          action: 'unblock'
        },
        success: function (response) {
          Swal.fire(
            'Unblocked!',
            response,
            'success'
          );
          loadData(); // Refresh the list
        },
        error: function () {
          Swal.fire(
            'Failed!',
            'Could not un-block the account.',
            'error'
          );
        }
      });
    }
  });
});
</script>