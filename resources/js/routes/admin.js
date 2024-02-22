const routes = [
    {
        path: "/admin",
        component: require("../components/admin/Index.vue").default,
        meta: {
            requiresAuth: true,
            requiresRole: 'admin',
            breadcrumb: 'Tổng Quan'
        },
        children: [
            {
                path: "",
                name: "admin.dashboard",
                component: require("../components/admin/Dashboard.vue").default,
                meta: {
                    title: "Trang Quản Trị",
                }
            },
            {
                path: "change-password",
                name: "change-password",
                component: require("../components/admin/login/ChangePassword.vue").default,
                meta: {
                    title: "Mật Khẩu Mới",
                },
            },
            {
                path: "changePassword",
                name: "changePassword",
                component: require("../components/admin/login/ChangePasswordWithOldPass.vue").default,
                meta: {
                    title: "Đổi Mật Khẩu",
                }
            },
            {
                path: "accounts",  
                name: "accounts",
                component: require("../components/admin/account/List.vue").default,
                meta: {
                    title: "Tài Khoản",
                    breadcrumb: 'Tài Khoản'
                },
            },
            {
                path: "roles",  
                name: "roles",
                component: require("../components/admin/account/Role.vue").default,
                meta: {
                    title: "Vai Trò",
                    breadcrumb: 'Vai Trò'
                },
            },
            {
                path: "categories",
                name: "categories",
                component: require("../components/admin/category/List.vue")
                    .default,
                meta: {
                    title: "Danh Mục Sản Phẩm",
                    breadcrumb: "Sản Phẩm"
                },
            },
            {
                path: "categories/create",
                name: "categories.create",
                component: require("../components/admin/category/Create.vue")
                    .default,
                meta: {
                    title: "Thêm Mới",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "categories",
                        }
                    },
                },
            },
            {
                path: "categories/edit/:id",
                name: "categories.edit",
                component: require("../components/admin/category/Edit.vue")
                    .default,
                meta: {
                    title: "Chỉnh Sửa",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "categories",
                        }
                    },
                },
            },
            {
                path: "types",
                name: "types",
                component: require("../components/admin/type/List.vue")
                    .default,
                meta: {
                    title: "Danh Sách Loại Sản Phẩm",
                    breadcrumb: "Loại Sản Phẩm"
                },
            },
            {
                path: "types/create",
                name: "types.create",
                component: require("../components/admin/type/Create.vue")
                    .default,
                meta: {
                    title: "Thêm Mới",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "types",
                        }
                    },
                },
            },
            {
                path: "types/edit/:id",
                name: "types.edit",
                component: require("../components/admin/type/Edit.vue")
                    .default,
                meta: {
                    title: "Chỉnh Sửa",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "types",
                        }
                    },
                },
            },
            {
                path: "brands",
                name: "brands",
                component: require("../components/admin/brand/List.vue")
                    .default,
                meta: {
                    title: "Danh Sách Thương Hiệu",
                    breadcrumb: "Thương Hiệu"
                },
            },
            {
                path: "brands/create",
                name: "brands.create",
                component: require("../components/admin/brand/Create.vue")
                    .default,
                meta: {
                    title: "Thêm Mới",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "brands",
                        }
                    },
                },
            },
            {
                path: "brands/edit/:id",
                name: "brands.edit",
                component: require("../components/admin/brand/Edit.vue")
                    .default,
                meta: {
                    title: "Chỉnh Sửa",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "brands",
                        }
                    },
                },
            },
            {
                path: "colors",
                name: "colors",
                component: require("../components/admin/color/List.vue")
                    .default,
                meta: {
                    title: "Danh Sách Màu Sắc",
                    breadcrumb: "Màu Sắc"
                },
            },
            {
                path: "colors/create",
                name: "colors.create",
                component: require("../components/admin/color/Create.vue")
                    .default,
                meta: {
                    title: "Thêm Mới",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "colors",
                        }
                    },
                },
            },
            {
                path: "colors/edit/:id",
                name: "colors.edit",
                component: require("../components/admin/color/Edit.vue")
                    .default,
                meta: {
                    title: "Chỉnh Sửa",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "colors",
                        }
                    },
                },
            },
            {
                path: "products",
                name: "products",
                component: require("../components/admin/product/List.vue")
                    .default,
                meta: {
                    title: "Danh Sách Sản Phẩm",
                    breadcrumb: "Sản Phẩm"
                },
            },
            {
                path: "products/create",
                name: "products.create",
                component: require("../components/admin/product/Create.vue")
                    .default,
                meta: {
                    title: "Thêm Mới",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "products",
                        }
                    },
                },
            },
            {
                path: "products/edit/:id",
                name: "products.edit",
                component: require("../components/admin/product/Edit.vue")
                    .default,
                meta: {
                    title: "Chỉnh Sửa",
                    breadcrumb() {
                        return {
                            label: this.$route.meta.title,
                            parent: "products",
                        }
                    },
                },
            },
            {
                path: "orders",
                name: "orders",
                component: require("../components/admin/order/List.vue").default,
                meta: {
                    title: "Danh Sách Đơn Hàng",
                    breadcrumb: "Đơn Hàng"
                },
            }
        ],
    },
    {
        path: "/admin/login",
        name: "admin.login",
        component: require("../components/admin/login/Login.vue").default,
        meta: {
            title: "Đăng Nhập",
            requiresAuth: false,
        },
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("token") || sessionStorage.getItem("token")) {
                if (localStorage.getItem("role") !== "user" || localStorage.getItem("role") !== "user") {
                    next({
                        path: "/admin",
                    });
                }
                else {
                    next({
                        path: "/",
                    });
                }
            }
            else {
                next();
            }
        },
    },
];

export default routes;
