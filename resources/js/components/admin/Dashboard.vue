<template>
     <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0">Tổng Quan</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Tổng Quan</a></li>
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
        
            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>{{categories.length}}</h3>
        
                        <p>Danh Mục Sản Phẩm</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <router-link :to="{name: 'categories'}" tag="a" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>{{products.length}}</h3>
        
                        <p>Sản Phẩm</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      <router-link :to="{name: 'products'}" tag="a" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>{{ orders.length }}</h3>
        
                        <p>Đơn đặt hàng</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      <router-link :to="{name: 'orders'}" tag="a" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>{{ customers.length }}</h3>
        
                        <p>Khách hàng</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="card-title mt-2">Biểu đồ cột thống kê doanh thu</h5>
                      </div>
                      <div class="card-body">
                        <BarChart />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="card-title mt-2">Biểu đồ đường thống kê doanh thu</h5>
                      </div>
                      <div class="card-body">
                        <LineChart />
                      </div>
                    </div>
                  </div>
                  <!-- right col -->
                </div>
                <!-- /.row (main row) -->
              </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->
</template>

<script>
import BarChart from './charts/Bar.vue';
import LineChart from './charts/Line.vue';
export default {
  components: {
    BarChart,
    LineChart
  },
  data() {
    return {
      categories: [],
      products: [],
      orders: [],
      customers: [],
    }
  },
  created() {
    this.getCategories();
    this.getProducts();
    this.getOrders();
    this.getCustomers();
  },
  methods: {
    getCategories() {
      axios.get('/api/categories')
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    },
    getProducts() {
      axios.get('/api/products')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    },
    getOrders() {
      axios.get('/api/orders')
        .then(response => {
          this.orders = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    },
    getCustomers() {
      axios.get('/api/customers')
        .then(response => {
          this.customers = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    }
  }
}
</script>

<style>

</style>