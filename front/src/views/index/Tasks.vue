<template>
  <div class="">
    <b-button v-on:click="createTask()" variant="primary m-3">Nova Tarefa</b-button>
    <h2><center>Tarefas</center></h2>

    <b-alert class="w-75 mx-auto" variant="success" :show="alertSuccess" fade>Registro excluído com sucesso.</b-alert>
    <b-alert class="w-75 mx-auto" variant="danger" :show="alertDanger" fade>Houve uma exceção</b-alert>

    <b-table ref="tableTasks" striped hover :items="tasks" :fields="fields" class="w-75 mx-auto">
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
  name: 'Tasks',
  data () {
    return {
      user: JSON.parse(sessionStorage.getItem('user')),
      tasks: [],
      fields: [
        {key: 'name', label: 'Nome'},
        {key: 'responsible.name', label: 'Responsável'},
        {key: 'due_date', label: 'Prazo'},
        {key: 'task_status.name', label: 'Situação'},
        {key: 'edit', label: ''}
      ],
      alertSuccess: false,
      alertDanger: false
    }
  },
  created() 
  {
    axios.get('http://127.0.0.1:8000/api/tasks',
    {
      headers:
      {
        Authorization: "Bearer" + this.user.access_token
      }
    })
    .then(response =>
    {
      console.log(response);
      this.tasks = response.data;
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
    createTask()
    {
      this.$router.push('/tasks/create');
    },
    editItem(item)
    {
      this.$router.push('/tasks/' + item.id_task + '/edit');
    },
    deleteItem(item)
    {
      if(confirm("Essa ação é irreversível. Tem certeza de que deseja excluir esse registro?"))
        axios.delete('http://127.0.0.1:8000/api/tasks/' + item.id_task,
        {
          headers:
          {
            Authorization: "Bearer" + this.user.access_token
          }
        })
        .then(response =>
        {
          const index = this.tasks.findIndex(task => task.id_task === item.id_task) // find the post index 
          if (~index) // if the post exists in array
            this.tasks.splice(index, 1) //delete the post

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