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
                    <p class="login-box-msg">Đăng Nhập</p>
                    <form @submit.prevent="login">
                        <div class="input-group mb-3">
                            <input
                                type="email"
                                v-model="form.email"
                                class="form-control"
                                placeholder="Email"
                                required
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
                                placeholder="Mật khẩu"
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
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input
                                        type="checkbox"
                                        v-model="form.saveAccount"
                                        id="remember"
                                    />
                                    <label for="remember">
                                        Lưu thông tin đăng nhập
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block btn-sm mb-2"
                                >
                                    Đăng Nhập
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

                    <p class="mb-1">
                        <a href="forgot-password.html">Quên mật khẩu</a>
                    </p>
                    <p class="mb-0">
                        <!-- <a href="register.html" class="text-center">Đăng ký thành viên</a> -->
                    </p>
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
                saveAccount: true,
            },
            errors: "",
        };
    },
    methods: {
        async login() {
            await axios
                .post("/api/login", this.form)
                .then((res) => {
                    if (!this.form.saveAccount) {
                        sessionStorage.setItem("token", res.data.token);
                        sessionStorage.setItem("role", res.data.role);
                        sessionStorage.setItem("name", res.data.name);
                        sessionStorage.setItem("email", res.data.email);
                        sessionStorage.setItem("first-login", res.data.check_first_login == null ? true : false);
                        axios
                            .post("/api/logout")
                            .then(() => {})
                            .catch((err) => {
                                console.log(err);
                            });
                    } else {
                        localStorage.setItem("token", res.data.token);
                        localStorage.setItem("role", res.data.role);
                        localStorage.setItem("name", res.data.name);
                        localStorage.setItem("email", res.data.email);
                        localStorage.setItem("first-login", res.data.check_first_login == null ? true : false);
                    }
                    if (res.data.check_first_login == null) {
                        this.$router.push({ name: 'change-password' });
                    } else if (
                        res.data.role != "user"
                    ) {
                        location.href = "/admin";
                    } else {
                        this.$router.push("/");
                    }
                })
                .catch((err) => {
                    this.errors = Object.values(err.response.data.errors)[0];
                });
        },
    },
};
</script>

<style></style>
