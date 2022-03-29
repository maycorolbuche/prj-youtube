import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: function () {
      return import('@/views/HomeView.vue')
    }
  },
  {
    path: '/login',
    name: 'login',
    component: function () {
      return import('@/views/LoginView.vue')
    }
  },
  {
    path: '/user',
    name: 'user',
    component: function () {
      return import('@/views/UserView.vue')
    }
  },
  {
    path: '/historic',
    name: 'historic',
    component: function () {
      return import('@/views/HistoricView.vue')
    }
  }
]

const router = new VueRouter({
  routes
})

export default router
