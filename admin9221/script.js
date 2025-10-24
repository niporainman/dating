function loadData() {
    $("#data").load("ajax/" + pageTitleUrl + "fetch.php");
}

$(document).ready(function () {
    loadData();
});

// Handle form button click
$(document).on("click", "#theForm button[type=submit]", function () {
    $("#theForm button[type=submit]").removeAttr("clicked");
    $(this).attr("clicked", "true");
});

$("#theForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var actionType = $("#theForm button[type=submit][clicked=true]").val();
    formData.append('action', actionType);

    $.ajax({
        method: "POST",
        url: "ajax/" + pageName,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response
            });
            $("#theForm")[0].reset();
            $('.summernote').summernote('code', '');
            loadData();
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Upload failed',
                text: 'Something went wrong!'
            });
        }
    });
});

function initializeSummernote(selector) {
    $(selector).summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['insert', ['grid']]
        ],
        grid: {
            wrapper: "row",
            columns: [
                "col-md-12",
                "col-md-6",
                "col-md-4",
                "col-md-3",
            ]
        },
        callbacks: {
            onImageUpload: function (files) {
                const editor = $(this);
                const formData = new FormData();
                formData.append("file", files[0]);

                $.ajax({
                    url: "upload-image.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        try {
                            const res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res.url) {
                                editor.summernote('insertImage', res.url);
                            } else {
                                alert("Upload succeeded but no URL returned.");
                            }
                        } catch (e) {
                            alert("Upload failed: Invalid response from server.");
                            console.error("Invalid response:", response);
                        }
                    },
                    error: function () {
                        alert("Image upload failed.");
                    }
                });
            }
        },
        icons: {
            grid: "glyphicon glyphicon-th"
        }
    });
}

// Initialize summernote on ready
$(document).ready(function () {
    initializeSummernote('.summernote');
});

// Re-initialize summernote on modal open
$(document).on('shown.bs.modal', function (e) {
    const $modal = $(e.target);
    $modal.find('.summernote').each(function () {
        $(this).summernote('destroy');
        initializeSummernote(this);
    });
});
