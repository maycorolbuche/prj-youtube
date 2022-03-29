<template>
  <div class="m-5">
    <h1>Usuários</h1>

    <div v-if="this.$root.user.type == 'A'">
      <b-button size="sm" variant="info" @click="add()">
        <b-icon-plus></b-icon-plus>
        Novo
      </b-button>
      <b-alert v-if="error" class="mt-3" show variant="danger">{{error}}</b-alert>
      <b-alert v-if="info" class="mt-3" show variant="info">{{info}}</b-alert>

      <b-form v-if="item >= 0" @submit.prevent="submit($event)" class="my-5">
        <b-row>
          <b-form-group label="Nome:" class="col-6">
            <b-form-input
              v-model="form.name"
              type="text"
              required
            >
            </b-form-input>
          </b-form-group>

          <b-form-group label="Sobrenome:" class="col-6">
            <b-form-input
              v-model="form.last_name"
              type="text"
              required
            >
            </b-form-input>
          </b-form-group>
        </b-row>
        <b-row class="mt-3">
          <b-form-group label="Telefone:" class="col-6">
            <b-form-input
              v-model="form.phone"
              type="text"
              required
            >
            </b-form-input>
          </b-form-group>

          <b-form-group label="E-mail:" class="col-6">
            <b-form-input
              v-model="form.email"
              type="email"
              required
            >
            </b-form-input>
          </b-form-group>
        </b-row>
        <b-row class="mt-3">
          <b-form-group label="Tipo:" class="col-6">
            <b-form-radio v-model="form.type" value="A"> &nbsp; Administrador</b-form-radio>
            <b-form-radio v-model="form.type" value="U"> &nbsp; Usuário</b-form-radio>
          </b-form-group>

          <b-form-group label="Senha:" class="col-6">
            <b-form-input
              v-model="form.password"
              type="password"
              required
            >
            </b-form-input>
          </b-form-group>
        </b-row>
        <div class="mt-4">
          <b-button v-if="item == 0" class="mx-1" type="submit" variant="primary">
            <span>Cadastrar</span>
          </b-button>
          <b-button v-if="item > 0" class="mx-1" type="submit" variant="success">
            <span>Salvar</span>
          </b-button>
          <b-button v-if="item > 0" class="mx-1" variant="danger" @click="del()">
            <span>Excluir</span>
          </b-button>
          <b-button class="mx-1" variant="warning" @click="cancel()">
            <span>Cancelar</span>
          </b-button>
        </div>
      </b-form>

      <b-table striped hover :busy="isBusy" :items="items" :fields="fields">

        <template #table-busy>
          <div class="text-center my-2">
            <b-spinner class="align-middle"></b-spinner>
          </div>
        </template>

        <template #cell(index)="data">
          <b-button size="sm" variant="warning" @click="edit(data.item)">
            <b-icon-pencil></b-icon-pencil>
            Editar
          </b-button>
        </template>

      </b-table>
    </div>
    <b-alert v-else class="mt-3" show variant="danger">Você não tem permissão para acessar esta tela!</b-alert>
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
      item: -1,
      items: [],
      form: {
        id: '',
        name: '',
        last_name: '',
        phone: '',
        email: '',
        type: 'U',
        password: '',
      },
      fields: [
        {
          key: 'index',
          label: '',
          sortable: false
        },
        {
          key: 'id',
          label: 'ID',
          sortable: true
        },
        {
          key: 'name',
          label: 'Nome',
          sortable: true
        },
        {
          key: 'last_name',
          label: 'Sobrenome',
          sortable: true,
        },
        {
          key: 'type',
          label: 'Tipo',
          sortable: true,
        },
        {
          key: 'email',
          label: 'E-mail',
          sortable: true,
        },
        {
          key: 'phone',
          label: 'Telefone',
          sortable: true,
        }
      ],
    }
  },
  methods: {
    index: function(){
      var _this = this;
      let url = this.$root.url+'user'
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

    reset: function(){
      this.error = "";
      this.info = "";
      this.form.id = '';
      this.form.name = '';
      this.form.last_name = '';
      this.form.phone = '';
      this.form.email = '';
      this.form.type= 'U';
      this.form.password = '';
    },
    add: function(){
      this.reset();
      this.item=0;
    },
    edit: function(item){
      this.reset();
      this.form.id=item.id;
      this.form.name=item.name;
      this.form.last_name=item.last_name;
      this.form.phone=item.phone;
      this.form.email=item.email;
      this.form.type=item.type;
      this.form.password=item.password;
      this.item=item.id;
    },
    cancel: function(){
      this.reset();
      this.item=-1;
    },
    submit: function(){
      var _this = this;
      let url = this.$root.url+'user'+(this.form.id !== ""?"/"+this.form.id:"");

      this.axios({
        method: (this.form.id !== ""?"put":"post"),
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.$root.token
        },
        data: new URLSearchParams(_this.form)
      })
      .then(function (response) {
        if (response.data.id){
          _this.reset();
          _this.cancel();
          _this.index();
          _this.info = "Usuário salvo com sucesso!";
        }else{
          _this.error = response.data.message;
        }
      })
      .catch(function (error) {
        console.log(error);
        _this.error = "Erro ao salvar!";
      });
    },
    del: function(){
      var _this = this;
      let url = this.$root.url+'user/'+this.form.id;

      this.axios({
        method: "delete",
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.$root.token
        },
        data: new URLSearchParams(_this.form)
      })
      .then(function (response) {
        _this.reset();
        _this.cancel();
        _this.index();
        _this.error = response.data.message;
      })
      .catch(function (error) {
        console.log(error);
        _this.error = "Erro ao salvar!";
      });
    }
  },
  mounted() {
    this.$root.validaToken();
    this.index();
  },
}
</script>
