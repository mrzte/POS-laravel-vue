require('./bootstrap');

window.Vue = require('vue');


//Vue Form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Sweetalert 2
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
  
  const swalWithBootstrapButtons = swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger ml-2'
    },
    buttonsStyling: false
  })
  
  
  window.swalWithBootstrapButtons = swalWithBootstrapButtons;
  window.toast = toast;

//Vue Progressbar
import VueProgressBar from 'vue-progressbar'
const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 200
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options)

// //Vue Filters
// Vue.filters('upText', function(text){
//   return text.toUpperCase()
// })

//Vue Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
let routes = [
    { path: '/kategori', component:require('./components/base/kategori.vue').default },
    { path: '/home', component:require('./components/base/home.vue').default },
    { path: '/produk', component:require('./components/base/produk.vue').default },
    { path: '/role', component:require('./components/base/role.vue').default },
    { path: '/user', component:require('./components/base/user.vue').default },
    { path: '/developer', component: require('./components/base/passport.vue').default },
]

const router = new VueRouter({
    mode: 'history',
   routes 
})

//Laravel Passport Frontend
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

//Vue Componet Load
Vue.component('kategori', require('./components/base/kategori.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Custom Event
window.Fire = new Vue();

//Vue Core
const app = new Vue({
    el: '#app',
    router
});
