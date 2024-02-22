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

        <div class="container products" style="min-height:600px">
            <div class="row row-cols-5" v-if="products[0].price > 0">
                <div
                    class="col-item col"
                    v-for="item in products"
                    :key="item.id"
                >
                    <router-link tag="span" :to="`/products/${item.id}`">
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
            <div class="row" v-if="products[0].price > 0">
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
export default {
    components: {
        VueperSlides,
        VueperSlide,
        Loading
    },
    data() {
        return {
            rating: 4.5,
            showLoading: true,
            moreProducts: [],
            products: [
                {
                    price: 0,
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
        }
    },
    created() {
        this.getResultProducts();
    },
    methods: {
        async getResultProducts() {
            await axios.post('/api/products/search',{keyword: this.$route.query.q}).then(res => {
                if (res.data.length) {
                    this.moreProducts = res.data;
                    this.products = this.moreProducts.splice(0,10);
                    this.showLoading = false;
                } else {
                    this.showLoading = false;
                    this.products = [
                        {
                            price: 0,
                            category: {
                                name: "",
                        },
                    },
                    ];
                    this.$swal({
                        title: "Không tìm thấy sản phẩm",
                        text: "Vui lòng thử lại",
                        icon: "warning",
                        button: "Đóng",
                    });
                }
            });
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
            console.log(this.moreProducts);
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
    watch: {
        $route() {
            this.getResultProducts();
        },
    },
}
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
</style>