<template>
  <div id="app">
    <b-navbar v-if="token" toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand href="#/" class="ms-2">Início</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="#/user" v-if="this.$root.user.type == 'A'">Usuários</b-nav-item>
          <b-nav-item href="#/historic" style="white-space: nowrap;">Histórico de Busca</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto w-100 d-flex justify-content-end">

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>
                <span v-if="user.name">{{ user.name }}</span>
                <span v-else>Usuário</span>
              </em>
            </template>
            <b-dropdown-item href="#" @click="logout()">Logout</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <router-view/>
  </div>
</template>

<style>
#app {
  height:100vh;
}
</style>

<script>
export default {
  data() {return this.$root.$data;},
  methods: {
    logout(event) {
      this.$root.token = "";
      this.$router.push('/login');
      let url = _this.$root.url+'logout'
      this.axios({
        method: 'post',
        url: url,
        headers: { 
          'Accept': 'application/json', 
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        data: new URLSearchParams(_this.form)
      });
    }
  }
}
</script>
