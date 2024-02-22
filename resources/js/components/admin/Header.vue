<template>
    <div>
        <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/storage/images/logo.png" alt="Logo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/admin" class="nav-link">Home</router-link>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/storage/images/logo.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/admin" class="brand-link">
      <img src="/storage/images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Điện Máy Như Ý</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/images/avatar_admin.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ currentUser.name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tổng Quan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/admin" tag="a" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Báo Cáo Thống Kê</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Danh Mục Sản Phẩm
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'categories' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'categories.create' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tv"></i>
              <p>
                Sản Phẩm
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'products' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'products.create' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm</p>
                </router-link>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-shopping-cart nav-icon"></i>
              <p>
                Đơn Đặt Hàng
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'orders' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-header">CHI TIẾT</li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="px-2" style="font-size:20px;font-weight:1000;font-family: Times New Roman, Times, serif;">L</span>
              <p>
                Loại Sản Phẩm
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'types' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'types.create' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="px-2" style="font-size:20px;font-weight:1000;font-family: Times New Roman, Times, serif;">T</span>
              <p>
                Thương Hiệu
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'brands' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'brands.create' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-medium-m"></i>
              <p>
                Màu Sắc
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'colors' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'colors.create' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item" v-if="currentUser.role == 'superadmin'">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Tài khoản
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'accounts' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Sách</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'roles' }" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vai trò</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <router-link :to="{name: 'changePassword'}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Đổi mật khẩu</p>
            </router-link>
          </li>
          <li class="nav-item">
            <a @click="logout" class="nav-link" style="cursor:pointer">
              <i class="fas fa-arrow-alt-circle-left nav-icon"></i>
              <p>Đăng xuất</p>
            </a>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUser: {
              name: '',
              email: '',
              role: '',
            },
        }
    },
    created(){
        this.getUser();
    },
    methods: {
        async logout(){
            await axios.post('/api/logout').then((res) => {
              localStorage.removeItem('name');
              localStorage.removeItem('email');
              localStorage.removeItem('token');
              localStorage.removeItem('role');
              localStorage.removeItem('first-login');
              sessionStorage.removeItem('name');
              sessionStorage.removeItem('email');
              sessionStorage.removeItem('token');
              sessionStorage.removeItem('role');
              sessionStorage.removeItem('first-login');

              if (window.location.pathname.includes('/admin')) {
                this.$router.push('/admin/login');
              } else {
                this.$router.push('/');
              }
            }).catch((err) => {
                console.log(err)
            })
        },
        getUser(){
            this.currentUser.email = localStorage.getItem('email') || sessionStorage.getItem('email');
            this.currentUser.name = localStorage.getItem('name') || sessionStorage.getItem('name');
            this.currentUser.role = localStorage.getItem('role') || sessionStorage.getItem('role');
        }
    },
}
</script>

<style scoped>
  a {
    text-decoration: unset;
  }
</style>