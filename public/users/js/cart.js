function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data("url");
    let that = $(this);
    Swal.fire({
        title: "Are you sure?",
        text: "Bạn chắc chắn muốn xóa sản phẩm này!!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đúng, xóa nó!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlRequest,
                method: "get",
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        //Phải tạo biến lưu button click vì nếu bỏ vào function con $(this) sẽ k hiểu
                        if (data.num > 0) {
                            setInterval(function () {
                                $("#dropdown-cart-wp").load(
                                    location.href + " #dropdown-cart-wp"
                                );
                            }, 2000);
                            $(".num-total").text(data.num);
                            $(".total-cart").text(data.total + "đ");
                            that.parent().parent().remove();
                            Swal.fire(
                                "Đã xóa thành công!",
                                "Bản ghi của bạn đã xóa thành công!!!",
                                "success"
                            );
                        } else {
                            location.reload();
                        }
                    }
                },
                error: function () {},
            });
        }
    });
}

function updateProductCart(rowId, qty) {
    var urlUpdate = $(".num-product-wp").data("url");
    $.ajax({
        url: urlUpdate,
        method: "GET",
        data: { rowId: rowId, qty: qty },
        dataType: "json",
        success: function (data) {
            if (data.code == 200) {
                $("#sub-total-" + rowId + "").text(data.subTotal + "đ");
                setInterval(function () {
                    $("#dropdown-cart-wp").load(
                        location.href + " #dropdown-cart-wp"
                    );
                }, 2000);
                $(".num-total").text(data.num);
                $(".total-cart").text(data.total + "đ");
            }
        },
    });
}

$(document).ready(function () {
    $(document).on("click", ".action_delete", actionDelete);

    $(".num-product-wp .plus").click(function () {
        $(this).parent().find(".minus").removeClass("disabled");
        var input_num = $(this).prev("input[name=num-order-cart]");
        var value = parseInt(input_num.attr("value"));
        value++;
        var rowId = input_num.data("rowid");
        input_num.attr("value", value);
        updateProductCart(rowId, value);
    });
    $(".num-product-wp .minus").click(function () {
        var input_num = $(this).next("input[name=num-order-cart]");
        var value = parseInt(input_num.attr("value"));
        if (value > 1) {
            value--;
            var rowId = input_num.data("rowid");
            input_num.attr("value", value);
            updateProductCart(rowId, value);
        }
        if (value == 1) {
            $(this).addClass("disabled");
        }
    });
});
