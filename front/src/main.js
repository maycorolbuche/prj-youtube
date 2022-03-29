import Vue from 'vue'
import App from './App.vue'
import router from './router'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

Vue.config.productionTip = false
Vue.config.silent = true

new Vue({
  router,
  render: h => h(App),
  data() {
    return {
      url: 'https://prj-back.maycorolbuche.com.br/api/',
      token: '',
      user: {}
    }
  },
  watch: {
    token() {
      localStorage.token = this.token;
    },
  },
  methods: {
    validaToken: function() {
      console.log("validando token");
      var _this = this;
      let url = this.url+'me'
      this.axios({
        method: 'post',
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token
        },
        data: new URLSearchParams({})
      })
      .then(function (response) {
        if (response.data.id){
          console.log("token validado");
          _this.user = response.data;
        }else{
          _this.$router.push('/login');
        }
      })
      .catch(function (error) {
        console.log(error);
        _this.$router.push('/login');
      });
    },
  },
  mounted(){
    if (localStorage.token){
      this.token = localStorage.token;
      this.validaToken();
    }else{
      this.$router.push('/login');
    }
  },
}).$mount('#app')
