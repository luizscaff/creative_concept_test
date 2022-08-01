<template>
  <div class="">
    <b-button v-on:click="backToIndex()" variant="primary m-3">Voltar</b-button>

    <h2><center>Novo Usuário</center></h2>

    <b-alert class="w-75 mx-auto" variant="success" :show="alertSuccess" fade>Registro salvo com sucesso!</b-alert>
    <b-alert class="w-75 mx-auto" variant="danger" :show="alertDanger" fade>Houve uma exceção</b-alert>

    <b-form @submit="onSubmit" class="mt-3 text-center w-50 mx-auto">
      <b-form-group id="input-group-1" label="Nome:" label-for="input-1">
        <b-form-input id="name" v-model="form.name" type="text" placeholder="Nome" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="E-mail:" label-for="input-2" class="mt-3">
        <b-form-input id="email" v-model="form.email" type="email" placeholder="E-mail" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Senha:" label-for="input-3" class="mt-3">
        <b-form-input id="password" v-model="form.password" type="password" placeholder="Senha" ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-4" label="Confirmar Senha:" label-for="input-4" class="mt-3">
        <b-form-input id="password_confirmation" v-model="form.password_confirmation" type="password" placeholder="Confirmar Senha" ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary mt-3">Salvar</b-button>
    </b-form>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserCreate',
  data () {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        id: null
      },
      user: JSON.parse(sessionStorage.getItem('user')),
      alertSuccess: false,
      alertDanger: false
    }
  },
  created()
  {
    var id_user_edit = this.$route.params.id;
    if(id_user_edit)
    {
      axios.get('http://127.0.0.1:8000/api/users/' + id_user_edit,
      {
        headers:
        {
          Authorization: "Bearer" + this.user.access_token
        }
      })
      .then(response => {
        this.form.name  = response.data.name;
        this.form.email = response.data.email;
        this.form.id    = response.data.id;
      });
    }
  },
  methods: 
  {
    ShowSuccessAlert()
    {
      this.alertSuccess = true;
      setTimeout(() => {
        this.alertSuccess = false;
      }, 2000);
    },
    ShowDangerAlert()
    {
      this.alertDanger = true;
      setTimeout(() => {
        this.alertDanger = false;
      }, 2000);
    },
    backToIndex()
    {
       this.$router.push('/users');
    },
    onSubmit(event)
    {
      event.preventDefault();

      if(this.form.id != null && this.form.id > 0)
      {
        axios.put('http://127.0.0.1:8000/api/users/' + this.form.id,
        {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
          id: this.form.id
        },
        {
          headers: {
            Authorization: "Bearer" + this.user.access_token
          }
        })
        .then(response =>
        {
          this.ShowSuccessAlert()
        })
        .catch(e =>
        {
          this.ShowDangerAlert()
        })
      }
      else
      {
        axios.post('http://127.0.0.1:8000/api/users',
        {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation
        },
        {
          headers: {
            Authorization: "Bearer" + this.user.access_token
          }
        })
        .then(response =>
        {
          this.ShowSuccessAlert()
        })
        .catch(e =>
        {
          this.ShowDangerAlert()
        })
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>