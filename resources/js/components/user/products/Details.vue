<template>
    <div>
        <div class="container">
            <div class="row cols-md-12 mt-3 breadcrumb">
                <div class="col">
                    <router-link
                        class="mr-1"
                        :to="{
                            name: 'user.products',
                            query: { category_id: product.category_id },
                        }"
                        >{{product.category.name}}
                    </router-link>
                    >
                    <router-link
                        class="ml-1"
                        :to="{
                            name: 'user.products',
                            query: {
                                category_id: product.category_id,
                                brand_id: product.brand_id,
                            },
                        }"
                    >
                        {{product.category.name}} {{ product.brand.name }}</router-link
                    >
                </div>
            </div>
            <div class="row cols-md-12">
                <div class="col">
                    <h5 class="font-weight-bold">
                        {{ product.name }} {{ product.code }}
                    </h5>
                </div>
            </div>
            <hr class="m-0 mt-1" />

            <div class="row mt-3">
                <div class="col-md-7">
                    <vueper-slides
                        class="no-shadow"
                        slide-multiple
                        :bullets="false"
                        :touchable="false"
                        fixedHeight="420px"
                    >
                        <vueper-slide>
                            <template v-slot:content>
                                <LazyYoutube
                                    maxWidth="100%"
                                    :src="product.post.path"
                                />
                            </template>
                        </vueper-slide>
                        <vueper-slide
                            v-for="slide in product.images"
                            :key="slide.id"
                        >
                            <template v-slot:content>
                                <img
                                    class="w-100"
                                    style="max-height: 420px"
                                    :src="`/storage/images/products/${slide.name}`"
                                />
                            </template>
                        </vueper-slide>
                    </vueper-slides>

                    <div class="policy mt-3">
                        <div class="row">
                            <div class="col-md-6 py-2">
                                <i class="fas fa-truck-loading"></i> Hư gì đổi nấy 12 tháng tận nhà (miễn phí tháng
                                đầu)
                            </div>
                            <div class="col-md-6 py-2">
                                <i class="fas fa-check-circle"></i> Bảo hành chính hãng 2 năm, có người đến tận nhà
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row">
                            <div class="col-md-6 py-2">
                                <i class="fas fa-box"></i> Thùng có: Sách hướng dẫn, phụ kiện
                            </div>
                            <div class="col-md-6 py-2"><i class="fas fa-check-circle"></i> Bảo hành phụ kiện 1 năm</div>
                        </div>
                    </div>

                    <h4 class="mt-4 mb-4 font-weight-bold">Thông tin sản phẩm</h4>
                    <div class="info-product" :class="{'show-more': showInfoProduct }" v-html="product.post.info_product">
                    </div>
                    <div class="row cols-md-12" style="padding-left:12px;padding-right:12px;height:80px">
                        <div class="col text-center" style="box-shadow: 0px -40px 24px 10px #dee2e691;">
                            <button @click="showInfoProduct = false" class="btn btn-outline-primary w-50 mt-2">Xem thêm <i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pl-3">
                    <h5>Giá</h5>
                    <h4 class="font-weight-bold text-danger ">{{ formatPrice(product.price) }}₫</h4>
                    <img width="100%" src="/storage/images/banner/detail_product1.png">
                    <div class="row mt-3 rounded" style="padding-left:12px;padding-right:12px">
                        <div class="rounded border p-0">
                            <div class="col-md-12 py-1 border-bottom" style="background-color:#f6f6f6;height:38px;display: flex;
    align-items: center;">
                                <h6 class="font-weight-bold m-0">Khuyến mãi</h6>
                            </div>
                            <div class="col-md-12 py-2">
                                <ol class="p-2 m-0">
                                    <li>Miễn phí công lắp đặt</li>
                                    <li>Miễn phí công bảo trì</li>
                                    <li>Tặng bộ phụ kiện</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <button class="btn w-100 font-weight-bold mt-3" style="background-color: #fb6e2e;color: white;height: 46px;" @click="setCookie()">MUA NGAY</button>
                    <h6 class="mt-3 text-center">Gọi đặt mua <a href="tel:12345678">1234.5678</a> (7:30 - 22:00)</h6>
                    <h5 style="font-size:20px" class="mt-5 mb-3 font-weight-bold">Thông số kỹ thuật {{ product.name }} {{ product.code }}</h5>
                    <div v-html="product.description"></div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-outline-primary mt-2">Xem chi tiết thông số ></button>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="col-md-12">
                    <h4 class="font-weight-bold mb-4"><router-link tag="span" :to="{name:'user.products', query:{category_id: product.category_id}}" class="view-more-products">Xem thêm {{ product.category.name }}</router-link></h4>
                    <vueper-slides
                class="no-shadow"
                :visible-slides="5"
                slide-multiple
                :slide-ratio="1 / 4"
                :bullets="false"
                :touchable="false"
                fixedHeight="436px"
            >
                <vueper-slide v-for="(slide, i) in otherProducts" :key="slide.id">
                    <template v-slot:content>
                        <router-link tag="span" :to="`/products/${slide.id}`">
                            <div
                                v-if="[1, 3, 6, 8].includes(i)"
                                class="h-100 border-top border-bottom cate"
                            >
                                <div class="item-img py-3">
                                    <img :src="slide.image" width="100%" />
                                </div>
                                <div>
                                    <h6 style="font-weight: 500">{{ slide.name }} {{ slide.code }}</h6>
                                    <h5 style="font-weight: bolder">{{ formatPrice(slide.price) }}₫</h5>
                                    <star-rating
                                        :read-only="true"
                                        :increment="0.01"
                                        :star-size="13"
                                        active-color="#FF8C00"
                                        :show-rating="false"
                                        v-model="rating"
                                    ></star-rating>
                                </div>
                            </div>
                            <div v-else class="h-100 border cate">
                                <div class="item-img py-3">
                                    <img :src="slide.image" width="100%" />
                                </div>
                                <div>
                                    <h6 style="font-weight: 500">{{ slide.name }} {{ slide.code }}</h6>
                                    <h5 style="font-weight: bolder">{{ formatPrice(slide.price) }}₫</h5>
                                    <star-rating
                                        :read-only="true"
                                        :increment="0.01"
                                        :star-size="13"
                                        active-color="#FF8C00"
                                        :show-rating="false"
                                        v-model="rating"
                                    ></star-rating>
                                </div>
                            </div>
                        </router-link>
                    </template>
                </vueper-slide>
            </vueper-slides>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
