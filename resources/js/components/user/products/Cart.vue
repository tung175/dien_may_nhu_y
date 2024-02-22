<template>
    <div>
        <div class="container d-flex justify-content-center">
            <div class="col-md-6">
                <div class="row mt-2 mb-2">
                    <div class="col-md-7" style="font-weight: 600">
                        <router-link :to="{ name: 'user.home' }">
                            <i class="fas fa-angle-left"></i> Mua thêm sản phẩm
                            khác</router-link
                        >
                    </div>
                    <div class="col-md-5 text-right">Giỏ hàng của bạn</div>
                </div>
                <div
                    class="row shadow rounded bg-white mb-5"
                    style="min-height: 500px"
                >
                    <div class="col-md-12">
                        <div v-for="(item, index) in carts" :key="item.id">
                            <div
                                class="row p-3"
                                :class="{
                                    'border-bottom': !(
                                        index ===
                                        carts.length - 1
                                    ),
                                }"
                            >
                                <div
                                    class="col-md-1"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        max-width: 36px;
                                    "
                                >
                                    <h6 class="m-0">
                                        <i
                                            v-b-tooltip.hover.left
                                            title="Xóa"
                                            @click="deleteCart(item.id)"
                                            class="fas fa-times-circle"
                                        ></i>
                                    </h6>
                                </div>
                                <router-link
                                    :to="`/products/${item.product.id}`"
                                    tag="div"
                                    class="col-md-2 noselect"
                                >
                                    <img
                                        width="100%"
                                        :src="item.product.image"
                                    />
                                </router-link>
                                <router-link
                                    :to="`/products/${item.product.id}`"
                                    tag="div"
                                    class="col-md-6 noselect"
                                >
                                    <h6 class="font-weight-bold mt-2">
                                        {{ item.product.name }}
                                        {{ item.product.code }}
                                    </h6>
                                    <p style="color:black !important">Màu: {{ getColorByProductId(item.product.id) }}</p>
                                </router-link>
                                <div class="col-md-3 pr-0">
                                    <h6
                                        class="text-danger font-weight-bold text-right mt-2"
                                    >
                                        {{ formatPrice(item.product.price) }}₫
                                    </h6>
                                    <div
                                        class="wrapper-quantity mt-2 float-right"
                                    >
                                        <span
                                            class="minus noselect"
                                            @click="minusQuantity(item.id)"
                                            >-</span
                                        >
                                        <span class="num">{{
                                            item.quantity
                                        }}</span>
                                        <span
                                            class="plus noselect"
                                            @click="plusQuantity(item.id)"
                                            >+</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-2 px-3 border-bottom">
                            <div class="col-md-6">
                                Tạm tính ({{ carts.length }} sản phẩm):
                            </div>
                            <div class="col-md-6 text-right">
                                <h6 class="font-weight-bold">
                                    {{
                                        formatPrice(
                                            carts.reduce(
                                                (accumulator, current) =>
                                                    accumulator +
                                                    current.product.price *
                                                        current.quantity,
                                                0
                                            )
                                        )
                                    }}₫
                                </h6>
                            </div>
                        </div>

                        <div class="row border-bottom p-3 pb-4">
                            <h6>THÔNG TIN KHÁCH HÀNG</h6>
                            <div class="col-md-12">
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="man"
                                    v-model="form.gender"
                                    value="Anh"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="man"
                                    >Anh</label
                                >
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="woman"
                                    v-model="form.gender"
                                    value="Chị"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="woman"
                                    >Chị</label
                                >
                                <span v-if="errors.gender == true" class="text-danger">Vui lòng chọn danh xưng</span>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row mt-2">
                                    <div class="form-group col-md-6">
                                        <input
                                            type="text"
                                            v-model="form.name"
                                            class="form-control"
                                            id="inputEmail4"
                                            placeholder="Họ và tên"
                                        />
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-if="errors.name == true"
                                        >
                                            Vui lòng nhập họ và tên
                                        </h6>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input
                                            type="text"
                                            v-model="form.phone"
                                            class="form-control"
                                            id="inputPassword4"
                                            @keyup="validatePhoneNumber('phone')"
                                            maxlength="10"
                                            placeholder="Số điện thoại"
                                        />
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-if="
                                                !validatePhoneNumber('phone') &&
                                                form.phone.toString().length > 0
                                            "
                                        >
                                            Số điện thoại không hợp lệ
                                        </h6>
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-else-if="errors.phone == true && form.phone.toString().length == 0"
                                        >
                                            Vui lòng nhập số điện thoại
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <h6>CHỌN CÁCH THỨC NHẬN HÀNG</h6>
                            <div class="col-md-12">
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="receive1"
                                    v-model="form.wayReceive"
                                    value="Giao tận nơi"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="receive1"
                                    >Giao tận nơi</label
                                >
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="receive2"
                                    v-model="form.wayReceive"
                                    value="Nhận tại siêu thị"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="receive2"
                                    >Nhận tại siêu thị</label
                                >
                                <span v-if="errors.wayReceive == true" class="text-danger">Vui lòng chọn cách thức nhận hàng</span>
                                <div
                                    v-if="form.wayReceive == 'Giao tận nơi'"
                                    class="mt-2"
                                >
                                    <div class="p-3 border rounded bg-light">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <b-form-select
                                                    v-model="selectedProvince"
                                                    value-field="id"
                                                    text-field="name"
                                                    :options="provinceOptions"
                                                    @change="getDistricts()"
                                                >
                                                    <template #first>
                                                        <b-form-select-option
                                                            :value="null"
                                                            disabled
                                                            >Chọn Tỉnh / Thành
                                                            Phố</b-form-select-option
                                                        >
                                                    </template></b-form-select
                                                >
                                            </div>
                                            <div class="col-md-6">
                                                <b-form-select
                                                    v-model="selectedDistrict"
                                                    value-field="id"
                                                    text-field="name"
                                                    :options="districtOptions"
                                                    :disabled="disableDistrict"
                                                    @change="getWards()"
                                                >
                                                    <template #first>
                                                        <b-form-select-option
                                                            :value="null"
                                                            disabled
                                                            >Chọn Quận /
                                                            Huyện</b-form-select-option
                                                        >
                                                    </template></b-form-select
                                                >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b-form-select
                                                    v-model="selectedWard"
                                                    :options="wardOptions"
                                                    value-field="id"
                                                    text-field="name"
                                                    :disabled="disableWard"
                                                    @change="
                                                        disableAddress == true
                                                            ? (disableAddress = false)
                                                            : null
                                                    "
                                                    ><template #first>
                                                        <b-form-select-option
                                                            :value="null"
                                                            disabled
                                                            >Chọn Phường /
                                                            Xã</b-form-select-option
                                                        >
                                                    </template>
                                                </b-form-select>
                                            </div>
                                            <div class="col-md-6">
                                                <b-form-input
                                                    v-model="form.address"
                                                    :disabled="disableAddress"
                                                    placeholder="Số nhà, tên đường"
                                                ></b-form-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-if="errors.address == true"
                                        >
                                            Vui lòng nhập địa chỉ nhận hàng
                                        </h6>
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <input
                                            type="text"
                                            v-model="form.note"
                                            class="form-control"
                                            placeholder="Yêu cầu khác (không bắt buộc)"
                                        />
                                    </div>
                                    <div
                                        class="col-md-12 mt-3"
                                        v-if="form.wayReceive == 'Giao tận nơi'"
                                    >
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                v-model="form.otherPeopleReceive"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <label
                                                class="form-check-label noselect"
                                                for="flexCheckDefault"
                                            >
                                                Gọi người khác nhận hàng (nếu
                                                có)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div v-if="form.otherPeopleReceive == true" class="col-md-12 mt-2 bg-light border rounded px-3 py-2 pb-1">
                                    <div class="col-md-12">
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="man2"
                                    v-model="form.otherPeopleGender"
                                    value="Anh"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="man2"
                                    >Anh</label
                                >
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="woman2"
                                    v-model="form.otherPeopleGender"
                                    value="Chị"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="woman2"
                                    >Chị</label
                                >
                                <span v-if="errors.otherPeopleGender == true" class="text-danger">Vui lòng chọn danh dưng người nhận</span>
                            </div>
                                    <div class="form-row mt-2">
                                    <div class="form-group col-md-6">
                                        <input
                                            type="text"
                                            v-model="form.otherPeopleName"
                                            class="form-control"
                                            id="inputEmail4"
                                            placeholder="Họ và tên người nhận"
                                        />
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                           v-if="errors.otherPeopleName == true"
                                        >
                                            Vui lòng nhập họ và tên người nhận
                                        </h6>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input
                                            type="text"
                                            v-model="form.otherPeoplePhone"
                                            class="form-control"
                                            id="inputPassword4"
                                            @keyup="validatePhoneNumber('otherPeoplePhone')"
                                            maxlength="10"
                                            placeholder="Số điện thoại người nhận"
                                        />
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-if="
                                                !validatePhoneNumber('otherPeoplePhone') &&
                                                form.otherPeoplePhone.toString().length > 0
                                            "
                                        >
                                            Số điện thoại không hợp lệ
                                        </h6>
                                        <h6
                                            class="text-danger m-0 mt-2 pl-2"
                                            v-else-if="errors.otherPeoplePhone == true && form.otherPeoplePhone.toString().length == 0"
                                        >
                                            Vui lòng nhập số điện thoại người nhận
                                        </h6>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <h6 class="mt-3">CHỌN HÌNH THỨC THANH TOÁN</h6>
                             <div class="col-md-12">
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="payment"
                                    v-model="form.payment"
                                    value="Tiền mặt"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="payment"
                                    >Tiền mặt</label
                                >
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="wopayment"
                                    v-model="form.payment"
                                    value="Điện tử"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="wopayment"
                                    >Điện tử</label
                                >
                                <input
                                    type="radio"
                                    class="noselect radio-input"
                                    id="opayment"
                                    v-model="form.payment"
                                    value="Trả góp"
                                />
                                <label
                                    class="m-0 noselect radio-label"
                                    style="margin-right: 16px !important"
                                    for="opayment"
                                    >Trả góp</label
                                >
                                <span v-if="errors.payment == true" class="text-danger">Vui lòng chọn hình thức thanh toán</span>
                            </div>
                        </div>
                        <div class="col-md-12 py-3">
                                <div class="row">
                                <div class="col-md-6 font-weight-bold">
                                    Tổng tiền: 
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-danger text-right font-weight-bold">
                                         {{
                                        formatPrice(
                                            carts.reduce(
                                                (accumulator, current) =>
                                                    accumulator +
                                                    current.product.price *
                                                        current.quantity,
                                                0
                                            )
                                        )
                                    }}₫
                                    </h6>
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                    <button class="btn w-100 text-white" @click="order()" style="font-weight:600;padding: 12px 12px;background: linear-gradient(180deg,#f79429,#f7712e);">ĐẶT HÀNG</button>
                                </div>
                    </div>
                </div>
                
            </div>
        </div>
        <loading
            :active.sync="showLoading"
            :can-cancel="true"
            :is-full-page="true"
        ></loading>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    components: {
        Loading,
    },
    data() {
        return {
            showLoading: true,
            carts: [],
            colors: [],
            form: {
                phone: "",
                name: "",
                otherPeoplePhone: "",
                otherPeopleName: "",
                gender: null,
                otherPeopleGender: null,
                wayReceive: null,
                payment: null,
                address: "",
                otherPeopleReceive: false,
                note: ""
            },
            selectedProvince: null,
            selectedDistrict: null,
            selectedWard: null,
            provinceOptions: [],
            districtOptions: [],
            wardOptions: [],
            disableDistrict: true,
            disableWard: true,
            disableAddress: true,
            errors: {
                gender: false,
                phone: false,
                name: false,
                otherPeoplePhone: false,
                otherPeopleName: false,
                otherPeopleGender: false,
                wayReceive: false,
                payment: false,
                address: false,
            }
        };
    },
    created() {
        this.getCarts();
        this.getProvinces();
        this.getColors();
    },
    methods: {
        getCarts() {
            if (this.getCookie("DienMay_cart_id") != "") {
                axios
                    .post("/api/getCart", {
                        cart_id: this.getCookie("DienMay_cart_id"),
                    })
                    .then((res) => {
                        this.carts = res.data;
                        this.showLoading = false;
                        if (this.carts.length == 0) {
                            this.$swal({
                                title: "Giỏ hàng đang trống",
                                text: "Vui lòng chọn sản phẩm để thêm vào giỏ hàng",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Về trang chủ",
                            }).then((result) => {
                                this.$router.push({ name: "user.home" });
                            });
                        }
                    });
            } else {
                this.$swal({
                    title: "Giỏ hàng đang trống",
                    text: "Vui lòng chọn sản phẩm để thêm vào giỏ hàng",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Về trang chủ",
                }).then((result) => {
                    this.$router.push({ name: "user.home" });
                });
            }
        },
        getColors() {
            axios.get("/api/colors").then((res) => {
                this.colors = res.data;
            });
        },
        getColorByProductId(productId) {
            let color = "";
            this.colors.forEach((item) => {
                if (item.products[0].id == productId) {
                    color = item.name;
                }
            });
            return color;
        },
        formatPrice(price) {
            return price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        },
        getCookie(cookieName) {
            let name = cookieName + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(";");
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == " ") {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        minusQuantity(id) {
            this.showLoading = true;
            axios
                .put(`/api/carts/${id}`, { quantity: "-1" })
                .then((response) => {
                    this.getCarts();
                    this.showLoading = false;
                });
        },
        plusQuantity(id) {
            this.showLoading = true;
            axios
                .put(`/api/carts/${id}`, { quantity: "+1" })
                .then((response) => {
                    this.getCarts();
                    this.showLoading = false;
                });
        },
        deleteCart(id) {
            this.showLoading = true;
            axios.delete(`/api/carts/${id}`).then((response) => {
                this.getCarts();
                this.showLoading = false;
            });
        },
        validatePhoneNumber(string) {
            var regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
            switch (string) {
                case "phone":
                    return regex.test(this.form.phone);
                case "otherPeoplePhone":
                    return regex.test(this.form.otherPeoplePhone);
                default:
                    return false;
            }
        },
        getProvinces() {
            this.selectedDistrict = null;
            this.selectedWard = null;
            this.form.address = "";
            axios.post("/api/getProvinces").then((res) => {
                this.provinceOptions = res.data;
            });
        },
        getDistricts() {
            this.disableWard = true;
            this.disableAddress = true;
            this.selectedDistrict = null;
            this.selectedWard = null;
            this.form.address = "";
            axios
                .post("/api/getDistricts", {
                    province_id: this.selectedProvince,
                })
                .then((res) => {
                    this.districtOptions = res.data;
                    this.disableDistrict = false;
                });
        },
        getWards() {
            this.selectedWard = null;
            this.disableAddress = true;
            this.form.address = "";
            axios
                .post("/api/getWards", { district_id: this.selectedDistrict })
                .then((res) => {
                    this.wardOptions = res.data;
                    this.disableWard = false;
                });
        },
        order() {
            if (!this.validateForm()) {
                return console.log('lỗi');
            }
            axios.post("/api/orders", {
                carts: this.carts,
                form: this.form,
                province_id: this.selectedProvince,
                district_id: this.selectedDistrict,
                ward_id: this.selectedWard,
            }).then((res) => {
                console.log(res.data);
                this.$swal({
                    title: "Đặt hàng thành công",
                    text: "Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Về trang chủ",
                }).then((result) => {
                    this.$router.push({ name: "user.home" });
                });
            }).catch(err => {
                console.log(err);
            });
        },
        validateForm() {
            var i = 0;
            if(!this.form.name) {
                this.errors.name = true;
                i++;
            } else {
                this.errors.name = false;
            }
            if(!this.form.phone) {
                this.errors.phone = true;
                i++;
            } else {
                this.errors.phone = false;
            }
            if(!this.form.gender) {
                this.errors.gender = true;
                i++;
            } else {
                this.errors.gender = false;
            }
            if (!this.form.wayReceive) {
                this.errors.wayReceive = true;
                i++;
            } else {
                this.errors.wayReceive = false;
            }
            if(!this.form.address && this.form.wayReceive == "Giao tận nơi") {
                this.errors.address = true;
                i++;
            } else {
                this.errors.address = false;
            }
            if (this.form.otherPeopleReceive) {
                if(!this.form.otherPeoplePhone) {
                    this.errors.otherPeoplePhone = true;
                    i++;
                } else {
                    this.errors.otherPeoplePhone = false;
                }
                if(!this.form.otherPeopleName) {
                    this.errors.otherPeopleName = true;
                    i++;
                } else {
                    this.errors.otherPeopleName = false;
                }
                if(!this.form.otherPeopleGender) {
                    this.errors.otherPeopleGender = true;
                    i++;
                } else {
                    this.errors.otherPeopleGender = false;
                }
            } 
            if (!this.form.payment) {
                this.errors.payment = true;
                i++;
            } else {
                this.errors.payment = false;
            }
            if (i > 0) {
                return false;
            }
            return true;
        }
    },
};
</script>
<style scoped>
.wrapper-quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    width: 75%;
    height: 32px;
}
.wrapper-quantity span {
    width: 100%;
    text-align: center;
    font-weight: 600;
}
.wrapper-quantity span.num {
    border-left: 1px solid rgba(0, 0, 0, 0.2);
    border-right: 1px solid rgba(0, 0, 0, 0.2);
}
.noselect {
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Old versions of Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none; /* Non-prefixed version, currently
                                    supported by Chrome, Edge, Opera and Firefox */
    cursor: pointer;
}
.noselect:hover {
    color: #288ad6;
}
.fa-times-circle {
    color: rgb(181, 181, 181);
    font-size: 14px;
    cursor: pointer;
}
.fa-times-circle:hover {
    color: rgb(208, 29, 29);
}
input[type="radio"] {
    border: 0px;
    width: 16px;
    height: 21px;
}
.radio-label {
    display: inline-block;
    vertical-align: top;
    margin-right: 3%;
}
.radio-input {
    display: inline-block;
    vertical-align: top;
}
</style>
