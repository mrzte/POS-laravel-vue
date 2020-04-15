<template>

    <div class="container-fluid">
    <div class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a style="color:grey;" href="/">Beranda</a></li>
              <li class="breadcrumb-item active text-primary">Produk</li>
            </ol>
          </div>
        </div>
    
    </div>
        <div class="col-lg12">
            <div class="card">
                <div class="card-body">
                    <button @click="makeModal" class="mb-3 btn btn-primary">Tambah Data<i class="ml-2 fas fa-plus"></i></button>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="alert-primary">
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Terahir diperbarui</th>
                                <th>Kode Produk</th>
                                <th>Photo Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, key) in product.data" v-bind:key="product.id">
                                <td width="30px">{{key+1}}</td>
                                <td width="30px">{{product.id}}</td>
                                <td>{{product.name}}</td>
                                <td>{{product.stock}}</td>
                                <td>{{product.price}}</td>
                                <td>{{product.category_id}}</td>
                                <td>{{product.updated_at}}</td>
                                <td></td>
                                <td></td>
                                <td width="110px">
                                    <button @click="updateModal(category)" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteProduct(product.id)" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                 <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                               <h5 v-show="!editmode" class="modal-title" id="addNewLabell" >Tambah Produk</h5>
                                <h5 v-show="editmode" class="modal-title" id="addNewLabel" >Perbarui Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         <form @submit.prevent="editmode ? updateProduct() : makeProduct() ">
                            <div class="modal-body">
                                <div class="form-group">
                                  <input v-model="form.name" placeholder="Masukan Nama Product" class="form-control" type="text" name="name" id="name">
                                  <has-error :form="form" field="name"></has-error> 
                                </div>
                                <div class="form-group">
                                    <textarea v-model="form.stock" type="number" name="stock"
                                    placeholder="Masukan Stok Produk"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('stock') }">
                                    </textarea>
                                    <has-error :form="form" field="stock"></has-error>
                               </div>
                               <div class="form-group">
                                    <textarea v-model="form.price" type="number" name="price"
                                    placeholder="Masukan Harga Produk"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                                    </textarea>
                                    <has-error :form="form" field="price"></has-error>
                               </div>
                              <div class="form-group">
                                  <select v-model="form.category_id" name="kategori" id="kategori"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                    <option value="">Pilih Kategori</option>
                                    <option v-for="category in category" v-bind:key="category.id" :value="category.id">
                                      {{category.name}}
                                    </option>
                                  </select>
                                  <has-error :form="form" field="category_id"></has-error> 
                             </div>
                          </div>
                        <div class="modal-footer">
                            <button t="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Perbarui</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                        </form>
                    </div>
                </div>
       </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            editmode: false,
            category:{},
            form: new Form({
                id:'',
                name:''
            })
        }
    },
    data() {
        return {
            editmode: false,
            product:{},
            form: new Form({
                id:'',
                name:'',
                description:'',
                stock:'',
                price:'',
                category_id:''
            })
        }
    },
    mounted() {
            console.log('Component mounted.')
            console.log('Terload');
            this.loadProduct()
            Fire.$on('Created',()=>{
                this.loadProduct()
            });
        },
    methods: {
        updateModal(product){
            this.editmode = true;
            this.form.clear();
            this.form.reset();
            $('#modalProduct').modal('show');
            this.form.fill(product);
        },
        makeModal(){
            this.editmode = false;
            this.form.reset();
            $('#modalProduct').modal('show');
        },
        updateProduct(){
            this.$Progress.start();
                this.form.put('api/produk/'+this.form.id)
                .then(() => {
                Fire.$emit('Created')
                $('#modalProduct').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Produk Berhasil diperbarui',
                  'success'
                  )

                this.$Progress.finish();

                })
                .catch(()=>{
                    this.$Progress.fail();
                    
                swalWithBootstrapButtons.fire(
                  'Gagal!',
                  'Perhatikan lagi bidang yang di isi!',
                  'error'
                )


                })
        },
        deleteProduct(id){
                swalWithBootstrapButtons.fire({
                  title: 'Apa anda yakin?',
                  text: "",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Ya, Hapus Saja!',
                  cancelButtonText: 'Tidak, Batalkan!',
                //   reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    this.form.delete('/api/produk/'+id).then(()=>{
                      
                        swalWithBootstrapButtons.fire(
                      'Terhapus!',
                      'Produk Telah Terhapus!.',
                      'success'
                    )
                    Fire.$emit('Created')
                    })
                    
                    .catch(()=>{
                        swalWithBootstrapButtons.fire(
                      'Error',
                      'Ada Sesuatu Yang Salah!.',
                      'error'
                    )
                    })
                    
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Dibatalkan!',
                      'Produk Tidak Jadi Di Hapus!',
                      'error'
                    )
                  }
                })
            },
        loadProduct(){
            axios.get("api/kategori2").then(({data}) => (this.category = data));
            axios.get("api/kategori").then(({data}) => (this.product = data));    
        },
        makeProduct(){
            this.$Progress.start();
                this.form.post('api/produk')
                .then(() => {
                Fire.$emit('Created')
                $('#modalProduct').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Produk Berhasil dibuat',
                  'success'
                  )

                this.$Progress.finish();

                })
                .catch(()=>{
                    this.$Progress.fail();
                    
                swalWithBootstrapButtons.fire(
                  'Gagal!',
                  'Perhatikan lagi bidang yang di isi!',
                  'error'
                )


                })
        },
    }
}
</script>