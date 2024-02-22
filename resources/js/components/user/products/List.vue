<template>
    <div>
        <div class="container mt-3 mb-4">
            <div class="row">
                <div class="col-md-8">
                    <vueper-slides :touchable="false" fixed-height="200px">
                        <vueper-slide
                            v-for="(slide, i) in slides"
                            :key="i"
                            :image="slide.image"
                        />
                    </vueper-slides>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <img
                                width="100%"
                                height="96px"
                                style="cursor: pointer"
                                src="/storage/images/banner/product7.png"
                            />
                        </div>
                        <div class="col-md-12">
                            <img
                                width="100%"
                                height="96px"
                                style="cursor: pointer"
                                src="/storage/images/banner/product8.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <ul>
                <!-- Bộ Lọc ALL -->
                <li
                    style="cursor: unset"
                    :class="{ 'hover-border': showFilter }"
                >
                    <span
                        class="noselect"
                        @click="
                            showFilter = !showFilter;
                            showFilterBrands = false;
                            showFilterTypes = false;
                            showFilterWarranty = false;
                            showFilterPrice = false;
                        "
                        ><i class="fas fa-filter"></i> Bộ lọc</span
                    >
                    <div v-if="showFilter">
                        <div class="arrow-filter"></div>
                        <div class="filter">
                            <div class="container row-filter">
                                <div class="mb-2">
                                    <b>Hãng</b>
                                    <button
                                        class="float-right border rounded"
                                        @click="showFilter = !showFilter"
                                    >
                                        <b>X</b>
                                    </button>
                                </div>
                                <ul>
                                    <div
                                        v-for="(item, key) in brands"
                                        :key="item.id"
                                    >
                                        <li
                                            class="p-0 sub-filter"
                                            :class="{
                                                'hover-border': item.isActive,
                                            }"
                                        >
                                            <input
                                                type="checkbox"
                                                v-model="filters.selectedBrands"
                                                :id="'brand' + key"
                                                :value="item.id"
                                                hidden
                                            /><label
                                                :for="'brand' + key"
                                                class="text-checkbox noselect"
                                                @click="
                                                    item.isActive =
                                                        !item.isActive
                                                "
                                            >
                                                <img
                                                    width="39px"
                                                    height="24px"
                                                    :src="item.image"
                                                />
                                            </label>
                                        </li>
                                    </div>
                                </ul>

                                <hr class="m-0 my-2" />
                                <div class="pr-3">
                                    <div class="mb-2"><b>Khoảng giá</b></div>
                                    <h6
                                        style="
                                            font-weight: 600;
                                            text-align: center;
                                        "
                                    >
                                        [
                                        {{
                                            formatPrice(filters.rangePrice[0] * 100000)
                                        }}₫ -
                                        {{
                                            formatPrice(filters.rangePrice[1] * 100000)
                                        }}₫ ]
                                    </h6>
                                    <vue-range-slider
                                        :width="500"
                                        ref="slider"
                                        :tooltip="null"
                                        :max="1000"
                                        v-model="filters.rangePrice"
                                    ></vue-range-slider>
                                </div>
                                <hr class="m-0 my-2" />
                                <div>
                                    <div class="mb-2"><b>Loại</b></div>
                                    <ul>
                                        <div
                                            v-for="(item, key) in types"
                                            :key="item.id"
                                        >
                                            <li
                                                class="p-0 sub-filter"
                                                :class="{
                                                    'hover-border':
                                                        item.isActive,
                                                }"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="filters.selectedTypes"
                                                    :id="'type' + key"
                                                    :value="item.id"
                                                    hidden
                                                /><label
                                                    :for="'type' + key"
                                                    @click="
                                                        item.isActive =
                                                            !item.isActive
                                                    "
                                                    class="text-checkbox noselect"
                                                    >{{ item.name }}</label
                                                >
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                                <div>
                                    <div class="mb-2"><b>Bảo hành</b></div>
                                    <ul>
                                        <div
                                            v-for="(item, key) in warranties"
                                            :key="item.id"
                                        >
                                            <li
                                                class="p-0 sub-filter"
                                                :class="{
                                                    'hover-border':
                                                        item.isActive,
                                                }"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="filters.selectedWarranties"
                                                    :id="'warranty' + key"
                                                    :value="item.id"
                                                    hidden
                                                /><label
                                                    :for="'warranty' + key"
                                                    @click="
                                                        item.isActive =
                                                            !item.isActive
                                                    "
                                                    class="text-checkbox noselect"
                                                    >{{ item.name }}</label
                                                >
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                                <hr class="m-0 my-2" />
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-outline-danger" @click="filters.selectedBrands=[];filters.selectedTypes=[];filters.selectedWarranties=[];filters.rangePrice=[0,1000];passAllFilters()">
                                            Bỏ chọn
                                        </button>
                                        <button class="btn btn-primary" @click="passAllFilters()">
                                            Xem kết quả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END Bộ Lọc ALL -->
                <!-- Bộ lọc Brand -->
                <li
                    style="cursor: unset"
                    :class="{ 'hover-border': showFilterBrands }"
                >
                    <span
                        class="noselect"
                        @click="
                            showFilterBrands = !showFilterBrands;
                            showFilter = false;
                            showFilterPrice = false;
                            showFilterTypes = false;
                            showFilterWarranty = false;
                        "
                        >Hãng <i class="fas fa-caret-down"></i
                    ></span>
                    <div v-if="showFilterBrands">
                        <div class="arrow-filter"></div>
                        <div class="filter">
                            <div class="container row-filter">
                                <div class="mb-2">
                                    <b>Hãng</b>
                                    <button
                                        class="float-right border rounded"
                                        @click="
                                            showFilterBrands = !showFilterBrands
                                        "
                                    >
                                        <b>X</b>
                                    </button>
                                </div>
                                <ul>
                                    <div
                                        v-for="(item, key) in brands"
                                        :key="item.id"
                                    >
                                        <li
                                            class="p-0 sub-filter"
                                            :class="{
                                                'hover-border': item.isActive,
                                            }"
                                        >
                                            <input
                                                type="checkbox"
                                                v-model="filters.selectedBrands"
                                                :id="'brand' + key"
                                                :value="item.id"
                                                hidden
                                            /><label
                                                :for="'brand' + key"
                                                class="text-checkbox noselect"
                                                @click="
                                                    item.isActive =
                                                        !item.isActive
                                                "
                                            >
                                                <img
                                                    width="39px"
                                                    height="24px"
                                                    :src="item.image"
                                                />
                                            </label>
                                        </li>
                                    </div>
                                </ul>

                                <hr class="m-0 my-2" />
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-outline-danger" @click="filters.selectedBrands=[];passAllFilters()">
                                            Bỏ chọn
                                        </button>
                                        <button class="btn btn-primary" @click="passAllFilters()">
                                            Xem kết quả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END Bộ lọc Brand -->
                <!-- Bộ lọc Price -->
                <li
                    style="cursor: unset"
                    :class="{ 'hover-border': showFilterPrice }"
                >
                    <span
                        class="noselect"
                        @click="
                            showFilterPrice = !showFilterPrice;
                            showFilter = false;
                            showFilterBrands = false;
                            showFilterTypes = false;
                            showFilterWarranty = false;
                        "
                        >Giá <i class="fas fa-caret-down"></i
                    ></span>
                    <div v-if="showFilterPrice">
                        <div class="arrow-filter"></div>
                        <div class="filter">
                            <div class="container row-filter">
                                <div class="mb-2">
                                    <b>Giá</b>
                                    <button
                                        class="float-right border rounded"
                                        @click="
                                            showFilterPrice = !showFilterPrice
                                        "
                                    >
                                        <b>X</b>
                                    </button>
                                </div>
                                <div class="pr-3">
                                    <div class="mb-2"><b>Khoảng giá</b></div>
                                    <h6
                                        style="
                                            font-weight: 600;
                                            text-align: center;
                                        "
                                    >
                                        [
                                        {{
                                            formatPrice(filters.rangePrice[0] * 100000)
                                        }}₫ -
                                        {{
                                            formatPrice(filters.rangePrice[1] * 100000)
                                        }}₫ ]
                                    </h6>
                                    <vue-range-slider
                                        :width="500"
                                        ref="slider"
                                        :tooltip="null"
                                        :max="1000"
                                        v-model="filters.rangePrice"
                                    ></vue-range-slider>
                                </div>

                                <hr class="m-0 my-2" />
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-outline-danger" @click="filters.rangePrice=[0,1000];passAllFilters()">
                                            Bỏ chọn
                                        </button>
                                        <button class="btn btn-primary" @click="passAllFilters()">
                                            Xem kết quả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END Bộ lọc Price -->
                <!-- Bộ lọc Type -->
                <li
                    style="cursor: unset"
                    :class="{ 'hover-border': showFilterTypes }"
                >
                    <span
                        class="noselect"
                        @click="
                            showFilterTypes = !showFilterTypes;
                            showFilter = false;
                            showFilterPrice = false;
                            showFilterBrands = false;
                            showFilterWarranty = false;
                        "
                        >Loại {{ products[0].category.name }}
                        <i class="fas fa-caret-down"></i
                    ></span>
                    <div v-if="showFilterTypes">
                        <div class="arrow-filter"></div>
                        <div class="filter">
                            <div class="container row-filter">
                                <div class="mb-2">
                                    <b>Loại</b>
                                    <button
                                        class="float-right border rounded"
                                        @click="
                                            showFilterTypes = !showFilterTypes
                                        "
                                    >
                                        <b>X</b>
                                    </button>
                                </div>
                                <ul>
                                    <div
                                        v-for="(item, key) in types"
                                        :key="item.id"
                                    >
                                        <li
                                            class="p-0 sub-filter"
                                            :class="{
                                                'hover-border': item.isActive,
                                            }"
                                        >
                                            <input
                                                type="checkbox"
                                                v-model="filters.selectedTypes"
                                                :id="'type' + key"
                                                :value="item.id"
                                                hidden
                                            /><label
                                                :for="'type' + key"
                                                @click="
                                                    item.isActive =
                                                        !item.isActive
                                                "
                                                class="text-checkbox noselect"
                                                >{{ item.name }}</label
                                            >
                                        </li>
                                    </div>
                                </ul>

                                <hr class="m-0 my-2" />
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-outline-danger" @click="filters.selectedTypes=[];passAllFilters()">
                                            Bỏ chọn
                                        </button>
                                        <button class="btn btn-primary" @click="passAllFilters()">
                                            Xem kết quả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END Bộ lọc Type -->
                <!-- Bộ lọc Warranty -->
                <li
                    style="cursor: unset"
                    :class="{ 'hover-border': showFilterWarranty }"
                >
                    <span
                        class="noselect"
                        @click="
                            showFilterWarranty = !showFilterWarranty;
                            showFilter = false;
                            showFilterPrice = false;
                            showFilterTypes = false;
                            showFilterBrands = false;
                        "
                        >Bảo hành <i class="fas fa-caret-down"></i
                    ></span>
                    <div v-if="showFilterWarranty">
                        <div class="arrow-filter"></div>
                        <div class="filter">
                            <div class="container row-filter">
                                <div class="mb-2">
                                    <b>Bảo hành</b>
                                    <button
                                        class="float-right border rounded"
                                        @click="
                                            showFilterWarranty =
                                                !showFilterWarranty
                                        "
                                    >
                                        <b>X</b>
                                    </button>
                                </div>
                                <ul>
                                    <div
                                        v-for="(item, key) in warranties"
                                        :key="item.id"
                                    >
                                        <li
                                            class="p-0 sub-filter"
                                            :class="{
                                                'hover-border': item.isActive,
                                            }"
                                        >
                                            <input
                                                type="checkbox"
                                                v-model="filters.selectedWarranties"
                                                :id="'warranty' + key"
                                                :value="item.id"
                                                hidden
                                            /><label
                                                :for="'warranty' + key"
                                                @click="
                                                    item.isActive =
                                                        !item.isActive
                                                "
                                                class="text-checkbox noselect"
                                                >{{ item.name }}</label
                                            >
                                        </li>
                                    </div>
                                </ul>

                                <hr class="m-0 my-2" />
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-outline-danger" @click="filters.selectedWarranties = [];passAllFilters()">
                                            Bỏ chọn
                                        </button>
                                        <button class="btn btn-primary" @click="passAllFilters()">
                                            Xem kết quả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END Bộ lọc Warranty -->
            </ul>
            <ul>
                <li style="padding: 0; border: 0; line-height: 39px">
                    Tìm kiếm nhiều:
                </li>
                <li class="search-trend">
                    <img
                        width="39px"
                        src="https://cdn.tgdd.vn/Category/Quicklink/1942/2/060521-035300.png"
                    />
                </li>
                <li class="search-trend">
                    <img
                        width="39px"
                        src="https://cdn.tgdd.vn/Category/Quicklink/1942/2/060521-035255.png"
                    />
                </li>
            </ul>
            <ul>
                <li
                    style="
                        padding: 0;
                        border: 0;
                        line-height: 35px;
                        font-weight: 600;
                        font-size: 16px;
                        cursor: unset;
                    "
                >
                    {{ totalProducts }} {{ products[0].category.name }}
                </li>
                <li style="border: 0; margin-left: 34px; cursor: unset">
                    <input
                        class="form-check-input"
                        id="giamgia"
                        type="checkbox"
                    />
                    <label class="form-check-label" for="giamgia">
                        Giảm giá
                    </label>
                </li>
                <li style="border: 0; margin-left: 34px; cursor: unset">
                    <input class="form-check-input" id="gop" type="checkbox" />
                    <label class="form-check-label" for="gop"> Góp 0% </label>
                </li>
                <li style="border: 0; margin-left: 34px; cursor: unset">
                    <input
                        class="form-check-input"
                        id="docquyen"
                        type="checkbox"
                    />
                    <label class="form-check-label" for="docquyen">
                        Độc quyền
                    </label>
                </li>
                <li style="border: 0; margin-left: 34px; cursor: unset">
                    <input class="form-check-input" id="moi" type="checkbox" />
                    <label class="form-check-label" for="moi">
                        Mới {{ new Date().getFullYear() }}
                    </label>
                </li>
            </ul>
        </div>

        <div class="container products">
            <div class="row row-cols-5">
                <div
                    class="col-item col"
                    v-for="item in products"
                    :key="item.id"
                >
                    <router-link tag="span" style="display:grid" :to="`/products/${item.id}`">
                        <div class="img-item">
                            <img width="100%" :src="item.image" />
                        </div>
                        <div>
                            <h6 style="font-weight: 600">
                                {{ item.name }} {{ item.code }}
                            </h6>
                            <h5 style="font-weight: bolder">
                                {{ formatPrice(item.price) }}₫
                            </h5>
                            <star-rating
                                :read-only="true"
                                :increment="0.01"
                                :star-size="13"
                                active-color="#FF8C00"
                                :show-rating="false"
                                v-model="rating"
                            ></star-rating>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="row">
                <div class="col text-center pb-5 pt-3 mt-2 mb-4"><span @click="loadMore()" class="btn-loadmore noselect">Xem thêm {{moreProducts.length}} {{ products[0].category.name }} <i class="fas fa-caret-down"></i></span></div>
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
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import "vue-range-component/dist/vue-range-slider.css";
import VueRangeSlider from "vue-range-component";
import { addBackToTop } from 'vanilla-back-to-top'
addBackToTop({ backgroundColor: '#ed1c24',})
export default {
    components: { VueperSlides, VueperSlide, Loading, VueRangeSlider },
    data() {
        return {
            rating: 4.5,
            showLoading: true,
            showFilter: false,
            showFilterBrands: false,
            showFilterPrice: false,
            showFilterTypes: false,
            showFilterWarranty: false,
            moreProducts: [],
            products: [
                {
                    category: {
                        name: "",
                    },
                },
            ],
            slides: [
                {
                    image: "/storage/images/banner/product1.png",
                },
                {
                    image: "/storage/images/banner/product2.png",
                },
                {
                    image: "/storage/images/banner/product3.png",
                },
                {
                    image: "/storage/images/banner/product4.png",
                },
                {
                    image: "/storage/images/banner/product5.png",
                },
                {
                    image: "/storage/images/banner/product6.png",
                },
            ],
            brands: [],
            filters: {
                selectedBrands: [],
                selectedTypes: [],
                selectedWarranties: [],
                rangePrice: [0, 1000],
            },
            types: [],
            warranties: [
                {
                    id: 1,
                    name: "1 năm",
                    isActive: false,
                },
                {
                    id: 2,
                    name: "2 năm",
                    isActive: false,
                },
                {
                    id: 3,
                    name: "3 năm",
                    isActive: false,
                },
                {
                    id: 4,
                    name: "4 năm",
                    isActive: false,
                },
                {
                    id: 5,
                    name: "5 năm",
                    isActive: false,
                },
            ],
            totalProducts: 0,
        };
    },
    created() {
         if (!this.$route.query.category_id) {
            return this.$swal({
                title: "Không có sản phẩm",
                text: "Vui lòng chọn lại",
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "OK",
            }).then(() => {
                this.showLoading = false;
            });
        }
        this.getBrands();
        this.getTypes();
        this.getFilterProducts();
    },
    methods: {
        getBrands() {
            axios.get("/api/brands").then((res) => {
                this.brands = res.data
                    .filter((item) => {
                        return (
                            item.category_id == this.$route.query.category_id
                        );
                    })
                    .map((item) => {
                        return {
                            id: item.id,
                            name: item.name,
                            image: item.image,
                            isActive: false,
                        };
                    });
            });
        },
        getTypes() {
            axios.get("/api/types").then((res) => {
                this.types = res.data
                    .filter((item) => {
                        return (
                            item.category_id == this.$route.query.category_id
                        );
                    })
                    .map((item) => {
                        return {
                            id: item.id,
                            name: item.name,
                            isActive: false,
                        };
                    });
            });
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        loadMore() {
            if (this.moreProducts.length > 0) {
                this.showLoading = true;
                setTimeout(() => {
                    this.showLoading = false;
                }, 400);
            } 
            var nextProducts = this.moreProducts.splice(0, 10);
            this.products.push(...nextProducts);
        },
        async getFilterProducts() {
            await axios.post('/api/products/filters', this.$route.query)
                .then((res) => {
                    if (res.data.length > 0) {
                        this.moreProducts = res.data;
                        this.totalProducts = this.moreProducts.length;
                        this.products = this.moreProducts.splice(0, 10);
                        this.showLoading = false;
                    } else {
                        return this.$swal({
                            title: "Không có sản phẩm",
                            text: "Vui lòng chọn lại",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.showLoading = false;
                        });
                    }
                   
                    this.$route.query.brand_id ? this.filters.selectedBrands = this.$route.query.brand_id.split(',').map(item => parseInt(item)) : null;
                    this.$route.query.type_id ? this.filters.selectedTypes = this.$route.query.type_id.split(',').map(item => parseInt(item)) : null;
                    this.$route.query.warranty ? this.filters.selectedWarranties = this.$route.query.warranty.split(',').map(item => parseInt(item)) : null;
                    this.$route.query.rangeprice ? this.filters.rangePrice = this.$route.query.rangeprice.split(',').map(item => parseInt(item) / 100000) : null;
                    this.brands.filter((item) => {
                        return this.filters.selectedBrands.includes(item.id);
                    }).map((item) => {
                        item.isActive = true;
                    });
                    this.types.filter((item) => {
                        return this.filters.selectedTypes.includes(item.id);
                    }).map((item) => {
                        item.isActive = true;
                    });
                    this.warranties.filter((item) => {
                        return this.filters.selectedWarranties.includes(item.id);
                    }).map((item) => {
                        item.isActive = true;
                    });
                });
        },
        passAllFilters() {
            var params = {};
            params.category_id = this.$route.query.category_id;
            this.filters.selectedBrands.length > 0 ? params.brand_id = this.filters.selectedBrands.toString() : null;
            this.filters.selectedTypes.length > 0 ? params.type_id = this.filters.selectedTypes.toString() : null,
            this.filters.selectedWarranties.length > 0 ? params.warranty = this.filters.selectedWarranties.toString() : null,
            this.filters.rangePrice.length > 0 ? params.rangeprice = this.filters.rangePrice.map(item => item * 100000).toString() : null,
            this.$router.push({
                name: "user.products",
                query: params,
            }).catch(()=>{});
        }
    },
    watch: {
        $route() {
            this.$router.go(0);
        },
    },
};
</script>
<style scoped>
.container.products {
    min-width: 960px !important;
    padding-left: 22px !important;
    padding-right: 22px !important;
}
.row-cols-5 {
    border-left: 1px solid #f1f1f1;
    border-top: 1px solid #f1f1f1;
    min-height: 870px;
}
.col-item {
    height: 436px;
    border-right: 1px solid #f1f1f1;
    border-bottom: 1px solid #f1f1f1;
    padding-top: 12px;
    padding-bottom: 12px;
    display: grid;
}
.img-item {
    padding: 12px 6px;
    height: 200px;
    transition: 0.3s ease-in-out;
}
.col-item:hover .img-item {
    padding-top: 4px !important;
    cursor: pointer;
}
.col-item:hover {
    box-shadow: 0 2px 16px rgb(0 0 0 / 12%);
    cursor: pointer;
    transition-duration: 0.2s;
}
.col-item:hover h6 {
    color: #288ad6;
}
@media only screen and (max-width: 1200px) {
    .col-item {
        height: 390px;
    }
    .img-item {
        height: 160px;
    }
}
ul {
    list-style-type: none;
    padding: 0px;
    overflow: hidden;
}
li {
    float: left;
    padding: 6px 8px;
    border: 1px solid #e0e0e0;
    margin-right: 8px;
    border-radius: 5px;
    cursor: pointer;
}
i {
    opacity: 0.8;
}
.search-trend:hover {
    border: 1px solid #2f80ed;
    transition-duration: 0.4s;
}
.search-trend {
    border-radius: 30px;
}
li > label {
    cursor: pointer;
}
.arrow-filter {
    width: 12px;
    height: 12px;
    margin-top: 10px;
    position: absolute;
    background-color: white;
    transform: rotate(45deg);
    box-shadow: 2px 3px 10px 3px #888888;
}
.filter {
    position: absolute;
    z-index: 1;
    padding: 16px 0px 0px 3px;
    width: 40%;
    min-width: 540px;
}
.row-filter {
    border-radius: 5px;
    box-shadow: 1px 4px 10px 1px #888888;
    background-color: white;
    margin-left: -12px;
    padding-left: 16px;
    padding-top: 16px;
    padding-bottom: 12px;
}
.hover-border {
    border: 1px solid #4a90e2;
    transition-duration: 0.2s;
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
.sub-filter {
    border-radius: 5px;
    margin-bottom: 8px;
}
.sub-filter:hover {
    border: 1px solid #2f80ed;
    transition-duration: 0.4s;
}
.text-checkbox {
    padding: 8px 6px;
    margin: 0;
    font-weight: 600 !important;
}
.btn-loadmore {
    padding: 11px 100px;
    font-weight: 600;
    border-radius: 5px;
    background-color: #fff;
    border: 1px solid #e0e0e0;
}
.btn-loadmore:hover {
    background-color: #288ad6;
    color: #fff;
    border: 1px solid #288ad6;
    transition-duration: 0.2s;
    border-radius: 5px;
}

</style>
