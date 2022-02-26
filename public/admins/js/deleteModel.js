function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data("url");
    let that = $(this);
    Swal.fire({
        title: "Are you sure?",
        text: "Bạn chắc chắn muốn xóa bản ghi này!!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đúng, xóa nó!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlRequest,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        //Phải tạo biến lưu button click vì nếu bỏ vào function con $(this) sẽ k hiểu
                        that.parent().parent().remove();
                        Swal.fire(
                            "Đã xóa thành công!",
                            "Bản ghi của bạn đã xóa thành công!!!",
                            "success"
                        );
                    }
                },
                error: function () {},
            });
        }
    });
}
$(document).ready(function () {
    $(document).on("click", ".action_delete", actionDelete);
});
