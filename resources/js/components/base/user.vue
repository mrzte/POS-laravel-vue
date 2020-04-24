<template>

    <div class="container-fluid">
    <div class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manajemen Pengguna</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a style="color:grey;" href="/">Beranda</a></li>
              <li class="breadcrumb-item active text-primary">Manajemen Hak Akses</li>
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
                                <th>Alamat Surel</th>
                                <th>Status</th>
                                <th>Level</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(users, key) in users.data" v-bind:key="users.id">
                                <td width="30px">{{key+1}}</td>
                                <td width="120px">{{users.name}}</td>
                                <td width="50px">{{users.email}}</td>
                                <td width="50px">
                                  <span class="badge badge-danger" v-if="users.status == '0'">
                                     Tidak Aktif
                                  </span>
                                  <span class="badge badge-success" v-if="users.status == '1'">
                                     Aktif
                                  </span>
                              </td>
                              <td width="50px">
                                  <span class="badge badge-warning" v-if="users.level == 'User'">
                                     User
                                  </span>
                                  <span class="badge badge-primary" v-if="users.level == 'Admin'">
                                     Admin
                                  </span>
                              </td>
                                <td>{{users.created_at}}</td>
                                <td width="110px">
                                    <button @click="updateModal(users)" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteUsers(users.id)" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                 <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                               <h5 v-show="!editmode" class="modal-title" id="addNewLabell" >Tambah Pengguna</h5>
                                <h5 v-show="editmode" class="modal-title" id="addNewLabel" >Perbarui Pengguna</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         <form @submit.prevent="editmode ? updateUser() : makeUser() ">
                            <div class="modal-body">
                                <div class="form-group">
                                  <label for="name">Nama</label>
                                  <input v-model="form.name" placeholder="Masukan Nama Hak Akses" class="form-control" type="text" name="kategori" id="kategori">
                                  <has-error :form="form" field="kategori"></has-error> 
                                </div>
                                <div class="form-group">
                                  <label for="surel">Alamat Surel</label>
                                  <input v-model="form.email" placeholder="Masukan Email" class="form-control" type="email" name="email" id="email">
                                  <has-error :form="form" field="email"></has-error> 
                                </div>
                                <div v-show="editmode" class="form-group">
                                  <label for="status">Status</label>
                                <div class="form-check">
                                  <input v-model="form.status" type="radio" name="status" id="status" value="1">
                                  <label class="form-check-label" for="exampleRadios1">
                                    Aktif
                                  </label>
                                  <has-error :form="form" field="status"></has-error> 
                                </div>
                                <div class="form-check">
                                  <input v-model="form.status" type="radio" name="status" id="status" value="0">
                                  <label class="form-check-label" for="exampleRadios1">
                                   Tidak Aktif
                                  </label>
                                  <has-error :form="form" field="status"></has-error> 
                                 </div>
                                </div>
                                <div class="form-group">
                                  <label for="status">Level Wewenang</label>
                                <div class="form-check">
                                  <input v-model="form.level" type="radio" name="admin" id="admin" value="Admin">
                                  <label class="form-check-label" for="admin">
                                    Admin
                                  </label>
                                  <has-error :form="form" field="level"></has-error> 
                                </div>
                                <div class="form-check">
                                  <input v-model="form.level" type="radio" name="user" id="user" value="User">
                                  <label class="form-check-label" for="exampleRadios1">
                                   User
                                  </label>
                                  <has-error :form="form" field="level"></has-error> 
                                 </div>
                                </div>
                                <div class="form-group">
                                  <label for="surel">Kata Sandi</label>
                                  <input v-model="form.password" placeholder="Masukan Password" class="form-control" type="password" name="password" id="password">
                                  <has-error :form="form" field="password"></has-error> 
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
            users:{},
            form: new Form({
                id:'',
                name:'',
                email:'',
                role:'',
                level:'',
                status:'',
                password:''
            })
        }
    },
    mounted() {
            console.log('Component mounted.')
            console.log('Terload');
            this.loadUser()
            Fire.$on('Created',()=>{
                this.loadUser()
            });
        },
    methods: {
        updateModal(users){
            this.editmode = true;
            this.form.clear();
            this.form.reset();
            $('#modalUser').modal('show');
            this.form.fill(users);
        },
        makeModal(){
            this.editmode = false;
            this.form.reset();
            $('#modalUser').modal('show');
        },
        updateUser(){
            this.$Progress.start();
                this.form.put('api/users/'+this.form.id)
                .then(() => {
                Fire.$emit('Created')
                $('#modalUser').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Pengguna Berhasil diperbarui',
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
        deleteUser(id){
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
                    this.form.delete('/api/users/'+id).then(()=>{
                      
                        swalWithBootstrapButtons.fire(
                      'Terhapus!',
                      'Pengguna Telah Terhapus!.',
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
                      'Pengguna Tidak Jadi Di Hapus!',
                      'error'
                    )
                  }
                })
            },
        loadUser(){
        axios.get("api/users").then(({data}) => (this.users = data));
        },
        makeUser(){
            this.$Progress.start();
                this.form.post('api/users')
                .then(() => {
                Fire.$emit('Created')
                $('#modalUser').modal('hide')
      
                swalWithBootstrapButtons.fire(
                  'Berhasil!',
                  'Pengguna Berhasil dibuat',
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