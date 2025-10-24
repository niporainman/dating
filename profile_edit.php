<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php"); ?>
<title><?php echo $company_name; ?> - Edit Your Profile</title>
<?php 
$sql = "SELECT first_name, last_name, email, bio, dob, location, country, profile_pic, profile_background, gender, looking_for, religion, acc_approved, email_confirmed FROM users WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt -> store_result(); 
$stmt -> bind_result($first_name, $last_name, $email, $bio, $dob, $location, $country, $profile_pic, $profile_background, $gender, $looking_for, $religion, $acc_approved, $email_confirmed); 
$numrows = $stmt -> num_rows();
if ($numrows > 0) {
    while ($stmt -> fetch()) {}
}

if($profile_pic == ""){
    $profile_pic_container = "images/profile_placeholder.jpg";
    $profile_pic_caption = "Add";
}
else{
    $profile_pic_container = "users/$user_id/$profile_pic";
    $profile_pic_caption = "Edit";
}

if($profile_background == ""){
    $profile_background_container = "images/background_placeholder.png";
    $profile_background_caption = "Add";
}
else{
    $profile_background_container = "users/$user_id/$profile_background";
    $profile_background_caption = "Edit";
}
?>

<div class="page-center">
   
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Your Profile</h5>
            </div>
<div style='height:50px;'>
                 <?php if($bio == ""){ ?>
<div id='profileWarning' class="alert alert-danger alert-dismissible fade show position-relative">
  <strong>Attention Required:</strong> Your profile is incomplete
  <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
                <?php } ?> 
 <div id="alertBox" style="display: none;"></div>
</div>
<form class="">
    <div class='edit-profile-sec'>
    <div class="container">
        <div class='row'>

        <div class="col-6 profile-wrap" style='margin-top:25px;'>
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="image"></i>
                </div>
                <div class='profile-pic'>
                    <div>
                    <img src="<?= $profile_pic_container ?>" class="img-fluid blur-up lazyload" style="height:150px;width:150px; object-fit:cover; border-radius:5px;">
                    </div>
                    <label class="file_upload">
                        <div class='file_upload_text'>Click here to <?= $profile_pic_caption ?> profile image (recommended size 500x500)</div>
                        <input type="file" name="profile_pic" id="profile_pic_input" accept="image/*" hidden>
                        <input type="hidden" id="existingProfilePic" value="<?= $profile_pic ?>">
                    </label>
                    <br>
                    <small id="file_error" style="color: red;"></small>
                    <div id="preview_container" style="margin-top: 10px;">
                        <img id="image_preview" src="#" alt="Preview" style="display: none; width: 150px; height:150px; object-fit:cover; border-radius: 5px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="image"></i>
                </div>
                <div class='profile-pic'>
                    <div>
                    <img src="<?= $profile_background_container ?>" class="img-fluid blur-up lazyload" style="height:150px; width:150px; object-fit:cover; border-radius:5px;">
                    </div>
                    <label class="file_upload">
                        <div class='file_upload_text'>Click here to <?= $profile_background_caption ?> cover image (recommended size 1380x350)</div>
                        <input type="file" name="profile_background" id="profile_background_input" accept="image/*" hidden>
                        <input type="hidden" id="existingProfileBackground" value="<?= $profile_background ?>">
                    </label>
                    <br>
                    <small id="file_error1" style="color: red;"></small>
                    <div id="preview_container1" style="margin-top: 10px;">
                        <img id="image_preview1" src="#" alt="Preview" style="display: none; width: 150px; height:150px; object-fit:cover; border-radius: 5px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <textarea name="bio" id="bio" class='form-control' placeholder='Bio (Max 250 Characters)' required><?= $bio ?></textarea>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <input type="text" id="custom_date" placeholder="Date of birth" onfocus="(this.type='date')" class="form-control" value='<?= $dob ?>' name='dob' required>

            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <input type="text" name="location" id="location" placeholder='City' class='form-control' value='<?= $location ?>' required>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <select name="country" id="country" class='form-control' required>
                    <option value="">Choose your country</option>
                   <?php if($country !== ""){
                    echo"<option selected value='$country'>$country</option>";} 
                    ?>
                    <?php include("country_list.php"); ?>
                </select>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <select name="gender" id="gender" class='form-control' required>
                    <option value="">Choose your gender</option>
                    <?php if($gender !== ""){
                    echo"<option selected value='$gender'>$gender</option>";} 
                    ?> 
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <select name="looking_for" id="looking_for" class='form-control' required>
                    <option value="">Looking for</option>
                    <?php if($looking_for !== ""){
                    echo"<option selected value='$looking_for'>$looking_for</option>";} 
                    ?> 
                    <option value="Casual Dating">Casual Dating</option>
                    <option value="Serious Relationship">Serious Relationship</option>
                </select>
            </div>
        </div>

        <div class="col-6 profile-wrap">
            <div class="edit-title">
                <div class="icon">
                    <i class="iw-16 ih-16" data-feather="edit-2"></i>
                </div>
                <select name="religion" id="religion" class='form-control' required>
                        <option value="">Choose your religion</option>
                    <?php if($religion !== ""){
                    echo"<option selected value='$religion'>$religion</option>";} 
                    ?> 
                        <option value="Christianity">Christianity</option>
                        <option value="Islam">Islam</option>
                        <option value="Judaism">Judaism</option>
                        <option value="Hinduism">Hinduism</option>
                        <option value="Buddhism">Buddhism</option>
                        <option value="Sikhism">Sikhism</option>
                        <option value="Traditional">Traditional/Indigenous</option>
                        <option value="Spiritual but not religious">Spiritual but not religious</option>
                        <option value="Atheist">Atheist</option>
                        <option value="Agnostic">Agnostic</option>
                        <option value="Other">Other</option>
                </select>
            </div>
        </div>

                 </div> 
    </div>
     <div class="modal-footer">
        <button type="button" id='profile-btn' class="btn btn-solid">save</button>
    </div>
    </div>
    </form>

