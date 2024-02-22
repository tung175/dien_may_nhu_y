<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <Breadcrumbs />

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary" @keyup.enter="submit()">
                            <div class="card-header">
                                <h3 class="card-title mt-2">Chỉnh Sửa</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                 <label for="exampleInputEmail1"
                                    >Danh mục sản phẩm</label
                                >
                                <b-form-select
                                    v-model="form.category_id"
                                    :options="category_options"
                                    value-field="id"
                                    text-field="name"
                                    :class="{
                                        'is-invalid': errors.category_id,
                                    }"
                                >
                                    <template #first>
                                        <b-form-select-option
                                            :value="null"
                                            disabled
                                            >-- Chọn Danh Mục
                                            --</b-form-select-option
                                        >
                                    </template>
                                </b-form-select>
                                <div
                                    v-if="errors.category_id"
                                    class="invalid-feedback"
                                >
                                    {{ errors.category_id[0] }}
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Tên loại sản phẩm</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.name,
                                        }"
                                        placeholder="Nhập tên loại sản phẩm"
                                        required
                                    />
                                    <div
                                        v-if="errors.name"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.name[0] }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button
                                    @click.prevent="submit()"
                                    class="btn btn-primary"
                                >
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6"></div>
                    <!--/.col (right) -->
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
export default {
    data() {
        return {
            form: {
                name: "",
                category_id: null,
            },
            errors: {},
            category_options: [],
        };
    },
    created() {
        this.getCurrentType();
        this.getCategories();
    },
    methods: {
        getCategories() {
            axios.get("/api/categories").then((response) => {
                this.category_options = response.data;
            });
        },
        submit() {
            axios
                .put(`/api/types/${this.$route.params.id}`, this.form)
                .then((response) => {
                    this.$swal({
                        title: "Thành công",
                        icon: "success",
                        text: "Cập nhật thành công",
                        position: "top-end",
                        timer: 1500,
                        showConfirmButton: false,
                        width: 360,
                    });
                    this.$router.push({ name: "types" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    if (error.response.status == 401) {
                        this.$swal({
                            icon: "error",
                            title: "Lỗi",
                            text: "Bạn không có quyền thực hiện hành động này!",
                        });
                    }
                });
        },
        getCurrentType() {
            axios
                .get("/api/types/" + this.$route.params.id)
                .then((response) => {
                    this.form = response.data;
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>

<style></style>
