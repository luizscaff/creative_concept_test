<template>
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand to="/home" style="margin-left:15px">Creative Concept</b-navbar-brand>

    <b-navbar-toggle target="navbar-toggle-collapse" style="margin-right:15px">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
        <b-icon v-else icon="chevron-bar-down"></b-icon>
      </template>
    </b-navbar-toggle>

    <b-collapse id="navbar-toggle-collapse" is-nav>
      <b-navbar-nav class="text-right ml-auto">
        <b-nav-item v-if="this.$route.name != 'Login'" to="/tasks" style="text-align:right; margin-right:15px">Tarefas</b-nav-item>
        <b-nav-item v-if="this.$route.name != 'Login'" to="/users" style="text-align:right; margin-right:15px">Usuários</b-nav-item>
        <b-nav-item v-if="this.$route.name != 'Login'" v-on:click="logout()" style="text-align:right; margin-right:15px">Logout</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  name: 'NavBar',
  data(){
    return {
      user: false
    }
  },
  methods: {
    //Talvez o melhor aqui fosse utilizar o método logout do AuthController
    //e talvez o melhor fosse esse método nem estar no componente de NavBar
    logout() {
      sessionStorage.clear();
      this.user = false;
      this.$router.push('/login');
    }
  }
}
</script>

<style scoped>

</style>