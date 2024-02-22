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
                                    Bảng Sản Phẩm
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="overflow-x: auto">
                                <b-row class="mb-3">
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
                                                    'Xuất PDF các bản ghi ở trang hiện tại'
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
                                        <router-link
                                            :to="{ name: 'products.create' }"
                                            class="btn btn-primary"
                                            v-b-tooltip.hover.v-secondary="
                                                'Thêm mới bản ghi'
                                            "
                                        >
                                            <i class="fas fa-plus"></i>
                                        </router-link>
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
                                    </b-col>
                                </b-row>
                                <b-table
                                    :items="products"
                                    :fields="fields"
                                    :per-page="perPage"
                                    :current-page="currentPage"
                                    :filter="filter"
                                    @filtered="onFiltered"
                                    id="table"
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
                                    <template #cell(image)="row">
                                        <div>
                                            <center>
                                                <span>
                                                    <img
                                                        style="
                                                            border-radius: 5px;
                                                            width: 100px;
                                                            height: 80px;
                                                            box-shadow: 0px 0px
                                                                10px #ccc;
                                                        "
                                                        :src="row.item.image"
                                                    />
                                                </span>
                                            </center>
                                        </div>
                                    </template>
                                    <template #row-details="row">
                                        <b-card>
                                            <ul>
                                                <li>
                                                    Giá:
                                                    {{
                                                        formatPrice(
                                                            row.item.price
                                                        )
                                                    }}
                                                    vnđ
                                                </li>
                                                <li>
                                                    Bảo hành:
                                                    {{ row.item.warranty }} năm
                                                </li>
                                                <li>
                                                    Thông số kỹ thuật:
                                                    <div
                                                        v-html="
                                                            row.item.description
                                                        "
                                                    ></div>
                                                </li>
                                                <li>
                                                    Màu sắc:
                                                    <span
                                                        v-for="item in row.item
                                                            .colors"
                                                        :key="item.id"
                                                        ><img
                                                            :src="item.image"
                                                            style="
                                                                border-radius: 50%;
                                                                width: 24px;
                                                                height: 24px;
                                                                margin-left: 4px;
                                                                box-shadow: 0px 0px 10px #ccc;
                                                            "
                                                    /></span>
                                                </li>
                                                <li>
                                                    Ảnh bổ sung:
                                                    <img
                                                        v-for="item in row.item
                                                            .images"
                                                        :key="item.id"
                                                        :src="
                                                            '/storage/images/products/' +
                                                            item.name
                                                        "
                                                        style="
                                                            border-radius: 5px;
                                                            box-shadow: 0px 0px 10px #ccc;
                                                            max-width: 80px;
                                                            max-height: 80px;
                                                            margin-left: 4px;
                                                            margin-top: 10px;
                                                        "
                                                    />
                                                </li>
                                            </ul>
                                        </b-card>
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
                                        <router-link
                                            :to="{
                                                name: 'products.edit',
                                                params: { id: row.item.id },
                                            }"
                                            ><i
                                                class="fas fa-edit fa-lg"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Sửa bản ghi'
                                                "
                                            ></i
                                        ></router-link>
                                        <span
                                            @click="deleteProduct(row.item.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt fa-lg"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Xóa bản ghi'
                                                "
                                            ></i>
                                        </span>
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
import html2PDF from "jspdf-html2canvas";
export default {
    data() {
        return {
            products: [],
            selected: [],
            allSelected: false,
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100, 500, 1000],
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
                    key: "image",
                    label: "Ảnh",
                    sortable: false,
                    class: "text-center align-middle",
                },
                {
                    key: "code",
                    label: "Mã SP",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "name",
                    label: "Tên SP",
                    sortable: true,
                    class: "text-center align-middle",
                },
                {
                    key: "category.name",
                    label: "Danh mục",
                    sortable: true,
                    class: "text-center align-middle",
                },
                {
                    key: "type.name",
                    label: "Loại",
                    sortable: true,
                    class: "text-center align-middle",
                },
                {
                    key: "brand.name",
                    label: "Thương hiệu",
                    sortable: true,
                    class: "text-center align-middle",
                },
                {
                    key: "created_at",
                    label: "Ngày tạo",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "action",
                    label: "Hành động",
                    class: "text-center align-middle width-actions",
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
        };
    },
    created() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios
                .get("/api/products")
                .then((response) => {
                    this.products = response.data;
                    this.totalRows = this.products.length;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteProduct(id) {
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
                            .delete("/api/products/" + id)
                            .then((response) => {
                                this.$swal({
                                    title: "Đã xóa!",
                                    icon: "success",
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1500,
                                    width: 360,
                                });
                                this.getProducts();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
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
            this.selected = checked ? this.products.map((item) => item.id) : [];
            this.json_data = checked
                ? this.products.map((item, index) => {
                      return {
                          STT: index + 1,
                          "Mã SP": item.code,
                          "Tên SP": item.name,
                          "Danh mục": item.category.name,
                          Loại: item.type.name,
                          "Thương hiệu": item.brand.name,
                          Giá: item.price,
                          "Bảo hành (năm)": item.warranty,
                          "Ngày tạo": item.created_at,
                          "Ngày sửa": item.updated_at,
                      };
                  })
                : [];
        },
        selectOne(checked) {
            if (checked) {
                this.json_data = this.products
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return {
                            STT: index + 1,
                            "Mã SP": item.code,
                            "Tên SP": item.name,
                            "Danh mục": item.category.name,
                            Loại: item.type.name,
                            "Thương hiệu": item.brand.name,
                            Giá: item.price,
                            "Bảo hành (năm)": item.warranty,
                            "Ngày tạo": item.created_at,
                            "Ngày sửa": item.updated_at,
                        };
                    });
            }
            this.allSelected = this.selected.length === this.products.length;
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
                            .delete("/api/products/" + this.selected)
                            .then((response) => {
                                this.$swal({
                                    title: "Đã xóa!",
                                    icon: "success",
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1500,
                                    width: 360,
                                });
                                this.getProducts();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
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
            let page = document.getElementById("table");
            // Getting the rows in table.
            var row = page.rows;

            // index các cột cần ẩn
            var i = 0,
                k = 9;
            for (var j = 0; j < row.length; j++) {
                var cols = row[j].cells;
                // ẩn đi
                cols[i].style.display = "none";
                cols[k].style.display = "none";
            }
            html2PDF(page, {
                jsPDF: {
                    format: "a4",
                },
                imageType: "image/jpeg",
                output: "Danh sách.pdf",
            });
            for (var j = 0; j < row.length; j++) {
                var cols = row[j].cells;
                // hiển thị lại
                cols[i].style.display = "table-cell";
                cols[k].style.display = "table-cell";
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
};
</script>

<style></style>
