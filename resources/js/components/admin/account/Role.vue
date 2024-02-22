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
                                    Bảng Vai Trò
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
                                            v-b-modal.addRole
                                            variant="primary"
                                            v-b-tooltip.hover.v-secondary="
                                                'Thêm tài khoản quản trị'
                                            "
                                            ><i class="fas fa-plus"></i
                                        ></b-button>

                                        <b-modal
                                            id="addRole"
                                            @show="resetForm"
                                            @hidden="resetForm"
                                            size="lg"
                                            title="Thêm Quyền Quản Trị"
                                        >
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"
                                                    >Tên vai trò</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="form.name"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.name,
                                                    }"
                                                    placeholder="Nhập tên vai trò"
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
                                                <label
                                                    for="exampleInputEmail1"
                                                    class="text-danger"
                                                    >Quyền  <b-form-checkbox
                                                            @change="toggleAll"
                                                            v-model="allSelectedPermissions"
                                                            switch
                                                        >
                                                            Chọn tất cả
                                                        </b-form-checkbox></label
                                                >
                                                <b-row >
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Danh Mục Sản
                                                            Phẩm</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-category"
                                                            switch
                                                        >
                                                            Thêm danh mục
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-category"
                                                            switch
                                                        >
                                                            Sửa danh mục
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-category"
                                                            switch
                                                        >
                                                            Xóa danh mục
                                                        </b-form-checkbox>
                                                    </b-col>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Sản Phẩm</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-product"
                                                            switch
                                                        >
                                                            Thêm sản phẩm
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-product"
                                                            switch
                                                        >
                                                            Sửa sản phẩm
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-product"
                                                            switch
                                                        >
                                                            Xóa sản phẩm
                                                        </b-form-checkbox>
                                                    </b-col>
                                                </b-row>
                                                    <b-row>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Màu Sắc</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-color"
                                                            switch
                                                        >
                                                            Thêm màu sắc
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-color"
                                                            switch
                                                        >
                                                            Sửa màu sắc
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-color"
                                                            switch
                                                        >
                                                            Xóa màu sắc
                                                        </b-form-checkbox>
                                                    </b-col>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Loại Sản
                                                            Phẩm</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-type"
                                                            switch
                                                        >
                                                            Thêm loại
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-type"
                                                            switch
                                                        >
                                                            Sửa loại
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-type"
                                                            switch
                                                        >
                                                            Xóa loại
                                                        </b-form-checkbox>
                                                    </b-col>
                                                    </b-row>
                                                    <b-row>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Thương Hiệu</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-brand"
                                                            switch
                                                        >
                                                            Thêm thương hiệu
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-brand"
                                                            switch
                                                        >
                                                            Sửa thương hiệu
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-brand"
                                                            switch
                                                        >
                                                            Xóa thương hiệu
                                                        </b-form-checkbox>
                                                    </b-col>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Bài viết</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-post"
                                                            switch
                                                        >
                                                            Thêm bài viết
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-post"
                                                            switch
                                                        >
                                                            Sửa bài viết
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-post"
                                                            switch
                                                        >
                                                            Xóa bài viết
                                                        </b-form-checkbox>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col class="md-6">
                                                        <label
                                                            for="exampleInputEmail1"
                                                            >Bài viết</label
                                                        >
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="create-post"
                                                            switch
                                                        >
                                                            Thêm bài viết
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="edit-post"
                                                            switch
                                                        >
                                                            Sửa bài viết
                                                        </b-form-checkbox>
                                                        <b-form-checkbox
                                                            v-model="
                                                                selected_permissions
                                                            "
                                                            @change="selected_permission"
                                                            value="delete-post"
                                                            switch
                                                        >
                                                            Xóa bài viết
                                                        </b-form-checkbox>
                                                    </b-col>
                                                </b-row>
                                                 <div
                                        v-if="errors.permissions"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.permissions[0] }}
                                    </div>
                                            </div>
                                            <template
                                                #modal-footer="{ cancel }"
                                            >
                                                <div>
                                                    <b-button
                                                        variant="primary"
                                                        @click.prevent=" form.id ? submitEditRole(form.id) :
                                                            submitAddRole()
                                                        "
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
                                    :items="roles"
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
                                                getCurrentRole(row.item.id)
                                            "
                                            v-b-modal.addRole
                                            ><i
                                                class="fas fa-edit fa-lg text-primary"
                                                v-b-tooltip.hover.v-secondary="
                                                    'Sửa bản ghi'
                                                "
                                            ></i
                                        ></span>
                                        <span @click="deleteRole(row.item.id)">
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
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts.js";
export default {
    data() {
        return {
            form: {
                name: "",
            },
            errors: {},
            roles: [],
            selected: [],
            selected_permissions: [],
            all_selected_permissions: ["create-product", "delete-category", "create-type", "edit-type", "delete-type", "create-post", "edit-post", "delete-post", "delete-brand", "edit-brand", "create-brand", "delete-color", "edit-color", "create-color", "edit-category", "create-category", "edit-product", "delete-product", "create-order", "edit-order", "delete-order"],
            allSelected: false,
            allSelectedPermissions: false,
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
                    key: "name",
                    label: "Tên vai trò",
                    class: "text-center align-middle",
                    sortable: true,
                },
                {
                    key: "format_created_at",
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
        };
    },
    created() {
        this.getRoles();
    },
    methods: {
        getRoles() {
            axios
                .get("/api/roles")
                .then((response) => {
                    this.roles = response.data;
                    this.totalRows = this.roles.length;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getCurrentRole(id) {
            axios.get("/api/roles/" + id).then((res) => {
                this.form = res.data;
                this.selected_permissions = res.data.permissions.map((permission) => {
                    return permission.name;
                });
                this.allSelectedPermissions = this.selected_permissions.length === this.all_selected_permissions.length;
            });
        },
        deleteRole(id) {
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
                            .delete("/api/roles/" + id)
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
                        this.getRoles();
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
            this.selected = checked ? this.roles.map((item) => item.id) : [];
            this.json_data = checked
                ? this.roles.map((item, index) => {
                      return {
                          STT: index + 1,
                          "Tên vai trò": item.name,
                          "Ngày tạo": item.format_created_at,
                      };
                  })
                : [];
            this.pdf_data = checked
                ? this.roles.map((item, index) => {
                      return [index + 1, item.name, item.format_created_at];
                  })
                : [];
        },
        selectOne(checked) {
            if (checked) {
                this.json_data = this.roles
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return {
                            STT: index + 1,
                            "Tên vai trò": item.name,
                            "Ngày tạo": item.format_created_at,
                        };
                    });
                this.pdf_data = this.roles
                    .filter((item) => this.selected.includes(item.id))
                    .map((item, index) => {
                        return [index + 1, item.name, item.format_created_at];
                    });
            }
            this.allSelected = this.selected.length === this.roles.length;
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
                            .delete("/api/roles/" + this.selected)
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
                        this.getRoles();
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
                        text: "Tên vai trò",
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
                    text: "DANH SÁCH VAI TRÒ",
                    alignment: "center",
                    bold: "true",
                    fontSize: 20,
                },
                content: [
                    {
                        table: {
                            headerRows: 1,
                            widths: ["auto", "*", "*"],
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
            (this.form.id = ""), (this.form.name = ""), (this.errors = {});
            this.allSelectedPermissions = false;
            this.selected_permissions = [];
        },
        toggleAll(checked) {
            this.selected_permissions = checked
                ? this.all_selected_permissions
                : [];
        },
        selected_permission() {
            this.allSelectedPermissions = this.selected_permissions.length === this.all_selected_permissions.length;
        },
        submitAddRole() {
            axios
                .post("/api/roles", {
                    name: this.form.name,
                    permissions: this.selected_permissions,
                })
                .then((res) => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("addRole");
                    });
                    this.$swal({
                        title: "Thêm thành công!",
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        width: 360,
                    });
                    this.getRoles();
                })
                .catch((e) => {
                    this.errors = e.response.data.errors;
                });
        },
        submitEditRole(id) {
            axios
                .put("/api/roles/" + id, {
                    name: this.form.name,
                    permissions: this.selected_permissions,
                })
                .then((response) => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("addRole");
                    });
                    this.$swal({
                        title: "Sửa thành công!",
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        width: 360,
                    });
                    this.getRoles();
                })
                .catch((e) => {
                    this.errors = e.response.data.errors;
                });
        },
    },
};
</script>

<style scoped>
</style>