<script>
function showAlert(message, type = 'success') {
    const alertBox = document.getElementById('alertBox');

    alertBox.className = `alert alert-${type} alert-dismissible fade show`;
    alertBox.innerHTML = `
        <strong>${type === 'success' ? 'Success' : 'Error'}:</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertBox.style.display = 'block';

    setTimeout(() => alertBox.classList.remove('show'), 4000);
    setTimeout(() => {
        alertBox.style.display = 'none';
        alertBox.className = '';
    }, 5000);
}

function validateRequiredFields(form) {
    let valid = true;

    // Remove old error messages
    form.querySelectorAll('.error-message').forEach(el => el.remove());

        // Get all inputs marked as required + manually add file inputs
    const requiredFields = [
        ...form.querySelectorAll('[required]'),
        document.getElementById('profile_pic_input'),
        document.getElementById('profile_background_input')
    ];

    requiredFields.forEach(field => {
        let isEmpty = false;

        // Reset any previous error styling
        field.style.border = '';
        
if (field.type === 'file') {
    if (field.id === 'profile_pic_input') {
        const existingProfileValue = document.getElementById('existingProfilePic')?.value;
        isEmpty = field.files.length === 0 && !existingProfileValue;
    } else if (field.id === 'profile_background_input') {
        const existingBackgroundValue = document.getElementById('existingProfileBackground')?.value;
        isEmpty = field.files.length === 0 && !existingBackgroundValue;
    }
}

        // Add error if empty
        if (isEmpty) {
            valid = false;
            field.style.border = '2px solid red';

            const error = document.createElement('div');
            error.className = 'error-message text-danger mt-1';
            error.style.fontSize = '0.875em';
            error.textContent = 'This field is required.';

            field.parentElement.insertAdjacentElement('afterend', error);
        }

    });

    return valid;
}

document.querySelector('#profile-btn').addEventListener('click', async function (e) {
    const form = document.querySelector('form');

    // Validate form first
    if (!validateRequiredFields(form)) {
        showAlert('Please fill in all required fields.', 'danger');
        return;
    }

    const formData = new FormData(form);

    const profilePic = document.getElementById('profile_pic_input')?.files[0];
    const backgroundPic = document.getElementById('profile_background_input')?.files[0];

    if (profilePic) formData.append('profile_pic', profilePic);
    if (backgroundPic) formData.append('profile_background', backgroundPic);

    try {
        const response = await fetch('update_profile.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Profile updated successfully'
            });
        } else {
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message || 'Something went wrong.'
            });
        }

    } catch (error) {
        showAlert('AJAX Error: ' + error.message, 'danger');
    }
});
</script>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Hobby Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="briefcase"></i>
        </div>
        <h5>Hobbies</h5>
      </div>
      <div class="edit-content">
        <form id="add-hobby-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="hobby" class="form-control" placeholder="Enter hobby" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- Hobbies list will be injected here -->
    <div id="hobby-list" class="col-12 profile-wrap">
      <!-- Existing hobbies will be loaded here via AJAX -->
    </div>

  </div>
</div>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="briefcase"></i>
        </div>
        <h5>TV Shows</h5>
      </div>
      <div class="edit-content">
        <form id="add-tv-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="tv" class="form-control" placeholder="Enter TV Show" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- list will be injected here -->
    <div id="tv-list" class="col-12 profile-wrap">
      <!-- Existing items will be loaded here via AJAX -->
    </div>

  </div>
</div>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="briefcase"></i>
        </div>
        <h5>Movies</h5>
      </div>
      <div class="edit-content">
        <form id="add-movie-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="movie" class="form-control" placeholder="Add a movie and save" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- list will be injected here -->
    <div id="movie-list" class="col-12 profile-wrap">
      <!-- Existing items will be loaded here via AJAX -->
    </div>

  </div>
</div>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="music"></i>
        </div>
        <h5>Music Artist</h5>
      </div>
      <div class="edit-content">
        <form id="add-artist-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="artist" class="form-control" placeholder="Add a music artist that you love" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- list will be injected here -->
    <div id="artist-list" class="col-12 profile-wrap">
      <!-- Existing items will be loaded here via AJAX -->
    </div>

  </div>
</div>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="book"></i>
        </div>
        <h5>Books</h5>
      </div>
      <div class="edit-content">
        <form id="add-book-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="book" class="form-control" placeholder="Enter a book" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- list will be injected here -->
    <div id="book-list" class="col-12 profile-wrap">
      <!-- Existing items will be loaded here via AJAX -->
    </div>

  </div>
</div>

<div class="container">
  <div class="edit-profile-sec row">

    <!-- Add Form -->
    <div class="col-12 profile-wrap">
      <div class="edit-title">
        <div class="icon">
          <i class="iw-16 ih-16" data-feather="briefcase"></i>
        </div>
        <h5>Other interests</h5>
      </div>
      <div class="edit-content">
        <form id="add-other-form" class="d-flex" style="gap: 10px;">
          <input type="text" name="other" class="form-control" placeholder="Other interests you might have e.g fishing, hiking" required>
          <input type="hidden" name="action" value="save">
          <button type="submit" class="btn btn-solid">+ Add</button>
        </form>
      </div>
    </div>

    <!-- list will be injected here -->
    <div id="other-list" class="col-12 profile-wrap">
      <!-- Existing items will be loaded here via AJAX -->
    </div>

  </div>
</div>
    
    </div>
</div>

<?php include("profile_chat_snippet.php"); ?>
<!-- Place this at the top or bottom of the <body> -->


<?php include("profile_footer.php"); ?>


   