$(document).ready(function () {
    $(".desc .product-color").click(function () {
        $(".desc .product-color.active").removeClass("active");
        $(this).find("input[name=check-color-detail]").prop("checked", true);
        $(this).addClass("active");
    });

    $(".show_hide").on("click", function (e) {
        e.preventDefault();
        $(".product-detail").removeClass("detail-hide");
        $(this).parent().hide();
    });

    $(".info .add-cart>a").click(function (event) {
        event.preventDefault();
        var productColorId = $("input[name=check-color-detail]:checked").val(); //Tìm input radio được check
        var num = $("#num-order-detail-wp input[name=num-order]").val();
        var href = $(this).attr("href");

        var urlImg = $(".product-color.active")
            .children(".img-detail-product")
            .find("img")
            .attr("src");
        $.ajax({
            url: href,
            method: "GET",
            data: {
                productColorId: productColorId,
                num: num,
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    //Gán urlImg vào src
                    $(".modal-body img.img_product_modal").attr("src", urlImg);
                    $(".modal-body .title_modal>b").html(data.name);

                    //Thiết lập load lại dropdown
                    setInterval(function () {
                        $("#dropdown-cart-wp").load(
                            location.href + " #dropdown-cart-wp"
                        );
                    }, 2000);
                    $(".num-total").text(data.num);

                    $("#modal-notification").modal("show");
                }
            },
        });
    });
});
