<div class="modal fade" id="modal-product-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="info-product">
                    {{-- <h5 class="modal-title">Samsung J7 prime</h5>
                    <h6 class="modal-price">27.000.000đ</h6> --}}
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="choose-color">
                            <h5 class="choose-title">Chọn màu:</h5>
                            <div class="desc d-flex">
                                {{-- <div class="product-color">
                                    <div class='img'>
                                        <img src="{{ asset('public/uploads/product/1/xiaomi-redmi-note-10-xanh.jpg') }}"
                                            alt=''>
                                        <input type=" radio" name="check-color" value="" />
                                        <p class="color-name">Trắng</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="choose-num">
                            <h5 class="choose-title">Chọn số lượng:</h5>
                            <div id="num-order-cart-wp">
                                <a title="" class="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" class="num-order"
                                    disabled="disabled">
                                <a title="" class="plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-outline-primary product-cart">Thêm giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
