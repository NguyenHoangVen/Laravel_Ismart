$(document).ready(function () {
    $(".check_parent_group").click(function () {
        //Gán checked của .check_child dựa vào checked của cha là .check_parent dựa vào phương thức prop()
        //Nếu .check_parent checked --> true prop('checked', true) ngước lại là false
        var v = $(this).val();
        $(this)
            .parents(".card")
            .find("input.check_child_" + v + "")
            .prop("checked", $(this).prop("checked"));
    });
});

$(".checkall").click(function () {
    $(this)
        .parents()
        .find("input[type=checkbox]")
        .prop("checked", $(this).prop("checked"));
});
