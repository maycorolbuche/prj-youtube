<template>
  <div class="m-5">
    <h1>Histórico de Buscas</h1>

    <b-table striped hover :busy="isBusy" :items="items" :fields="fields">

      <template #table-busy>
        <div class="text-center my-2">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>

    </b-table>

  </div>
</template>

<style>
.sr-only{
  display:none;
}
</style>

<script>
export default {
  data() {
    return {
      error: "",
      isBusy: true,
      items: [],
      fields: [
        {
          key: 'id',
          label: 'ID',
          sortable: true
        },
        {
          key: 'search',
          label: 'Busca',
          sortable: true
        },
        {
          key: 'created_at',
          label: 'Data/Hora',
          sortable: true,
        },
      ],
    }
  },
  methods: {
    index: function(){
      var _this = this;
      let url = this.$root.url+'historic/'+this.$root.user.id
      this.axios({
        method: 'get',
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.$root.token
        },
        data: new URLSearchParams({})
      })
      .then(function (response) {
        _this.items = response.data;
        _this.isBusy = false;
      })
      .catch(function (error) {
        console.log(error);
        _this.isBusy = false;
        _this.error = "Erro ao carregar dados!";
      });
    },
  },
  mounted() {
    this.$root.validaToken();
    this.index();
  },
}
</script>
