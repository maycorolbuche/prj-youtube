<template>
  <div class="m-5">
    Seja bem vindo!

      <b-form @submit.prevent="youtubeSearch()" class="my-5">
        <b-row>
          <b-form-group label="Buscar Vídeo:" class="col-9">
            <b-form-input
              v-model="form.search"
              type="search"
              required
            />
          </b-form-group>
          <b-form-group label="Itens por Página:" class="col-3">
            <b-form-input
              v-model="form.maxResults"
              type="number"
              required
            />
          </b-form-group>
        </b-row>
        <b-button type="submit" class="mt-3" variant="primary">Buscar</b-button>
      </b-form>

      <b-alert v-if="error" class="mt-3" show variant="danger">{{error}}</b-alert>

      <b-row>
        <div v-for="item in yt.items" :key="item.id.videoId">
          <b-card :img-src="item.snippet.thumbnails.medium.url" img-left class="mb-3">
            <b-card-text>
              <b>{{item.snippet.title}}</b>
              <br>{{item.snippet.description}}
              <br>
              <b-button variant="info" :href="'https://www.youtube.com/watch?v='+item.id.videoId" target="_blank">
                Acessar Vídeo
              </b-button>
            </b-card-text>
          </b-card>
        </div>
      </b-row>

  </div>
</template>

<script>
export default {
  data() {
    return {
      error: "",
      form: {
        search: '',
        maxResults: 5
      },
      yt: {}
    }
  },
  methods: {
    youtubeSearch: function(){
      var _this = this;
      let url = 'https://www.googleapis.com/youtube/v3/search';
      url += '?key=AIzaSyAymxkbi4lNPWwtprtQQPDzpmWo1dA_Tis';
      url += '&part=id,snippet';
      url += '&maxResults='+this.form.maxResults;
      url += '&q='+this.form.search;
      this.axios({
        method: 'get',
        url: url,
        headers: { }
      })
      .then(function (response) {
        _this.yt = response.data;
        _this.addHistoric();
      })
      .catch(function (error) {
        console.log(error);
        _this.error = "Erro ao carregar dados!";
      });
    },
    addHistoric: function(){
      var _this = this;
      let url = this.$root.url+'historic';

      this.axios({
        method: "post",
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.$root.token
        },
        data: new URLSearchParams({"search":this.form.search,"user_id":this.$root.user.id})
      })
      .then(function (response) {
        console.log(response.data)
      })
      .catch(function (error) {
        console.log(error);
      });
    },
  },
  mounted() {
    this.$root.validaToken();
  },
}
</script>
