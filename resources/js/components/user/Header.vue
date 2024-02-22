<template>
    <div class="header">
        <!-- Header -->
        <div class="header-top border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2 text-center border-right">Giới thiệu</div>
                            <div class="col-md-2 text-center border-right">Tin tức</div>
                            <div class="col-md-2 text-center">Liên hệ</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

        <div class="header-mid container">
            <div class="row">
                <div class="col-md-6">
                    <router-link :to="{name: 'user.home'}">
                        <img src="/storage/images/logo.png" alt="Logo" width="60px" height="60px"> <span style="font-size:21px;font-weight:700;color:#ed1c24">Điện Máy Như Ý</span>
                    </router-link>
                </div>
                <div class="col-md-5 d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" class="form-control" :class="{'border-bottom-left-radius': borderBottomRadius}" v-model="keyword" @keyup="resultSearch()" placeholder="Nhập từ khóa tìm kiếm" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <router-link :to="{name: 'user.search', query:{q: keyword}}" @click.native="borderBottomRadius = !borderBottomRadius" tag="button" class="btn" style="border-top-right-radius: 25px;" :class="{'border-bottom-right-radius': borderBottomRadius}" type="button"><i class="fas fa-search"> </i> </router-link>
                        </div>
                        <div v-if="!borderBottomRadius" class="shadow-lg row rounded border border-bottom-right-radius border-bottom-left-radius" style="position:absolute; top:38px; width: 100.5%;background-color:white;z-index:3">
                            <div class="col-md-12 py-2" v-if="result.length > 0" style="background-color:#f5f5f5">
                                <h6 class="col-md-12 m-0">
                                    Sản phẩm gợi ý
                                </h6>
                            </div>
                            
                            <div v-for="(item) in result.slice(0,5)" :key="item.id" class="col-md-12">
                                <router-link :to="`/products/${item.id}`" class="text-dark">
                                    <div class="row p-2 border-bottom item-result-search"  @click="keyword = ''; result = ''; borderBottomRadius = !borderBottomRadius">
                                        <div class="col-md-3">
                                            <img :src="item.image" width="100%">
                                        </div>
                                        <div class="col-md-9">
                                            <h6 class="mt-3">{{item.name}} {{item.code}}</h6>
                                            <p class="font-weight-bold text-danger">{{ formatPrice(item.price) }}₫</p>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-center rou">
                    <router-link tag="span" :to="{name: 'user.orderHistory'}"><i class="fas fa-history mr-2"></i></router-link>
                    <router-link tag="span" :to="{name: 'user.cart'}"><i class="fas fa-shopping-cart"></i></router-link>
                </div>
            </div>
        </div>
       
        <div class="header-bottom">
            <div class="container">
                <ul>
                    <li v-b-toggle.sidebar-category><a style="" href="javascript:void(0)">Tất cả danh mục | </a></li>
                    <b-sidebar id="sidebar-category" title="Danh Mục Sản Phẩm" backdrop shadow>
                        <div class="px-3 py-2">
                            <div style="padding-left: 24px;font-size: 18px" v-for="category in categories" :key="category.id">
                                <router-link :to="{name: 'user.products', query: {category_id: category.id}}">
                                    {{ category.name }}
                                </router-link>
                            </div>
                            <h5 class="show-menu mt-3" @click="showMenuCate = !showMenuCate">Phân Loại</h5>
                            <vue-tree-navigation v-if="showMenuCate" :items="tree" />
                        </div>
                    </b-sidebar>
                    <li v-for="item in categories.slice(0,7)" :key="item.id"><router-link :to="{ name: 'user.products', query: {category_id: item.id} }">{{item.name}}</router-link></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            categories: [],
            tree: [],
            showMenuCate: false,
            keyword: '',
            result: '',
            timer: null,
            borderBottomRadius: true,
        }
    },
    async created() {
        await this.getCategories();
    },
    methods: {
        getCategories() {
            axios.get('/api/categories').then(res => {
                this.categories = res.data;
                this.tree = this.categories.map(category => {
                return {
                    id: category.id,
                    name: category.name,
                    children: [{
                        name: 'Thương hiệu',
                        children: category.brands.map(brand => {
                            return {
                                id: brand.id,
                                name: brand.name,
                                path: `/products?category_id=${category.id}&brand_id=${brand.id}`
                            }
                        })
                    },
                    {
                        name: 'Loại',
                        children: category.types.map(type => {
                            return {
                                id: type.id,
                                name: type.name,
                                path: `/products?category_id=${category.id}&type_id=${type.id}`
                            }
                        })
                    }],
                }
            });
            });
        },
        resultSearch() {
            if (this.keyword.trim() != '') {
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    axios.post('/api/products/search', {
                                keyword: this.keyword
                            }).then(res => {
                                this.result = res.data;
                                this.borderBottomRadius = false;
                            });
                }, 500);
            } else {
                this.result = '';
                this.borderBottomRadius = true;
            }
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
    watch: {
        $route() {
            this.$route.name != 'user.search' ? this.keyword = '' : null;
        }
    }
}
</script>
<style scoped>
    .header {
        background-color: white;
    }
    .header-top .col-md-2 {
        line-height: 38px;
    }
    .header-top .col-md-2:hover {
        background: #f2f2f2;
        cursor: pointer;
    }
    .header-mid .col-md-6 {
        line-height: 80px;
    }
    .header-mid .col-md-5 input {
        border-top-left-radius: 25px;
    }
    .header-mid .col-md-5 button {
        border-top-right-radius: 25px;
        background-color: #ed1c24;
        color: white;
    }
    .header-mid .col-md-5 button:hover {
        background-color: #ea0008be;
    }
    .header-mid .col-md-1 span {
        color: #ed1c24;
        font-size: 20px;
    }
    .header-mid .col-md-1 span:hover>i {
        color: #ea00089d;
        cursor: pointer;
    }
    .header-bottom {
        background-color: #ed1c24;
        box-shadow: 0 4px 4px rgb(0 0 0 / 25%);
    }
    .header-bottom .container ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
    .header-bottom .container li {
        float: left;
    }
    .header-bottom .container li>a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-weight: 600;
    }
    .header-bottom .container li>a:hover {
        background-color: rgba(0, 0, 0, .07)
    }
    .show-menu {
        cursor: pointer;
    }
    .show-menu:hover {
        color: #0d6efd;
        cursor: pointer;
        transition-duration: 0.3s;
    }
    .border-bottom-right-radius {
        border-bottom-right-radius: 25px;
    }
    .border-bottom-left-radius {
        border-bottom-left-radius: 25px;
    }
    .item-result-search:hover {
        background-color: #f8f9fac4 !important;
    }
</style>