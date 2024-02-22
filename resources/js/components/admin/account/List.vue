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
                                <h3 class="card-title mt-3">Bảng Tài Khoản</h3>
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
                                        <b-button
                                            v-b-modal.addAccount
                                            variant="primary"
                                            v-b-tooltip.hover.v-secondary="
                                                'Thêm tài khoản quản trị'
                                            "
                                            ><i class="fas fa-plus"></i
                                        ></b-button>

                                        <b-modal
                                            id="addAccount"
                                            @show="resetForm"
                                            @hidden="resetForm"
                                            size="lg"
                                            title="Thêm Tài Khoản Quản Trị"
                                        >
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"
                                                    >Tên</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="form.name"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.name,
                                                    }"
                                                    placeholder="Nhập tên"
                                                    required
                                                />
                                                <div
                                                    v-if="errors.name"
                                                    class="invalid-feedback"
                                                >
                                                    {{ errors.name[0] }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"
                                                    >Email</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="form.email"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.email,
                                                    }"
                                                    placeholder="Nhập email"
                                                    required
                                                />
                                                <div
                                                    v-if="errors.email"
                                                    class="invalid-feedback"
                                                >
                                                    {{ errors.email[0] }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"
                                                    >Vai trò</label
                                                >
                                                <b-form-select
                                                    v-model="form.role_selected"
                                                    :options="roles"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.role_selected,
                                                    }"
                                                >
                                                    <template #first>
                                                        <b-form-select-option
                                                            :value="null"
                                                            disabled
                                                            >-- Chọn vai trò
                                                            --</b-form-select-option
                                                        >
                                                    </template>
                                                </b-form-select>
                                                <div
                                                    v-if="errors.role_selected"
                                                    class="invalid-feedback"
                                                >
                                                    {{
                                                        errors.role_selected[0]
                                                    }}
                                                </div>
                                            </div>
                                            <template
                                                #modal-footer="{ cancel }"
                                            >
                                                <div>
                                                    <b-button
                                                        variant="primary"
                                                        @click.prevent="
                                                            submitAddAccount
                                                        "
                                                        v-b-modal.showLoading
                                                    >
                                                        Xác nhận
                                                    </b-button>
                                                    <b-button
                                                        variant="secondary"
                                                        @click="cancel()"
                                                    >
                                                        Hủy
                                                    </b-button>
                                                </div>
                                            </template>
                                        </b-modal>
                                        <b-modal
                                            centered
                                            id="showLoading"
                                            body-bg-variant="light"
                                            header-bg-variant="light"
                                            footer-bg-variant="light"
                                            size="sm"
                                        >
                                            <div class="text-center">
                                                <span class="px-1"
                                                    ><b-spinner
                                                        variant="primary"
                                                        type="grow"
                                                        label="Spinning"
                                                    ></b-spinner
                                                ></span>
                                                <span class="px-1"
                                                    ><b-spinner
                                                        variant="primary"
                                                        type="grow"
                                                        label="Spinning"
                                                    ></b-spinner
                                                ></span>
                                                <span class="px-1"
                                                    ><b-spinner
                                                        variant="primary"
                                                        type="grow"
                                                        label="Spinning"
                                                    ></b-spinner
                                                ></span>
                                            </div>
                                            <template #modal-footer>
                                                <input type="hidden" />
                                            </template>
                                            <template #modal-header>
                                                <input type="hidden" />
                                            </template>
                                        </b-modal>
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
                                    :items="accounts"
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
                                    <template #cell(action)="row">
                                        <span
                                            @click.prevent="
                                                getCurrentAccount(row.item.id)
                                            "
                                            v-b-modal.currentAccount
                                            ><i
                                                class="fas fa-edit fa-lg text-primary"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Sửa bản ghi'
                                                "
                                            ></i
                                        ></span>

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
        <b-modal id="currentAccount" size="xl" title="Sửa Tài Khoản Quản Trị">
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input
                    type="text"
                    v-model="currentAccount.acc.email"
                    class="form-control"
                    placeholder="Nhập email"
                    required
                    readonly
                />
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tên</label>
                <input
                    type="text"
                    v-model="currentAccount.acc.name"
                    class="form-control"
                    :class="{
                        'is-invalid': errors.name,
                    }"
                    placeholder="Nhập tên"
                    required
                />
                <div v-if="errors.name" class="invalid-feedback">
                    {{ errors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Vai trò</label>
                <b-form-select
                    v-model="currentAccount.acc.roles[0].name"
                    :options="roles"
                >
                    <template #first>
                        <b-form-select-option :value="null" disabled
                            >-- Chọn vai trò --</b-form-select-option
                        >
                    </template>
                </b-form-select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Các quyền</label>
                <div class="row">
                    <ul>
                        <li
                            v-for="item in currentAccount.permissions"
                            :key="item.name"
                        >
                            {{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>
            <template #modal-footer="{ cancel }">
                <div>
                    <b-button
                        variant="primary"
                        @click.prevent="
                            submitEditAccount(currentAccount.acc.id)
                        "
                    >
                        Xác nhận
                    </b-button>
                    <b-button variant="secondary" @click="cancel()">
                        Hủy
                    </b-button>
                </div>
            </template>
        </b-modal>
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts.js";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                role_selected: null,
            },
            currentAccount: {
                acc: {
                    email: "",
                    name: "",
                    roles: [
                        {
                            name: "",
                        },
                    ],
                },
            },
            errors: {},
            accounts: [],
            roles: [],
            selected: [],
            allSelected: false,
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
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
                    key: "name",
                    label: "Tên tài khoản",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "email",
                    label: "Email đăng nhập",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "roles[0].name",
                    label: "Vai trò",
                    class: "text-center align-middle",
                    sortable: true,
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
            showLoading: false,
        };
    },
    created() {
        this.getAccounts();
    },
    methods: {
        getAccounts() {
            axios
                .get("/api/accounts")
                .then((response) => {
                    this.accounts = response.data.users;
                    this.roles = response.data.roles.map((item) => {
                        return {
                            value: item,
                            text: item,
                        };
                    });
                    this.totalRows = this.accounts.length;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getCurrentAccount(id) {
            axios.get("/api/accounts/" + id).then((response) => {
                this.currentAccount = response.data;
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
                            .delete("/api/accounts/" + id)
                            .then((response) => {
                                this.$swal({
                                    title: "Đã xóa!",
                                    icon: "success",
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1500,
                                    width: 360,
                                });
                                this.getAccounts();
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
            this.selected = checked ? this.accounts.map((item) => item.id) : [];
            this.json_data = checked
                ? this.accounts.map((item, index) => {
                      return {
                          STT: index + 1,
                          "Tên tài khoản": item.name,
                          "Email đăng nhập": item.email,
                          "Ngày tạo": item.created_at,
                      };
                  })
                : [];
            this.pdf_data = checked
                ? this.accounts.map((item, index) => {
                      return [
                          index + 1,
                          item.name,
                          item.email,
                          item.created_at,
                      ];
                  })
                : [];
        },
        selectOne(checked) {
            if (checked) {
                this.json_data = this.accounts
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return {
                            STT: index + 1,
                            "Tên tài khoản": item.name,
                            "Email đăng nhập": item.email,
                            "Ngày tạo": item.created_at,
                        };
                    });
                this.pdf_data = this.accounts
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return [
                            index + 1,
                            item.name,
                            item.email,
                            item.created_at,
                        ];
                    });
            }
            this.allSelected = this.selected.length === this.accounts.length;
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
                            .delete("/api/accounts/" + this.selected)
                            .then((response) => {
                                this.$swal({
                                    title: "Đã xóa!",
                                    icon: "success",
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1500,
                                    width: 360,
                                });
                                this.getAccounts();
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
                        text: "Tên tài khoản",
                        fillColor: "#6c7ae0",
                        color: "white",
                        alignment: "center",
                    },
                    {
                        text: "Email đăng nhập",
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
                ]);
            }
            var docDefinition = {
                header: {
                    text: "DANH SÁCH TÀI KHOẢN",
                    alignment: "center",
                    bold: "true",
                    fontSize: 20,
                },
                content: [
                    {
                        table: {
                            headerRows: 1,
                            widths: ["auto", "*", "*", "*"],
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
        resetForm() {
            this.form.name = "";
            this.form.email = "";
            this.form.role_selected = null;
        },
        submitAddAccount() {
            axios
                .post("/api/accounts", this.form)
                .then((response) => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("addAccount");
                    });
                    this.$nextTick(() => {
                        this.$bvModal.hide("showLoading");
                    });
                    this.$swal({
                        title: "Thêm thành công!",
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        width: 360,
                    });
                    this.getAccounts();
                })
                .catch((e) => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("showLoading");
                    });
                    this.errors = e.response.data.errors;
                });
        },
        submitEditAccount(id) {
            axios
                .put("/api/accounts/" + id, {
                    name: this.currentAccount.acc.name,
                    role: this.currentAccount.acc.roles[0].name,
                })
                .then((response) => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("currentAccount");
                    });
                    this.$swal({
                        title: "Sửa thành công!",
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        width: 360,
                    });
                    this.getAccounts();
                })
                .catch((e) => {
                    this.errors = e.response.data.errors;
                });
        },
    },
};
</script>

<style scoped>
ul {
    display: flex; /* Magic begins */
    flex-wrap: wrap; /* Multiline */
}
ul li {
    flex-grow: 1; /* Grow to fill available space */
}

ul li {
    background: #f5f5f5;
    display: inline-block;
    padding: 15px;
    margin-left: -3px;
    margin-bottom: 1px;
}

ul li:hover {
    background: #ddd;
}
</style>
