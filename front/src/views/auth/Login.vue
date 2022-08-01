<template>
  <div class="">
    <h2 class="mt-3"><center>Login</center></h2>

    <b-form @submit="onSubmit" class="mt-3 text-center w-50 mx-auto">
      <b-form-group id="input-group-1" label="E-mail:" label-for="input-1">
        <b-form-input id="email" v-model="form.email" type="email" placeholder="E-mail" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Senha:" label-for="input-2" class="mt-3">
        <b-form-input id="password" v-model="form.password" type="password" placeholder="Senha" required></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary mt-3">Entrar</b-button>
    </b-form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      show: true
    }
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      axios.post('http://127.0.0.1:8000/api/login',
      {
        email: this.form.email,
        password: this.form.password
      })
      .then(response =>
      {
        if(response.data.access_token)
        {
          sessionStorage.setItem('user', JSON.stringify(response.data));
          this.$router.push('/home');
        }
        else
        {
          console.log("ERROR");
        }
      })
      .catch(e =>
      {
        console.log(e);
      })
    }
  },
  created()
  {
    let authUser = sessionStorage.getItem('user');
    if(authUser)
    {
      this.$router.push('/home');
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>