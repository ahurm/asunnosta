// CKEditor API
ClassicEditor.create(document.querySelector("#editor"), {
    removePlugins: ["Heading", "Link"],
    toolbar: ["bold", "italic", "bulletedList", "numberedList", "undo", "redo"]
}).catch(error => {
    console.log(error);
});

// bootstrap-multiselect for multiselect dropdowns
$(document).ready(function() {
    $("#apartment-type").multiselect({
        buttonContainer: '<div class="btn-group" />',
        buttonClass: "btn btn-light"
    });
    $("#room-amount").multiselect();
    $("#sortby").multiselect();
});

