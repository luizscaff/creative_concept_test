<template>
  <div class="">
    <h2 class="mt-3"><center>Seja bem vindo, {{ user.username }}!</center></h2>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data () {
    return {
      user: JSON.parse(sessionStorage.getItem('user'))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
