<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <h3><b>Điện Máy Như Ý</b></h3>
                    <p>Trang Quản Trị</p>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Tạo Mật Khẩu Mới</p>
                    <form @submit.prevent="login">
                        <div class="input-group mb-3">
                            <input
                                type="email"
                                v-model="form.email"
                                class="form-control"
                                placeholder="Email"
                                required
                                readonly
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input
                                type="password"
                                v-model="form.password"
                                class="form-control"
                                placeholder="Nhập mật khẩu mới"
                                required
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2 pl-1">
                            <span v-if="errors" style="color: tomato">{{
                                errors
                            }}</span>
                        </div>
                        <div class="row">
                            <div class="col-8"></div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block btn-sm mb-2"
                                >
                                    Xác nhận
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Đăng nhập bằng Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Đăng nhập bằng Google+
        </a>
      </div> -->
                    <!-- /.social-auth-links -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.login-box -->
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: "",
        };
    },
    created() {
        this.getCurrentUser();
    },
    methods: {
        getCurrentUser() {
            this.form.email = localStorage.getItem("email")
                ? localStorage.getItem("email")
                : sessionStorage.getItem("email");
        },
        async login() {
            await axios
                .post("/api/change-password", this.form)
                .then((res) => {
                    this.$swal({
                        title: "Thành công",
                        text: "Tạo mật khẩu mới thành công",
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        if (
                            res.data.role != "user"
                        ) {
                            location.href = "/admin";
                        } else {
                            this.$router.push("/");
                        }
                    });
                })
                .catch((err) => {
                    if (err.response.status == 403) {
                        this.$swal({
                            title: "Thông báo",
                            icon: "warning",
                            text: "Tài khoản đã được tạo mật khẩu mới trước đó! Để thay đổi mật khẩu xin mời chọn mục cập nhật thông tin tài khoản",
                        }).then(() => {
                            location.href = "/admin";
                        });
                    }
                });
        },
    },
};
</script>

<style></style>
