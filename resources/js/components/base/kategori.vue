<template>

    <div class="container-fluid">
    <div class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Kategori</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a style="color:grey;" href="/">Beranda</a></li>
              <li class="breadcrumb-item active text-primary">Kategori</li>
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
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, key) in category.data" v-bind:key="category.id">
                                <td width="30px">{{key+1}}</td>
                                <td width="30px">{{category.id}}</td>
                                <td>{{category.name}}</td>
                                <td>{{category.description}}</td>
                                <td width="110px">
                                    <button @click="updateModal(category)" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteCategory(category.id)" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                 <div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                               <h5 v-show="!editmode" class="modal-title" id="addNewLabell" >Tambah Kategori</h5>
                                <h5 v-show="editmode" class="modal-title" id="addNewLabel" >Perbarui Kategori</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         <form @submit.prevent="editmode ? updateCategory() : makeCategory() ">
                            <div class="modal-body">
                                <div class="form-group">
                                  <input v-model="form.name" placeholder="Masukan Nama Kategori" class="form-control" type="text" name="kategori" id="kategori">
                                  <has-error :form="form" field="kategori"></has-error> 
                                </div>
                                <div class="form-group">
                                    <textarea v-model="form.description" type="text" name="description"
                                    placeholder="Masukan Deskripsi Kategori"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    </textarea>
                                    <has-error :form="form" field="description"></has-error>
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
                name:'',
                description:''
            })
        }
    },
    mounted() {
            console.log('Component mounted.')
            console.log('Terload');
            this.loadCategory()
            Fire.$on('Created',()=>{
                this.loadCategory()
            });
        },
    methods: {
        updateModal(category){
            this.editmode = true;
            this.form.clear();
            this.form.reset();
            $('#modalCategory').modal('show');
            this.form.fill(category);
        },
        makeModal(){
            this.editmode = false;
            this.form.reset();
            $('#modalCategory').modal('show');
        },
        updateCategory(){
            this.$Progress.start();
                this.form.put('api/kategori/'+this.form.id)
                .then(() => {
                Fire.$emit('Created')
                $('#modalCategory').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Kategori Berhasil diperbarui',
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
        deleteCategory(id){
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
                    this.form.delete('/api/kategori/'+id).then(()=>{
                      
                        swalWithBootstrapButtons.fire(
                      'Terhapus!',
                      'Kategori Telah Terhapus!.',
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
                      'Kategori Tidak Jadi Di Hapus!',
                      'error'
                    )
                  }
                })
            },
        loadCategory(){
        axios.get("api/kategori").then(({data}) => (this.category = data));
        },
        makeCategory(){
            this.$Progress.start();
                this.form.post('api/kategori')
                .then(() => {
                Fire.$emit('Created')
                $('#modalCategory').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Kategori Berhasil dibuat',
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