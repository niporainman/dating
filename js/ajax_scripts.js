function loadHobbies() {
  $("#hobby-list").load("ajax/hobbies_fetch.php");
}

// Add
$(document).on("submit", "#add-hobby-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/hobbies.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-hobby-form')[0].reset();
        loadHobbies();
        Swal.fire('Success!', 'Hobby added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add hobby.', 'error');
      }
    }
  });
});

// Edit hobby
$(document).on("submit", ".hobby-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/hobbies.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'Hobby updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete hobby
$(document).on("click", ".delete-hobby", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the hobby permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/hobbies.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadHobbies();
          Swal.fire('Deleted!', 'Hobby removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load hobbies on page ready
$(document).ready(function () {
  loadHobbies();
});

/* TV SHOWS ---------------------------------------------------------------------- */
function loadTv() {
  $("#tv-list").load("ajax/tv_fetch.php");
}

// Add
$(document).on("submit", "#add-tv-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/tv.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-tv-form')[0].reset();
        loadTv();
        Swal.fire('Success!', 'Tv show added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add tv show.', 'error');
      }
    }
  });
});

// Edit
$(document).on("submit", ".tv-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/tv.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'TV show updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete
$(document).on("click", ".delete-tv", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the tv show permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/tv.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadTv();
          Swal.fire('Deleted!', 'Tv show removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load hobbies on page ready
$(document).ready(function () {
  loadTv();
});


/* MOVIES ---------------------------------------------------------------------- */
function loadMovie() {
  $("#movie-list").load("ajax/movie_fetch.php");
}

// Add
$(document).on("submit", "#add-movie-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/movie.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-movie-form')[0].reset();
        loadMovie();
        Swal.fire('Success!', 'Movie added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add movie.', 'error');
      }
    }
  });
});

// Edit
$(document).on("submit", ".movie-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/movie.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'Movie updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete
$(document).on("click", ".delete-movie", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the movie permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/movie.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadTv();
          Swal.fire('Deleted!', 'Movie removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load on page ready
$(document).ready(function () {
  loadMovie();
});



/* MUSIC ARTIST ---------------------------------------------------------------------- */
function loadArtist() {
  $("#artist-list").load("ajax/artist_fetch.php");
}

// Add
$(document).on("submit", "#add-artist-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/artist.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-artist-form')[0].reset();
        loadArtist();
        Swal.fire('Success!', 'Artist added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add artist.', 'error');
      }
    }
  });
});

// Edit
$(document).on("submit", ".artist-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/artist.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'Artist updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete
$(document).on("click", ".delete-artist", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the artist permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/artist.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadArtist();
          Swal.fire('Deleted!', 'Artist removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load on page ready
$(document).ready(function () {
  loadArtist();
});


/* BOOK ---------------------------------------------------------------------- */
function loadBook() {
  $("#book-list").load("ajax/book_fetch.php");
}

// Add
$(document).on("submit", "#add-book-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/book.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-book-form')[0].reset();
        loadBook();
        Swal.fire('Success!', 'Book added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add book.', 'error');
      }
    }
  });
});

// Edit
$(document).on("submit", ".book-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/book.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'Book updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete
$(document).on("click", ".delete-book", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the book permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/book.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadBook();
          Swal.fire('Deleted!', 'Book removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load on page ready
$(document).ready(function () {
  loadBook();
});

/* OTHERS ---------------------------------------------------------------------- */
function loadOther() {
  $("#other-list").load("ajax/other_fetch.php");
}

// Add
$(document).on("submit", "#add-other-form", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/other.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        $('#add-other-form')[0].reset();
        loadOther();
        Swal.fire('Success!', 'Interest added.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to add interest.', 'error');
      }
    }
  });
});

// Edit
$(document).on("submit", ".other-item", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    method: "POST",
    url: "ajax/other.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      if (res.success) {
        Swal.fire('Updated!', 'Interest updated.', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to update.', 'error');
      }
    }
  });
});

// Delete
$(document).on("click", ".delete-other", function () {
  const form = $(this).closest("form");
  const id = form.find("input[name='id']").val();

  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the item permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/other.php", { id: id, action: 'delete' }, function (res) {
        if (res.success) {
          loadBook();
          Swal.fire('Deleted!', 'Item removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });
});

// Load on page ready
$(document).ready(function () {
  loadOther();
});


// UPLOAD IMAGES IN GALLERY -------------------------------------------------------------
function loadPhotoGallery() {
    $("#photoGallery").load("ajax/photo_gallery_fetch.php", function () {
        if (window.feather) {
            feather.replace(); // Replaces icons after loading
        }
    });
}

// Add
document.getElementById('uploadBtn').addEventListener('click', function(e) {
    e.preventDefault(); //make the form no refresh
    document.getElementById('fileInput').click(); //this triggers d hidden input
});
document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert("Maximum file size is 2MB");
        return;
    }

    const formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'save');

    $.ajax({
        method: "POST",
        url: "ajax/photo_gallery.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.success) {
                loadPhotoGallery();
                Swal.fire('Success!', 'Photo added.', 'success');
            } else {
                Swal.fire('Error', res.message || 'Failed to add photo.', 'error');
            }
        }
    });
});

//delete
$(document).on("click", ".delete-photo", function (e) {
  e.preventDefault();
  const photoId = $(this).data('id');

    Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the photo permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("ajax/photo_gallery.php", { id: photoId, action: 'delete' }, function (res) {
        if (res.success) {
          loadPhotoGallery();
          Swal.fire('Deleted!', 'Photo removed.', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to delete.', 'error');
        }
      }, 'json');
    }
  });

});

//set as profile
$(document).on("click", ".set-profile", function (e) {
  e.preventDefault();
  const photoId = $(this).data('id');
  const formData = new FormData();
  formData.append('action', 'set_profile');
  formData.append('id', photoId);
  $.ajax({
      method: "POST",
      url: "ajax/photo_gallery.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
          if (res.success) {
              Swal.fire('Success!', 'Photo set as profile photo. Refresh to view new photo', 'success');
          } else {
              Swal.fire('Error', res.message || 'Failed to set photo.', 'error');
          }
      }
  });

});

//set as background
$(document).on("click", ".set-background", function (e) {
  e.preventDefault();
  const photoId = $(this).data('id');
  const formData = new FormData();
  formData.append('action', 'set_background');
  formData.append('id', photoId);
  $.ajax({
      method: "POST",
      url: "ajax/photo_gallery.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
          if (res.success) {
              Swal.fire('Success!', 'Photo set as cover photo. Refresh to view new photo', 'success');
          } else {
              Swal.fire('Error', res.message || 'Failed to set photo.', 'error');
          }
      }
  });

});

// Load on page ready
$(document).ready(function () {
  loadPhotoGallery();
});

