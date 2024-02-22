<template>
    <div>
        <div class="container d-flex justify-content-center">
            <div class="col-md-12">
                <div class="row mt-2 mb-2">
                    <div class="col-md-7" style="font-weight: 600">
                        <router-link :to="{ name: 'user.home' }">
                            <i class="fas fa-angle-left"></i> Mua thêm sản phẩm
                            khác</router-link
                        >
                    </div>
                    <div class="col-md-5 text-right">Lịch sử đơn hàng</div>
                </div>
                <div
                    class="row shadow rounded bg-white mb-5 d-flex justify-content-center"
                    style="min-height: 500px"
                >
                    <div class="col-md-12" style="overflow-x: auto;" v-if="logged">
                        <button @click="deleteCookie()" class="btn btn-sm btn-danger float-right my-2">Thoát tài khoản</button>
                    <b-table
                                    :items="orders"
                                    :fields="fields"
                                    :per-page="perPage"
                                    :current-page="currentPage"
                                    :filter="filter"
                                    @filtered="onFiltered"
                                >
                                    
                                    <template #cell(status)="row">
                                        <span v-if="row.item.status == 0">
                                            <span class="badge badge-danger">
                                                Chờ xử lý
                                            </span>
                                        </span>
                                        <span v-else-if="row.item.status == 1">
                                            <span class="badge badge-warning">
                                                Đã xử lý
                                            </span>
                                        </span>
                                        <span v-else-if="row.item.status == 2">
                                            <span class="badge badge-success">
                                                Đã hoàn thành
                                            </span>
                                        </span>
                                    </template>
                                  
                                    <template #cell(action)="row">
                                         <span @click="row.toggleDetails">
                                            <i
                                                class="fas fa-eye fa-lg"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Xem chi tiết'
                                                "
                                            ></i>
                                        </span>
                                    </template>
                                    <template #row-details="row">
                                        <b-card>
                                            <ul>
                                                <li>
                                                    Yêu cầu khác:
                                                    {{row.item.note}}
                                                </li>
                                                <li>
                                                    Người nhận hộ:
                                                    {{row.item.otherpeople_gender}} {{row.item.otherpeople_name}}
                                                </li>
                                                <li>
                                                    SĐT người nhận: 
                                                    {{row.item.otherpeople_phone}}
                                                </li>
                                                <li>
                                                    Chi tiết đơn hàng:
                                                    <table>
                                                        <tr>
                                                            <th>Mã sản phẩm</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Số lượng</th>
                                                            <th>Đơn giá</th>
                                                        </tr>
                                                        <tr v-for="item in getOrderDetails(row.item.id)" :key="item.id">
                                                            <td>{{item.product.code}}</td>
                                                            <td>{{item.product.name}}</td>
                                                            <td>{{item.quantity}}</td>
                                                            <td>{{ formatPrice(item.product.price)}}₫</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Tổng tiền:</td>
                                                            <td class="font-weight-bold">{{ formatPrice(getTotalPrice(row.item.id))}}₫</td>
                                                        </tr>
                                                    </table>
                                                </li>
                                               
                                            </ul>
                                        </b-card>
                                    </template>
                                </b-table>
                                <b-row class="mt-3">
                                    <b-col md="8"></b-col>
                                    <b-col md="4">
                                        <b-pagination
                                            v-model="currentPage"
                                            :total-rows="totalRows"
                                            :per-page="perPage"
                                            align="fill"
                                            class="my-0"
                                        ></b-pagination>
                                    </b-col>
                                </b-row>    
                    </div>
                    <div class="col-md-4 mt-5 text-center" v-if="!logged">
                        <img src="https://www.dienmayxanh.com/lich-su-mua-hang/images/i1.png" width="100%">
                        <input type="text" v-show="!showInputOtp" v-model="phone" maxlength="10" class="form-control mt-3" placeholder="Nhập số điện thoại mua hàng">
                        <input type="text" v-show="showInputOtp" v-model="otp" class="form-control mt-3" :placeholder="'Nhập mã xác nhận đã được gửi đến ' + phone">
                        <button class="btn btn-primary w-50 mt-3" @click="next()">TIẾP TỤC</button>
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
     components: {Loading},
    data() {
        return {
            phone: '',
            showLoading: true,
            logged: false,
            showInputOtp: false,
            otp: '',
            orders: [],
            orderDetails: [],
            selected: [],
            allSelected: false,
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            filter: null,
            fields: [
               
                {
                    key: "stt",
                    label: "STT",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "customer.gender",
                    label: "Danh xưng",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "customer.name",
                    label: "Họ tên",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "customer.phone",
                    label: "SĐT",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "address",
                    label: "Địa chỉ",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "way_receive",
                    label: "Hình thức nhận",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "payment",
                    label: "Hình thức thanh toán",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "created_at",
                    label: "Ngày đặt",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "status",
                    label: "Trạng thái",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "action",
                    label: "Hành động",
                    class: "text-center align-middle",
                },
                
            ],
            
            selectedFilter: ["0","1","2"],
            optionsFilter: [
                {
                    text: "Chờ xử lý",
                    value: 0,
                },
                {
                    text: "Đã xử lý",
                    value: 1,
                },
                {
                    text: "Đã hoàn thành",
                    value: 2,
                },
            ],
        };
    },
    created() {
        this.getOrders();
    },
    methods: {
        getOrders() {
            axios
                .get("/api/orders")
                .then((response) => {
                    if (this.checkExistCookie()) {
                        this.orders = response.data.filter(
                            (item) => item.customer.phone == this.getCookie("DienMay_user_account")
                        );
                        this.logged = true;
                    } else {
                        this.orders = response.data;
                    }
                    this.totalRows = this.orders.length;
                    this.showLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
       
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 10;
        },
       
        getOrderDetails(order_id) {
            return this.orderDetails.filter((item) => item.order_id == order_id);
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        getTotalPrice(order_id) {
            let total = 0;
            this.orderDetails.forEach((item) => {
                if (item.order_id == order_id) {
                    total += item.product.price * item.quantity;
                }
            });
            return total;
        },
        getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        checkExistCookie() {
            let cart = this.getCookie("DienMay_user_account");
            if (cart != "") {
                return true;
            } else {
                return false;
            }
        },
        setCookie() {
            if (!this.checkExistCookie()) {
                const d = new Date();
                d.setTime(d.getTime() + (365*24*60*60*1000)); // 365 ngày
                let expires = "expires="+ d.toUTCString();
                if (!this.otp) {
                    axios.post("/api/customers", {
                        phone: this.phone,
                    }).then((res) => {
                    }).catch((err) => {
                        this.$swal({
                            title: "Thông báo",
                            text: "Số điện thoại chưa mua hàng trước đó",
                            icon: "error",
                            button: "Đóng",
                        }).then((value) => {
                            this.$router.push("/");
                        });
                    });
                } else if (this.otp != '') {
                    axios.post("/api/customers", {
                        phone: this.phone,
                        otp: this.otp,
                    }).then((res) => {
                        document.cookie = 'DienMay_user_account' + "=" + this.phone + ";" + expires + ";path=/";
                        this.orders = this.orders.filter((item) => item.customer.phone == this.phone);
                        this.$router.go(0);
                  }).catch((err) => {
                        this.$swal({
                            title: "Thông báo",
                            text: "Mã xác nhận không chính xác",
                            icon: "error",
                            button: "Đóng",
                        }).then((value) => {
                        });
                    });
                }
            } else {
                this.logged = true;
                this.orders = this.orders.filter((item) => item.customer.phone == this.getCookie("DienMay_user_account"));
            }
        },
        next() {
            this.showInputOtp = true;
            this.setCookie();
        },
        deleteCookie() {
            document.cookie = "DienMay_user_account=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            this.$router.push("/");
        }
    },
    mounted() {
        axios.get('/api/orderdetails').then((response) => {
            this.orderDetails = response.data;
        });
    }
};
</script>