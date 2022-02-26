$(document).ready(function () {
    var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function (e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            $(wrapper).append(
                // '<div class="form-group d-flex">' +
                //     '<input type="text" class="form-control col-md-4" name="name_color[]" placeholder="Nhập màu sản phẩm">' +
                //     '<input type="file" class="form-control-file col-md-6" name="image_color_path[]">' +
                //     '<a href="javascript;:" class="btn btn-danger remove_field">Remove</a>' +
                //     "</div>"

                '<div class="form-row">' +
                    '<div class="form-group col-md-4">' +
                    '<input type="text" class="form-control" name="name_color[]" placeholder="Nhập màu sản phẩm">' +
                    "</div>" +
                    '<div class="form-group col-md-6">' +
                    '<input type="file" class="form-control-file" name="image_color_path[]">' +
                    "</div>" +
                    '<div class="form-group col-md-2">' +
                    '<a href="javascript;:" class="btn btn-danger remove_field">Remove</a>' +
                    "</div>" +
                    "</div>"
            ); //add input box
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) {
        //user click on remove text
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
});
