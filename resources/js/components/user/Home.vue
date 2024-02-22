<template>
    <div style="background-color: white">
          <!-- Slider -->
        <b-carousel
            id="carousel-fade"
            style="text-shadow: 0px 0px 2px #000"
            fade
            :interval="4000"
            indicators
            controls
            img-width="1024"
            img-height="480"
        >
            <b-carousel-slide
                img-src="/storage/images/banner/banner_dienmay2.png"
            ></b-carousel-slide>
            <b-carousel-slide
                img-src="/storage/images/banner/banner_dienmay1.png"
            ></b-carousel-slide>
            <b-carousel-slide
                img-src="/storage/images/banner/banner_dienmay3.png"
            ></b-carousel-slide>
            
        </b-carousel>
        <!-- END Slider -->
        <div
            class="container mt-5 p-4"
            style="
                border-radius: 12px;
                background: linear-gradient(90deg, #ffecd2 0%, #fcb69f 100%);
            "
        >
            <h5 style="font-weight: 600">XU HƯỚNG MUA SẮM</h5>
            <div class="row">
                <div class="col-md-3">
                    <img
                        width="100%"
                        style="cursor: pointer"
                        src="/storage/images/banner/xuhuong1.png"
                    />
                </div>
                <div class="col-md-3">
                    <img
                        width="100%"
                        style="cursor: pointer"
                        src="/storage/images/banner/xuhuong2.png"
                    />
                </div>
                <div class="col-md-3">
                    <img
                        width="100%"
                        style="cursor: pointer"
                        src="/storage/images/banner/xuhuong3.png"
                    />
                </div>
                <div class="col-md-3">
                    <img
                        width="100%"
                        style="cursor: pointer"
                        src="/storage/images/banner/xuhuong4.png"
                    />
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="title-cate">TIVI</h5>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 text-danger text-right font-weight-bolder">
                    <router-link :to="{ name: 'user.products', query: { category_id: this.slidesTV[0].category_id } }" tag="span" class="viewAll">Xem tất cả {{lengthTV}} Tivi >
                    </router-link>
                </div>
            </div>
            <vueper-slides
                class="no-shadow"
                :visible-slides="5"
                slide-multiple
                :slide-ratio="1 / 4"
                :bullets="false"
                :touchable="false"
                fixedHeight="444px"
            >
                <vueper-slide v-for="(slide, i) in slidesTV" :key="slide.id">
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

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="title-cate">TỦ LẠNH</h5>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 text-danger text-right font-weight-bolder">
                    <router-link :to="{ name: 'user.products', query: { category_id: this.slidesTuLanh[0].category_id } }" tag="span" class="viewAll">Xem tất cả {{lengthTuLanh}} Tủ lạnh >
                    </router-link>
                </div>
            </div>
            <vueper-slides
                class="no-shadow"
                :visible-slides="5"
                slide-multiple
                :slide-ratio="1 / 4"
                :bullets="false"
                :touchable="false"
                fixedHeight="444px"
            >
                <vueper-slide v-for="(slide, i) in slidesTuLanh" :key="slide.id">
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

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="title-cate">MÁY GIẶT</h5>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 text-danger text-right font-weight-bolder">
                    <router-link :to="{ name: 'user.products', query: { category_id: this.slidesMayGiat[0].category_id } }" tag="span" class="viewAll">Xem tất cả {{lengthMayGiat}} Máy giặt >
                    </router-link>
                </div>
            </div>
            <vueper-slides
                class="no-shadow"
                :visible-slides="5"
                slide-multiple
                :slide-ratio="1 / 4"
                :bullets="false"
                :touchable="false"
                fixedHeight="444px"
            >
                <vueper-slide v-for="(slide, i) in slidesMayGiat" :key="slide.id">
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

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="title-cate">MÁY LỌC NƯỚC</h5>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 text-danger text-right font-weight-bolder">
                    <router-link :to="{ name: 'user.products', query: { category_id: this.slidesMayLocNuoc[0].category_id } }" tag="span" class="viewAll">Xem tất cả {{lengthMayLocNuoc}} Máy lọc nước >
                    </router-link>
                </div>
            </div>
            <vueper-slides
                class="no-shadow"
                :visible-slides="5"
                slide-multiple
                :slide-ratio="1 / 4"
                :bullets="false"
                :touchable="false"
                fixedHeight="444px"
            >
                <vueper-slide v-for="(slide, i) in slidesMayLocNuoc" :key="slide.id">
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

        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-6">
                    <img
                        width="100%"
                        src="/storage/images/banner/banner_footer1.png"
                        alt=""
                    />
                </div>
                <div class="col-md-6">
                    <img
                        width="100%"
                        src="/storage/images/banner/banner_footer2.png"
                        alt=""
                    />
                </div>
            </div>
        </div>

        <!-- App Container -->
    </div>
</template>

<script>
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
export default {
    components: { VueperSlides, VueperSlide },
    data() {
        return {
            rating: 3.5,
            slidesTV: [
                {
                    name: 'Tivi',
                    price: '0',
                    category_id: 0
                }
            ],
            slidesTuLanh: [
                {
                    name: 'Tủ lạnh',
                    price: '0',
                    category_id: 0
                }
            ],
            slidesMayGiat: [
                {
                    name: 'Máy giặt',
                    price: '0',
                    category_id: 0
                }
            ],
            slidesMayLocNuoc: [
                {
                    name: 'Máy lọc nước',
                    price: '0',
                    category_id: 0
                }
            ],
            lengthTV: 0,
            lengthTuLanh: 0,
            lengthMayGiat: 0,
            lengthMayLocNuoc: 0,
        };
    },
    created() {
        this.getTV();
        this.getTuLanh();
        this.getMayGiat();
        this.getMayLocNuoc();
    },
    methods: {
        getTV() {
            axios.get("/api/products").then((res) => {
                this.lengthTV = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'TIVI';
                }).length;
                this.slidesTV = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'TIVI';
                }).slice(0, 10);
            });
        },
        getTuLanh() {
            axios.get("/api/products").then((res) => {
                this.lengthTuLanh = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'TỦ LẠNH';
                }).length;
                this.slidesTuLanh = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'TỦ LẠNH';
                }).slice(0, 10);
            });
        },
        getMayGiat() {
            axios.get("/api/products").then((res) => {
                this.lengthMayGiat = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'MÁY GIẶT';
                }).length;
                this.slidesMayGiat = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'MÁY GIẶT';
                }).slice(0, 10);
            });
        },
        getMayLocNuoc() {
            axios.get("/api/products").then((res) => {
                this.lengthMayLocNuoc = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'MÁY LỌC NƯỚC';
                }).length;
                this.slidesMayLocNuoc = res.data.filter((item) => {
                    return item.category.name.toUpperCase() == 'MÁY LỌC NƯỚC';
                }).slice(0, 10);
            });
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
};
</script>
<style scoped>
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
.title-cate {
    color: #ed1c24;
    font-weight: bold;
}
.viewAll {
    cursor: pointer
}
</style>
