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
                        <div
                            class="card card-primary"
                            @keyup.enter="submit()"
                            style="overflow-x: auto"
                        >
                            <div class="card-header">
                                <h3 class="card-title mt-2">Thêm Mới</h3>
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
                                    <label for="exampleInputEmail1" class="mt-3"
                                        >Tên thương hiệu</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.name,
                                        }"
                                        placeholder="Nhập tên thương hiệu"
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
                                    <b-row>
                                        <b-col md="4">
                                            <label for="exampleInputEmail1"
                                                >Logo thương hiệu</label
                                            >
                                            <input
                                                id="inputImage"
                                                type="file"
                                                @change="onFileChange"
                                                plain
                                                :class="{
                                                    'input-error': errors.image,
                                                }"
                                            />

                                            <img
                                                v-if="url"
                                                :src="url"
                                                class="img-fluid"
                                                style="
                                                    border-radius: 5px;
                                                    box-shadow: 0px 0px 4px
                                                        rgba(0, 0, 0, 0.1);
                                                    margin-top: 6px;
                                                    max-width: 200px;
                                                    max-height: 200px;
                                                    "
                                            />
                                        </b-col>
                                    </b-row>
                                    <div
                                        v-if="errors.image"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.image[0] }}
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
                category_id: null,
                name: "",
                image: "",
            },
            errors: {},
            category_options: [],
            url: null,
        };
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            axios.get("/api/categories").then((res) => {
                this.category_options = res.data;
            });
        },
        submit() {
            let formData = new FormData();
            if (this.form.category_id === null) {
                this.form.category_id = "";
            }
            formData.append("category_id", this.form.category_id);
            formData.append("name", this.form.name);
            formData.append("image", this.form.image);
            axios
                .post("/api/brands", formData)
                .then((response) => {
                    this.form.category_id = "";
                    this.form.name = "";
                    this.errors.name = "";
                    this.errors.category_id = null;
                    this.errors.image = null;
                    this.form.image = "";
                    document.getElementById("inputImage").value = null;
                    this.url = null;
                    this.$swal({
                        title: "Thành công",
                        icon: "success",
                        text: "Thêm mới thành công",
                        position: "top-end",
                        timer: 1500,
                        showConfirmButton: false,
                        width: 360,
                    });
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
        onFileChange(e) {
            this.form.image = e.target.files[0];
            this.url = URL.createObjectURL(this.form.image);
        },
    },
};
</script>

<style scoped>
    .input-error {
        border: 1px solid #dc3545;
        border-radius: 4px;
    }
</style>
