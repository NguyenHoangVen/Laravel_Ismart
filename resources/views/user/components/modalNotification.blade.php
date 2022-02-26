<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm sản phẩm vào giỏ hàng thành công</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="alert-pro-name">
                <div class="row">
                    <div class="col-3">
                        <img class="img_product_modal" src="" alt="">
                    </div>
                    <div class="col-9 d-table">
                        <p class="title_modal">Sản phẩm <b></b> được thêm vào giỏ hàng.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('cart.show') }}" class="btn btn-outline-primary">Xem giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
