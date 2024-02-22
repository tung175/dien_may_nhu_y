<template>
    <div class="border-top">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-3"><h5>VỀ CHÚNG TÔI</h5>
                    <h6>Điện Máy Như Ý</h6>
                    <ul>
                        <li><i style="color: #ed1c24" class="fas fa-map-marker-alt"></i> 54, Triều Khúc, Thanh Xuân, Hà Nội</li>
                        <li><i style="color: #ed1c24" class="fas fa-phone-alt"></i> (01) 2345 6789</li>
                        <li><i style="color: #ed1c24" class="fas fa-envelope"></i> dienmaynhuy@gmail.com</li>
                        <li class="mt-3"><span style="color:white;background-color:#3b5998;padding: 6px 11px;border-radius:50%;margin-right:6px;cursor:pointer"><i class="fab fa-facebook-f"></i></span>
                        <span style="color:white;background-color:#1da1f2;padding: 6px 9px;border-radius:50%;margin-right:6px;cursor:pointer"><i class="fab fa-twitter"></i></span>
                        <span style="color:white;background-color:#d50c22;padding: 6px 8px;border-radius:50%;margin-right:6px;cursor:pointer"><i class="fab fa-google-plus-g"></i></span></li>
                    </ul>
                </div>
                <div class="col-md-3"><h5>TIN TỨC MỚI</h5>
                    <ul>
                        <li><a href="#">Về Chúng Tôi</a></li>
                        <li><a href="#">Tuyển Dụng</a></li>
                        <li><a href="#">Hợp Tác Bán Hàng</a></li>
                        <li><a href="#">Điều Kiện & Điều Khoản</a></li>
                        <li><a href="#">Quy Chế Quản Lý</a></li>
                        <li><a href="#">Chính Sách Bảo Mật</a></li>
                    </ul>
                </div>
                <div class="col-md-3"><h5>CÂU HỎI THƯỜNG GẶP</h5>
                <ul>
                        <li><a href="#">Hỏi Đáp</a></li>
                        <li><a href="#">Liên Hệ</a></li>
                        <li><a href="#">Biểu Phí Giao Hàng</a></li>
                        <li><a href="#">Thẻ Quà Tặng</a></li>
                        <li><a href="#">Danh Mục Sản Phẩm</a></li>
                        <li><a href="#">Kiểm Tra Đơn Hàng</a></li>
                    </ul></div>
                <div class="col-md-3"><h5>CHÍNH SÁCH</h5>
                    <ul>
                        <li><a href="">Chính Sách Bảo Mật</a></li>
                        <li><a href="">Chính Sách Vận Chuyển</a></li>
                        <li><a href="">Chính Sách Bảo Hành</a></li>
                        <li><a href="">Chính Sách Đổi Hàng</a></li>
                        <li><a href="">Quy Định</a></li>
                        <li><a href="">Quy Định Thanh Toán</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="copyright mt-4">
            <div class="container text-center alight-item-center">
                Copyright © 2022 by <a target="_blank" href="https://facebook.com/doloi01">DoLoi</a>   
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
           
        }
    }
}
</script>
<style scoped>
    .border-top {
        background-color: rgb(251, 251, 251);
    }
    h5 {
        font-weight: bolder;
        color: #424242;
    }
    ul {
        list-style: none;
        padding: 0;
        margin-top: 10px;
    }
    ul>li {
        font-weight: 600;
        padding: 2px 0px;
    }    
    a {
        text-decoration: none;
        color: #616161;  
    }
    a:hover {
        color: #ed1c24;
        cursor: pointer;
    }
    .copyright {
        height: 56px;
        background: #f1f1f1;
        line-height: 56px;
    }
</style>