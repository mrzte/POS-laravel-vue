<template>
    <div class="container-fluid">
      <div class="content-header">
        
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dasbor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a style="color:grey;" href="/">Beranda</a></li>
                <li class="breadcrumb-item active text-primary">Dasbor</li>
                </ol>
            </div>
            </div>
        
     </div>
    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{hitung_stok}}</h3>

                <p>Produk</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{hitung}}</h3>

                <p>Verifikasi Pengguna</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <router-link to="/user" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
</div>
</template>
<script >
  export default {
    data() {
        return {
            editmode: false,
            hitung_stok:{},
            form: new Form({
                
            })
        }
    },
    data() {
        return {
            editmode: false,
            hitung:{},
            form: new Form({
                
            })
        }
    },
    mounted() {
            console.log('Component mounted.')
            console.log('Terload')
            this.loadHitung()
        },
    methods: {
      loadHitung(){
        axios.get("hitung").then(({data}) => (this.hitung_stok = data))
        axios.get("api/hitung").then(({data}) => (this.hitung = data))
      }

     }    
    }    
</script>