import { LazyYoutube } from "vue-lazytube";

export default {
    components: {
        VueperSlides,
        VueperSlide,
        LazyYoutube,
    },
    data() {
        return {
            product: {
                category_id: '',
                name: "",
                code: "",
                brand: {
                    name: "",
                },
                post: {
                    info_product: '',
                    path: 'https://www.youtube.com/watch?v=qeUfDaYAcsg'
                },
                price: 0,
                description: '',
                category: {
                    name: ''
                }
            },
            showLoading: true,
            showInfoProduct: true,
            otherProducts: [
                {
                    name: 'Tivi',
                    price: '0',
                    category_id: 0
                }
            ],
            rating: 4.5,
        };
    },
    created() {
        this.getCurrentProduct();
        this.getOtherProducts();
    },
    methods: {
        async getCurrentProduct() {
            await axios.get("/api/products/" + this.$route.params.id).then((res) => {
                this.product = res.data;
                this.showLoading = false;
            });
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        async getOtherProducts() {
            await axios.get("/api/products").then((res) => {
                this.otherProducts = res.data.filter((item) => {
                    return item.category_id == this.product.category_id && item.id != this.product.id;
                }).slice(0, 10);
            });
        },
        setCookie() {
            if (this.checkExistCookie()) {
                axios.post("/api/carts", {
                    product_id: this.product.id,
                    cart_id: this.getCookie("DienMay_cart_id")
                }).then((res) => {
                    this.$router.push({
                        name: "user.cart"
                    });
                });
            } else {
                const d = new Date();
                d.setTime(d.getTime() + (365*24*60*60*1000)); // 365 ngày
                let expires = "expires="+ d.toUTCString();
                let randomId = this.makeid(16);
                document.cookie = 'DienMay_cart_id' + "=" + randomId + ";" + expires + ";path=/";
                axios.post("/api/carts", {
                    product_id: this.product.id,
                    cart_id: randomId
                }).then((res) => {
                    this.$router.push({
                        name: "user.cart"
                    });
                });
            }
        },
        makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * 
            charactersLength));
            }
            return result;
        },
        checkExistCookie() {
            let cart = this.getCookie("DienMay_cart_id");
            if (cart != "") {
                return true;
            } else {
                return false;
            }
        },
        getCookie(cookieName) {
            let name = cookieName + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    },
    watch: {
        $route() {
            window.scrollTo(0,0);
            this.getCurrentProduct();
            this.getOtherProducts();
        },
    },
};
</script>
<style scoped>
.breadcrumb {
    font-size: 14px;
    font-weight: bolder;
    background-color: white;
}
.policy {
    font-size: 16px;
    padding: 0 8px;
}
.policy i {
    font-size: 20px;
    color: #2f80ed;
}
hr {
    opacity: 0.15;
}
.show-more {
    height: 1000px;
    overflow: hidden;
}
ol {
   list-style: none;
   counter-reset: item;
}
ol li {
   counter-increment: item;
   margin-bottom: 5px;
}
ol li::before {
   margin-right: 10px;
   content: counter(item);
   background: #4a90e2;
   border-radius: 100%;
   color: white;
   width: 1.3em;
   text-align: center;
   display: inline-block;
   font-size: 12px;
}
.h-100.cate {
    padding: 10px 15px 20px;
    display: grid;
}
.h-100.cate:hover {
    box-shadow: 0 2px 16px rgb(0 0 0 / 12%);
    cursor: pointer;
    transition-duration: 0.2s;
}
.h-100.cate:hover .item-img {
    padding-top: 0.5rem !important;
}
.h-100.cate:hover h6 {
    color: #288ad6;
}
.item-img {
    height: 189px;
    transition: 0.3s ease-in-out;
}
.view-more-products:hover {
    color: #288ad6;
    transition-duration: 0.2s;
    cursor: pointer;
}
</style>
