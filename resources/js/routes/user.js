const routes = [
    {
        path: "",
        component: require("../components/user/Index.vue").default,
        meta: {
            breadcrumb: "Điện Máy Như Ý",
        },
        children: [
            {
                path: "",
                name: "user.home",
                component: require("../components/user/Home.vue").default,
            },
            {
                path: "products",
                name: "user.products",
                component: require("../components/user/products/List.vue").default,
                meta: {
                    title: "Danh Sách Sản Phẩm",
                }
            },
            {
                path: "products/:id",
                name: "user.products.details",
                component: require("../components/user/products/Details.vue").default,
                meta: {
                    title: "Chi Tiết Sản Phẩm",
                }
            },
            {
                path: "cart",
                name: "user.cart",
                component: require("../components/user/products/Cart.vue").default,
                meta: {
                    title: "Giỏ Hàng",
                }
            },
            {
                path: "search",
                name: "user.search",
                component: require("../components/user/products/Search.vue").default,
                meta: {
                    title: "Kết Quả Tìm Kiếm",
                }
            },
            {
                path: "orderHistory",
                name: "user.orderHistory",
                component: require("../components/user/history/OrderHistory.vue").default,
                meta: {
                    title: "Lịch Sử Đơn Hàng",
                }
            }
        ],
    },
];

export default routes;
