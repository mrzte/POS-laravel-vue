<template>

    <div class="container-fluid">
    <div class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manajemen Roles/Wewenang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a style="color:grey;" href="/">Beranda</a></li>
              <li class="breadcrumb-item active text-primary">Manajemen Roles</li>
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
                                <th>Nama</th>
                                <th>Guard</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, key) in role.data" v-bind:key="role.id">
                                <td width="30px">{{key+1}}</td>
                                <td width="120px">{{role.name}}</td>
                                <td width="50px">{{role.guard_name}}</td>
                                <td>{{role.created_at}}</td>
                                <td width="110px">
                                    <button @click="updateModal(role)" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteRole(role.id)" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                 <div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                               <h5 v-show="!editmode" class="modal-title" id="addNewLabell" >Tambah Hak Akses</h5>
                                <h5 v-show="editmode" class="modal-title" id="addNewLabel" >Perbarui Hak Akses</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         <form @submit.prevent="editmode ? updateRole() : makeRole() ">
                            <div class="modal-body">
                                <div class="form-group">
                                  <label for="name">Nama</label>
                                  <input v-model="form.name" placeholder="Masukan Nama Hak Akses" class="form-control" type="text" name="kategori" id="kategori">
                                  <has-error :form="form" field="kategori"></has-error> 
                                </div>
                                <div class="form-group">
                                  <label for="guard">Guard</label>
                                    <textarea v-model="form.guard_name" type="text" name="description"
                                    placeholder="Masukan Guard Hak Akses"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('guard_name') }">
                                    </textarea>
                                    <has-error :form="form" field="guard_name"></has-error>
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
            role:{},
            form: new Form({
                id:'',
                name:'',
                guard_name:''
            })
        }
    },
    mounted() {
            console.log('Component mounted.')
            console.log('Terload');
            this.loadRole()
            Fire.$on('Created',()=>{
                this.loadRole()
            });
        },
    methods: {
        updateModal(role){
            this.editmode = true;
            this.form.clear();
            this.form.reset();
            $('#modalRole').modal('show');
            this.form.fill(role);
        },
        makeModal(){
            this.editmode = false;
            this.form.reset();
            $('#modalRole').modal('show');
        },
        updateRole(){
            this.$Progress.start();
                this.form.put('api/role/'+this.form.id)
                .then(() => {
                Fire.$emit('Created')
                $('#modalRole').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Hak Akses Berhasil diperbarui',
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
        deleteRole(id){
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
                    this.form.delete('/api/role/'+id).then(()=>{
                      
                        swalWithBootstrapButtons.fire(
                      'Terhapus!',
                      'Hak Akses Telah Terhapus!.',
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
                      'Hak Akses Tidak Jadi Di Hapus!',
                      'error'
                    )
                  }
                })
            },
        loadRole(){
        axios.get("api/role").then(({data}) => (this.role = data));
        },
        makeRole(){
            this.$Progress.start();
                this.form.post('api/role')
                .then(() => {
                Fire.$emit('Created')
                $('#modalRole').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Hak Akses Berhasil dibuat',
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