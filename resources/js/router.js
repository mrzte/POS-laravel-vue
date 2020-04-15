import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/kategori', component:require('./components/base/kategori.vue').default },
    { path: '/home', component:require('./components/base/home.vue').default },
]

const router = new VueRouter({
    mode: 'history',
   routes // short for `routes: routes`
})
