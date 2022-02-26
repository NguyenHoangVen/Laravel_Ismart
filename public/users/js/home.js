$(document).ready(function () {
    $(".section-detail .list-item .add-cart").click(function (event) {
        event.preventDefault();
        var href = $(this).attr("href");
        var hrefCart = $(this).data("url");
        var infoProduct = $(".modal-content .modal-header .info-product");
        var colorProduct = $(".modal-body .choose-color .desc");
        $.ajax({
            url: href,
            method: "GET",
            data: {},
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var product = data.product;
                    // Insert info product
                    $(infoProduct).html(
                        '<h5 class="modal-title">' +
                        product.name +
                        "</h5>" +
                        '<h6 class="modal-price">' +
                        data.priceProduct +
                        "đ</h6>"
                    );

                    // Insert color product
                    $(colorProduct).html(data.txt);

                    //Show modal
                    $("#modal-product-cart").modal("show");
                    //Active color
                    $(".desc .product-color").click(function () {
                        $(".desc .product-color.active").removeClass("active");
                        $(this)
                            .find("input[name=check-color-cart]")
                            .prop("checked", true);
                        $(this).addClass("active");
                    });

                    $(".modal-footer .product-cart").attr("href", hrefCart);

                    //Reset lại num-order khi ẩn modal
                    $("#modal-product-cart").on("hide.bs.modal", function () {
                        $("#num-order-cart-wp .num-order").attr("value", 1);
                    });
                }
            },
        });
    });

    $(".modal-footer .product-cart").click(function (event) {
        event.preventDefault();
        var productColorId = $("input[name=check-color-cart]:checked").val(); //Tìm input radio được check
        var num = $("#num-order-cart-wp input[name=num-order]").val();
        var href = $(this).attr("href");
        var urlImg = $(".product-color.active")
            .children(".img-product")
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
                    //An Modal cũ
                    $("#modal-product-cart").modal("hide");
                    //Gán urlImg vào src
                    $(".modal-body img.img_product_modal").attr("src", urlImg);
                    $(".modal-body .title_modal>b").html(data.name); //Gán name cho product
                    //Thiết lập load lại dropdown
                    setInterval(function () {
                        $("#dropdown-cart-wp").load(
                            location.href + " #dropdown-cart-wp"
                        );
                    }, 2000);

                    $(".num-total").text(data.num); //gán Số lượng đơn hàng

                    //Hiện modal thông báo
                    $("#modal-notification").modal("show");
                }
            },
        });
    });

    $("#search").keyup(function () {
        var href = $(this).data("url");
        var kw = $(this).val();
        if (kw != "") {
            $.ajax({
                url: href,
                method: "GET",
                data: { kw: kw },
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        $("#results-search").fadeIn();
                        $("#results-search").html(data.text);
                    }
                },
            });
        } else {
            $("#results-search").fadeOut();
        }
    });
});
