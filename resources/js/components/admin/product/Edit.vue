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
                            style="overflow-x: auto"
                        >
                            <div class="card-header">
                                <h3 class="card-title mt-2">Thêm Mới</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Mã sản phẩm</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.code"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.code,
                                        }"
                                        placeholder="Nhập mã sản phẩm"
                                        required
                                    />
                                    <div
                                        v-if="errors.code"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.code[0] }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Tên sản phẩm</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.name,
                                        }"
                                        placeholder="Nhập tên sản phẩm"
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
                                        >Danh mục sản phẩm</label
                                    >
                                    <multiselect
                                        v-model="form.category"
                                        :options="categories"
                                        placeholder="Nhập từ khóa tìm kiếm"
                                        selectedLabel="Đã được chọn"
                                        selectLabel="Click hoặc enter để chọn"
                                        deselectLabel="Click hoặc enter để bỏ chọn"
                                        label="name"
                                        track-by="name"
                                        @select="
                                            getTypes();
                                            getBrands();
                                            getColors();
                                        "
                                        :class="{
                                            'input-error': errors.category_id,
                                        }"
                                    >
                                    </multiselect>
                                    <div
                                        v-if="errors.category_id"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.category_id[0] }}
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1"
                                            >Thương hiệu sản phẩm</label
                                        >
                                        <multiselect
                                            v-model="form.brand"
                                            placeholder="Chọn thương hiệu"
                                            label="name"
                                            track-by="name"
                                            :options="brands"
                                            :option-height="104"
                                            :show-labels="false"
                                            :class="{
                                                'input-error': errors.brand_id,
                                            }"
                                        >
                                            <template
                                                slot="singleLabel"
                                                slot-scope="props"
                                                ><img
                                                    class="option__image"
                                                    style="
                                                        max-width: 80px;
                                                        max-height: 80px;
                                                    "
                                                    :src="props.option.image"
                                                    alt="Logo"
                                                />
                                                <span class="option__name">{{
                                                    props.option.name
                                                }}</span>
                                            </template>
                                            <template
                                                slot="option"
                                                slot-scope="props"
                                                ><img
                                                    style="
                                                        max-width: 100px;
                                                        max-height: 100px;
                                                    "
                                                    class="option__image"
                                                    :src="props.option.image"
                                                    alt="Logo"
                                                />
                                                <span class="option__name">{{
                                                    props.option.name
                                                }}</span>
                                            </template>
                                            <template v-slot:noOptions>
                                                Xin mời chọn danh mục sản phẩm
                                                trước
                                            </template>
                                            <template v-slot:noResult>
                                                Không có kết quả tìm kiếm
                                            </template>
                                        </multiselect>
                                        <div
                                            v-if="errors.brand_id"
                                            style="
                                                color: #dc3545;
                                                font-size: 12.6px;
                                                margin-top: 3px;
                                            "
                                        >
                                            {{ errors.brand_id[0] }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1"
                                            >Loại</label
                                        >
                                        <multiselect
                                            v-model="form.type"
                                            :options="types"
                                            placeholder="Nhập từ khóa tìm kiếm"
                                            selectedLabel="Đã được chọn"
                                            selectLabel="Click hoặc enter để chọn"
                                            deselectLabel="Click hoặc enter để bỏ chọn"
                                            label="name"
                                            track-by="name"
                                            :class="{
                                                'input-error': errors.type_id,
                                            }"
                                        >
                                            <template v-slot:noOptions>
                                                Xin mời chọn danh mục sản phẩm
                                                trước
                                            </template>
                                            <template v-slot:noResult>
                                                Không có kết quả tìm kiếm
                                            </template>
                                        </multiselect>
                                        <div
                                            v-if="errors.type_id"
                                            style="
                                                color: #dc3545;
                                                font-size: 12.6px;
                                                margin-top: 3px;
                                            "
                                        >
                                            {{ errors.type_id[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Màu sắc</label
                                    >
                                    <multiselect
                                        v-model="form.colors"
                                        placeholder="Chọn màu sắc"
                                        label="name"
                                        track-by="name"
                                        :options="colors"
                                        :option-height="54"
                                        :show-labels="false"
                                        :multiple="true"
                                        :class="{
                                            'input-error': errors.color_ids,
                                        }"
                                    >
                                        <template
                                            slot="singleLabel"
                                            slot-scope="props"
                                            ><img
                                                class="option__image"
                                                style="
                                                    border-radius: 50%;
                                                    width: 30px;
                                                    height: 30px;
                                                "
                                                :src="props.option.image"
                                                alt="Ảnh"
                                            />
                                            <span class="option__name">{{
                                                props.option.name
                                            }}</span>
                                        </template>
                                        <template
                                            slot="option"
                                            slot-scope="props"
                                            ><img
                                                style="
                                                    border-radius: 50%;
                                                    width: 30px;
                                                    height: 30px;
                                                "
                                                class="option__image"
                                                :src="props.option.image"
                                                alt="Ảnh"
                                            />
                                            <span class="option__name">{{
                                                props.option.name
                                            }}</span>
                                        </template>
                                        <template v-slot:noOptions>
                                            Xin mời chọn danh mục sản phẩm trước
                                        </template>
                                        <template v-slot:noResult>
                                            Không có kết quả tìm kiếm
                                        </template>
                                    </multiselect>
                                    <div
                                        v-if="errors.color_ids"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.color_ids[0] }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Thông số kỹ thuật</label>

                                    <ckeditor
                                    id="editor"
                                        :editor="editor"
                                        :config="editorConfig"
                                        v-model="form.description"
                                        :class="{
                                            'input-error': errors.description,
                                        }"
                                    ></ckeditor>
                                    <div
                                        v-if="errors.description"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.description[0] }}
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1"
                                            >Giá sản phẩm</label
                                        >
                                        <input
                                            type="number"
                                            v-model.number="form.price"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.price,
                                            }"
                                            placeholder="Nhập giá sản phẩm"
                                            required
                                        />
                                        <div
                                            v-if="errors.price"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.price[0] }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1"
                                            >Bảo hành</label
                                        >
                                        <b-form-select
                                            v-model="form.warranty"
                                            :options="warranty_options"
                                            value-field="id"
                                            text-field="name"
                                            :class="{
                                                'is-invalid': errors.warranty,
                                            }"
                                        >
                                            <template #first>
                                                <b-form-select-option
                                                    :value="null"
                                                    disabled
                                                    >-- Chọn Số Năm Bảo Hành
                                                    --</b-form-select-option
                                                >
                                            </template>
                                        </b-form-select>
                                        <div
                                            v-if="errors.warranty"
                                            class="invalid-feedback"
                                        >
                                            {{ errors.warranty[0] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <b-row>
                                        <b-col md="4">
                                            <label for="exampleInputEmail1"
                                                >Ảnh mặc định</label
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
                                                    max-width: 160px;
                                                    max-height: 160px;
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

                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Ảnh bổ sung</label
                                    >
                                    <div
                                        class="row border rounded mx-1"
                                        style="
                                            border-color: #bbbbbb !important;
                                            background-color: #fbfbfb;
                                        "
                                    >
                                        <div
                                            class="col md-3 p-3 mx-2 position-relative"
                                            style="max-width: 166px"
                                        >
                                            <label
                                                id="label-upload-photo"
                                                for="upload-photo"
                                                ><div
                                                    style="
                                                        background-color: #ffffff;
                                                        border-radius: 5px !important;
                                                        border: 1px dashed #ccc !important;
                                                        cursor: pointer !important;
                                                        width: 160px;
                                                        height: 100px;
                                                    "
                                                    class="rounded text-center align-items-center"
                                                >
                                                    <div
                                                        style="
                                                            border-radius: 50%;
                                                            width: 48px;
                                                            height: 48px;
                                                            margin-left: auto;
                                                            margin-right: auto;
                                                            margin-top: 24px;
                                                        "
                                                        class="bg-info text-center align-items-center"
                                                    >
                                                        <h1
                                                            style="
                                                                font-weight: bold;
                                                            "
                                                        >
                                                            +
                                                        </h1>
                                                    </div>
                                                </div></label
                                            >
                                            <input
                                                type="file"
                                                @change="upload_images"
                                                id="upload-photo"
                                                accept="image/*"
                                            />
                                        </div>
                                        <div
                                            class="col md-3 p-3 mx-2 position-relative"
                                            style="max-width: 166px"
                                            v-for="item in form.images"
                                            :key="item.id"
                                        >
                                            <img
                                                class="rounded"
                                                :src="
                                                    '/storage/images/products/' +
                                                    item.name
                                                "
                                            />
                                            <div
                                                style="top: 16px; right: -3px"
                                                class="position-absolute"
                                            >
                                                <span
                                                    @click="
                                                        deleteImages(item.id)
                                                    "
                                                    >X</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="errors.images"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.images[0] }}
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Thông tin sản phẩm</label
                                    >
                                    <vue-editor v-model="post.info_product"
                                        :editorOptions="info_product_option"
                                        :class="{
                                            'input-error': errors.info_product,
                                        }"
                                        useCustomImageHandler
                                        @image-added="handleImageAdded"
                                        @image-removed="handleImageRemoved"
                                    >
                                    </vue-editor>
                                   <div
                                        v-if="errors.info_product"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                            margin-top: 3px;
                                        "
                                    >
                                        {{ errors.info_product[0] }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Clip đánh giá</label
                                    >
                                    <input type="text" 
                                        :class="{
                                            'input-error': errors.clip,
                                        }" 
                                        v-model="post.path" 
                                        placeholder="Nhập đường dẫn" 
                                        class="form-control mb-3">
                                    <div
                                        v-if="errors.clip"
                                        style="
                                            color: #dc3545;
                                            font-size: 12.6px;
                                        "
                                    >
                                        {{ errors.clip[0] }}
                                    </div>
                                    <div v-if="post.path">
                                        <LazyYoutube :src="post.path" />
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
import Multiselect from "vue-multiselect";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { VueEditor,Quill } from 'vue2-editor'
import  ImageResize  from 'quill-image-resize-vue'
Quill.register('modules/imageResize', ImageResize)
import { LazyYoutube } from "vue-lazytube";
export default {
    data() {
        return {
            form: {
                id: this.$route.params.id,
                code: "",
                name: "",
                image: "",
                images: "",
                price: "",
                warranty: "",
                description: "",
                category: {
                    id: 0,
                },
            },
            post: {},
            errors: {},
            url: null,
            images_deleted: [],
            categories: [],
            brands: [],
            types: [],
            colors: [],
            warranty_options: [
                {
                    id: 1,
                    name: "1 năm",
                },
                {
                    id: 2,
                    name: "2 năm",
                },
                {
                    id: 3,
                    name: "3 năm",
                },
                {
                    id: 4,
                    name: "4 năm",
                },
                {
                    id: 5,
                    name: "5 năm",
                },
            ],
             editor: ClassicEditor,
            editorConfig: {},
            info_product_option: {
            modules: {
                imageResize: {}, 
            },
            },
        };
    },
    async created() {
        await this.getProduct();
        await this.getCategories();
        await this.getBrands();
        await this.getTypes();
        this.getColors();
        this.getPost();
    },
    methods: {
        async getProduct() {
            await axios
                .get("/api/products/" + this.$route.params.id)
                .then((response) => {
                    this.form = response.data;
                    this.url = response.data.image;
                    this.form.image = "";
                });
        },
        getCategories() {
            axios.get("/api/categories").then((res) => {
                this.categories = res.data;
            });
        },
        async getBrands() {
            await axios.get("/api/brands").then((res) => {
                this.brands = res.data.filter((brand) => {
                    return brand.category_id == this.form.category.id;
                });
            });
        },
        async getTypes() {
            await axios.get("/api/types").then((res) => {
                this.types = res.data.filter((type) => {
                    return type.category_id == this.form.category.id;
                });
            });
        },
        getColors() {
            axios.get("/api/colors").then((res) => {
                this.colors = res.data;
            });
        },
        getPost() {
            axios.get("/api/posts/" + this.$route.params.id).then((res) => {
                this.post = res.data;
            });
        },
        submit() {
            let formData = new FormData();
            formData.append("id", this.form.id);
            formData.append("code", this.form.code);
            formData.append("name", this.form.name);
            formData.append("price", this.form.price);
            formData.append("warranty", this.form.warranty);
            formData.append("description", this.form.description);
            formData.append(
                "category_id",
                this.form.category === null ? "" : this.form.category.id
            );
            formData.append(
                "brand_id",
                this.form.brand === null ? "" : this.form.brand.id
            );
            formData.append(
                "type_id",
                this.form.type === null ? "" : this.form.type.id
            );
            formData.append(
                "color_ids",
                this.form.colors.map((color) => {
                    return color.id;
                })
            );
            formData.append("image", this.form.image);
            formData.append("info_product", this.post.info_product);
            formData.append("clip", this.post.path);
            formData.append("_method", "put");
            axios
                .post(`/api/products/${this.$route.params.id}`, formData)
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
                    this.$router.push("/admin/products");
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
        upload_images(e) {
            this.form.images = e.target.files[0];
            let formData = new FormData();
            formData.append("product_id", this.$route.params.id);
            formData.append("images", this.form.images);
            axios
                .post(`/api/products/upload_images`, formData)
                .then((response) => {
                    axios
                        .get("/api/products/" + this.$route.params.id)
                        .then((response) => {
                            this.form.images = response.data.images;
                        });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        deleteImages(id) {
            this.$swal({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Sau khi xóa, bạn sẽ không thể khôi phục lại!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy",
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    axios
                        .post(`/api/products/delete_images`, { id: id })
                        .then((response) => {
                            axios
                                .get("/api/products/" + this.$route.params.id)
                                .then((response) => {
                                    this.form.images = response.data.images;
                                });
                        })
                        .catch((error) => {
                            this.errors = error.response.data.errors;
                        });
                }
            });
        },
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("image", file);

            axios.post('/api/posts', formData)
                .then(result => {
                const url = result.data.url; // Get url from response
                Editor.insertEmbed(cursorLocation, "image", url);
                resetUploader();
                })
                .catch(err => {
                console.log(err);
                });
        },
        handleImageRemoved: function(file, Editor, cursorLocation, resetUploader) {
            axios.post('/api/posts/deleteImage', {image: file})
                .then(result => {
                })
                .catch(err => {
                console.log(err);
                });
            }
    },
    components: {
        Multiselect,
        VueEditor,
        LazyYoutube
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.input-error {
    border: 1px solid #dc3545;
    border-radius: 4px;
}
img.rounded {
    height: 100px;
    width: 160px;
    border: 1px solid #dddddd;
}
.position-absolute > span {
    font-weight: bold;
    font-size: 24px;
    color: gray;
}
.position-absolute:hover > span {
    cursor: pointer;
    color: rgb(252, 43, 36);
}
#label-upload-photo {
    cursor: pointer;
    /* Style as you please, it will become the visible UI component. */
}

#upload-photo {
    opacity: 0;
    position: absolute;
    z-index: -1;
}
.rounded.text-center.align-items-center:hover {
    background-color: #f1f1f1 !important;
}
.bg-info.text-center.align-items-center:hover {
    background-color: #17a2b8 !important;
}
</style>
