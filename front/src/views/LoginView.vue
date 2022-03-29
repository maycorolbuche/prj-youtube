<template>
    <b-container class="m-5 p-5 col-8 mx-auto border">
      <b-form @submit.prevent="submit($event)">
        <b-form-group
          id="email-group"
          label="Login:"
          label-for="email"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group class="mt-3"
          id="password-group"
          label="Senha:"
          label-for="password"
        >
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            required
          ></b-form-input>
        </b-form-group>

        <b-alert v-if="error" class="mt-3" show variant="danger">{{error}}</b-alert>

        <b-button class="mt-3" type="submit" variant="primary">
          <b-spinner small v-if="loading"></b-spinner>
          <span v-else>Acessar</span>
        </b-button>
      </b-form>
    </b-container>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          email: "",
          password: "",
        },
        error: "",
        loading: false,
      }
    },
    mounted() {
      this.$root.token = "";
    },
    methods: {
      submit(event) {
        var _this = this;
        let url = _this.$root.url+'login'
        
        this.error = "";
        this.loading = true;

        this.axios({
          method: 'post',
          url: url,
          headers: { 
            'Accept': 'application/json', 
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          data: new URLSearchParams(_this.form)
        })
        .then(function (response) {
          if (response.data.token){
            _this.$root.token = response.data.token;
            _this.$root.validaToken();
            _this.$router.push('/');
          }else{
            _this.error = response.data.message;
          }
          console.log(response.data);
          _this.loading = false;
        })
        .catch(function (error) {
          console.log(error);
          _this.error = "Erro ao enviar dados!";
          _this.loading = false;
        });

/*
        let url = _this.$root.url+'login'
        fetch(url, {
          method: 'POST',
          body: new URLSearchParams(_this.form)
        })
        .then(response => console.log(response))
        //.then(response => response.json)
        .then(data => console.log(data))
        */
      },
    }
  }
</script>