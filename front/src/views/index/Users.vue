<template>
  <div class="">
    <b-button v-on:click="createUser()" variant="primary m-3">Novo Usuário</b-button>
    <h2><center>Usuários</center></h2>

    <b-alert class="w-75 mx-auto" variant="success" :show="alertSuccess" fade>Registro excluído com sucesso.</b-alert>
    <b-alert class="w-75 mx-auto" variant="danger" :show="alertDanger" fade>Houve uma exceção</b-alert>

    <b-table ref="tableUsers" striped hover :items="users" :fields="fields" class="w-75 mx-auto">
      <template v-slot:cell(edit)="{ item }">
        <span><b-button v-on:click="editItem(item)" variant="primary">Editar</b-button></span>
        <span><b-button v-on:click="deleteItem(item)" variant="danger">Apagar</b-button></span>
      </template>
    </b-table>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Users',
  data () {
    return {
      user: JSON.parse(sessionStorage.getItem('user')),
      users: [],
      fields: [
        {key: 'name', label: 'Nome'},
        {key: 'email', label: 'E-mail'},
        {key: 'edit', label: ''}
      ],
      alertSuccess: false,
      alertDanger: false
    }
  },
  created() 
  {
    console.log(this.user);
    axios.get('http://127.0.0.1:8000/api/users',
    {
      headers:
      {
        Authorization: "Bearer" + this.user.access_token
      }
    })
    .then(response =>
    {
      this.users = response.data;
    });
  },
  methods: {
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
    createUser()
    {
      this.$router.push('/users/create');
    },
    editItem(item)
    {
      this.$router.push('/users/' + item.id + '/edit');
    },
    deleteItem(item)
    {
      if(confirm("Essa ação é irreversível. Tem certeza de que deseja excluir esse registro?"))
        axios.delete('http://127.0.0.1:8000/api/users/' + item.id,
        {
          headers:
          {
            Authorization: "Bearer" + this.user.access_token
          }
        })
        .then(response =>
        {
          const index = this.users.findIndex(user => user.id === item.id) // find the post index 
          if (~index) // if the post exists in array
            this.users.splice(index, 1) //delete the post

          this.ShowSuccessAlert()
        })
        .catch(response =>
        {
          this.ShowDangerAlert()
        });
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
