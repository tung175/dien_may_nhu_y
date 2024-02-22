<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <Breadcrumbs />

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-3">
                                    Bảng Đơn Đặt Hàng
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="overflow-x: auto;">
                                <b-row>
                                    <b-col>
                                        <b-form-select
                                            id="per-page-select"
                                            style="max-width: 100px"
                                            v-model="perPage"
                                            :options="pageOptions"
                                            v-b-tooltip.hover.v-secondary="
                                                'Số bản ghi trên một trang'
                                            "
                                        ></b-form-select>
                                        <span>
                                            <export-excel
                                                :data="json_data"
                                                class="btn btn-success"
                                                name="Danh sách.xls"
                                                id="export-excel"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Xuất Excel các bản ghi đã chọn'
                                                "
                                            >
                                                <i class="fa fa-file-excel"></i>
                                            </export-excel>
                                        </span>
                                        <span>
                                            <button
                                                class="btn btn-warning"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Xuất PDF các bản ghi đã chọn'
                                                "
                                            >
                                                <i
                                                    class="fas fa-file-pdf"
                                                    @click="exportPdf"
                                                ></i>
                                            </button>
                                        </span>
                                        <button
                                            @click="deleteMutiple"
                                            class="btn-danger btn"
                                            v-b-tooltip.hover.v-secondary="
                                                'Xóa các bản ghi đã chọn'
                                            "
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <div class="mt-3">
                                            <button
                                            @click="handleStatus(2)"
                                            class="btn-success btn"
                                            v-b-tooltip.hover.v-secondary="
                                                'Đã hoàn thành'
                                            "
                                        >
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <button
                                            @click="handleStatus(1)"
                                            class="btn-warning btn"
                                            v-b-tooltip.hover.v-secondary="
                                                'Đã xử lý'
                                            "
                                        >
                                            <i class="fas fa-vote-yea text-white"></i>
                                        </button>
                                        <button
                                            @click="handleStatus(0)"
                                            class="btn-danger btn"
                                            v-b-tooltip.hover.v-secondary="
                                                'Chờ xử lý'
                                            "
                                        >
                                            <i class="fas fa-spinner"></i>
                                        </button>
                                        </div>

                                    </b-col>
                                    <b-col md="4" class="my-1">
                                        <b-form-group>
                                            <b-input-group>
                                                <b-form-input
                                                    id="filter-input"
                                                    v-model="filter"
                                                    type="search"
                                                    placeholder="Nhập từ khóa tìm kiếm"
                                                ></b-form-input>
                                            </b-input-group>
                                        </b-form-group>
                                        <div class="float-right">
                                            
  <input class="form-check-input" type="checkbox" id="check1" v-model="selectedFilter" @change="filterData()" value="0">
  <label class="form-check-label mr-4" for="check1">Chờ xử lý</label>


  <input class="form-check-input" type="checkbox" id="check2" v-model="selectedFilter" @change="filterData()" value="1">
  <label class="form-check-label mr-4" for="check2">Đã xử lý</label>


  <input class="form-check-input" type="checkbox" id="check3" v-model="selectedFilter" @change="filterData()" value="2">
  <label class="form-check-label" for="check3">Đã hoàn thành</label>

                                        </div>
                                    </b-col>
                                </b-row>
                               
                                <b-table
                                    :items="orders"
                                    :fields="fields"
                                    :per-page="perPage"
                                    :current-page="currentPage"
                                    :filter="filter"
                                    @filtered="onFiltered"
                                >
                                    <template #head(checkbox)="">
                                        <b-form-checkbox
                                            @change="selectAll"
                                            v-model="allSelected"
                                            v-b-tooltip.hover.v-secondary
                                            title="Chọn tất cả"
                                        ></b-form-checkbox>
                                    </template>
                                    <template #cell(checkbox)="row">
                                        <b-form-group>
                                            <b-form-checkbox
                                                v-model="selected"
                                                :value="row.item.id"
                                                @change="selectOne"
                                            ></b-form-checkbox>
                                        </b-form-group>
                                    </template>
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
                                        <span
                                            @click="deleteCategory(row.item.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt fa-lg"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Xóa bản ghi'
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
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts.js";
export default {
    data() {
        return {
            orders: [],
            orderDetails: [],
            selected: [],
            allSelected: false,
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100, 500],
            filter: null,
            fields: [
                {
                    key: "checkbox",
                    class: "text-center align-middle",
                    thClass: "mt-5",
                    sortable: false,
                },
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
                    sortable: false,
                },
            ],
            json_data: [],
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8",
                    },
                ],
            ],
            pdf_data: [],
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
            allOrders: []
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
                    this.orders = response.data;
                    this.allOrders = response.data;
                    this.totalRows = this.orders.length;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteCategory(id) {
            this.$swal({
                title: "Bạn chắc chắn muốn xóa?",
                text: "Bạn sẽ không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: "Hủy",
                width: 480,
            })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete("/api/orders/" + id)
                            .then((response) => {
                                this.getCategorys();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.$swal({
                            title: "Đã xóa!",
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            width: 360,
                        });
                        this.getOrders();
                    } else {
                        this.$swal({
                            title: "Hủy xóa!",
                            icon: "info",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            width: 360,
                        });
                    }
                })
                .catch((error) => {
                    if (error.response.status == 401) {
                        this.$swal({
                            icon: "error",
                            title: "Lỗi",
                            text: "Bạn không có quyền thực hiện hành động này!",
                        });
                    }
                });
        },
        selectAll(checked) {
            this.selected = checked
                ? this.orders.map((item) => item.id)
                : [];
            this.json_data = checked
                ? this.orders.map((item, index) => {
                      return {
                          STT: index + 1,
                          "Họ tên": item.customer.name,
                          "SĐT": item.customer.phone,
                          "Địa chỉ": item.address,
                          "Thanh toán": item.payment,
                          "Ngày đặt": item.created_at,
                          "Trạng thái": item.status,
                      };
                  })
                : [];
            this.pdf_data = checked
                ? this.orders.map((item, index) => {
                      return [
                          index + 1,
                          item.customer.name,
                          item.customer.phone,
                          item.address,
                          item.payment,
                          item.created_at,
                          item.status,
                      ];
                  })
                : [];
        },
        selectOne(checked) {
            if (checked) {
                this.json_data = this.orders
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return {
                          STT: index + 1,
                          "Họ tên": item.customer.name,
                          "SĐT": item.customer.phone,
                          "Địa chỉ": item.address,
                          "Thanh toán": item.payment,
                          "Ngày đặt": item.created_at,
                          "Trạng thái": item.status,
                        };
                    });
                this.pdf_data = this.orders
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return [
                          index + 1,
                          item.customer.name,
                          item.customer.phone,
                          item.address,
                          item.payment,
                          item.created_at,
                          item.status,
                        ];
                    });
            }
            this.allSelected = this.selected.length === this.orders.length;
        },
        deleteMutiple() {
            this.$swal({
                title: "Bạn chắc chắn muốn xóa?",
                text: "Bạn sẽ không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: "Hủy",
                width: 480,
            })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete("/api/orders/" + this.selected)
                            .then((response) => {
                                this.getCategorys();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.$swal({
                            title: "Đã xóa!",
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            width: 360,
                        });
                        this.getOrders();
                    } else {
                        this.$swal({
                            title: "Hủy xóa!",
                            icon: "info",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            width: 360,
                        });
                    }
                })
                .catch((error) => {
                    if (error.response.status == 401) {
                        this.$swal({
                            icon: "error",
                            title: "Lỗi",
                            text: "Bạn không có quyền thực hiện hành động này!",
                        });
                    }
                });
        },
        exportPdf() {
            if (this.pdf_data.length === 0) return;
            if (this.pdf_data.length == this.selected.length) {
                this.pdf_data.unshift([
                    {
                        text: "STT",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Họ tên",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "SĐT",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Địa chỉ",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Thanh toán",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Ngày tạo",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Trạng thái",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                ]);
            }
            var docDefinition = {
                header: {
                    text: "DANH SÁCH ĐƠN ĐẶT HÀNG",
                    alignment: "center",
                    bold: "true",
                    fontSize: 20,
                },
                content: [
                    {
                        table: {
                            headerRows: 1,
                            widths: ["auto", "*", "*", "*", "*", "*", "*"],
                            body: this.pdf_data,
                        },
                    },
                ],
            };
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            pdfMake.createPdf(docDefinition).download("Danh sách.pdf");
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        filterData() {
            this.orders = this.allOrders;
            switch (this.selectedFilter.length) {
                case 1:
                    if (this.selectedFilter[0] == 0) {
                        this.orders = this.orders.filter((item) => {
                            return item.status == 0;
                        });
                    } else if (this.selectedFilter[0] == 1) {
                        this.orders = this.orders.filter((item) => {
                            return item.status == 1;
                        });
                    } else if (this.selectedFilter[0] == 2) {
                        this.orders = this.orders.filter((item) => {
                            return item.status == 2;
                        });
                    }
                    break;
                case 2:
                    if (this.selectedFilter[0] == 0 && this.selectedFilter[1] == 1) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 0 || item.status == 1
                        );
                    } else if (this.selectedFilter[0] == 0 && this.selectedFilter[1] == 2) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 0 || item.status == 2
                        );
                    } else if (this.selectedFilter[0] == 1 && this.selectedFilter[1] == 0) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 1 || item.status == 0
                        );
                    } else if (this.selectedFilter[0] == 1 && this.selectedFilter[1] == 2) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 1 || item.status == 2
                        );
                    } else if (this.selectedFilter[0] == 2 && this.selectedFilter[1] == 0) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 2 || item.status == 0
                        );
                    } else if (this.selectedFilter[0] == 2 && this.selectedFilter[1] == 1) {
                        this.orders = this.orders.filter(
                            (item) => item.status == 2 || item.status == 1
                        );
                    } 
                    break;
                case 0:
                    this.orders = [];
                    break;
                default:
                    this.getOrders();
                    break;
            }
        },
        handleStatus(status) {
            axios.post("/api/handleOrder", {
                ids: this.selected,
                status: status,
            }).then((response) => {
                this.getOrders();
            });
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
    },
    mounted() {
        axios.get('/api/orderdetails').then((response) => {
            this.orderDetails = response.data;
        });
    }
};
</script>

<style></style>
