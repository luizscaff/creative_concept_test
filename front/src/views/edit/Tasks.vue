<template>
  <div class="">
    <b-button v-on:click="backToIndex()" variant="primary m-3">Voltar</b-button>

    <h2><center>Nova Tarefa</center></h2>

    <b-alert class="w-75 mx-auto" variant="success" :show="alertSuccess" fade>Registro salvo com sucesso!</b-alert>
    <b-alert class="w-75 mx-auto" variant="danger" :show="alertDanger" fade>Houve uma exceção</b-alert>

    <b-form @submit="onSubmit" class="mt-3 text-center w-50 mx-auto">
      <b-form-group id="input-group-1" label="Nome:" label-for="input-1">
        <b-form-input id="name" v-model="form.name" type="text" placeholder="Nome" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Prazo:" label-for="input-2" class="mt-3">
        <b-form-input id="due_date" v-model="form.due_date" type="datetime-local" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Responsável:" label-for="input-3" class="mt-3">
        <b-form-select id="id_user" v-model="form.id_user" :options="id_user" class="form-control" ></b-form-select>
      </b-form-group>

      <b-form-group id="input-group-4" label="Situação:" label-for="input-4" class="mt-3">
        <b-form-select id="id_task_status" v-model="form.id_task_status" :options="id_task_status" class="form-control" required ></b-form-select>
      </b-form-group>

      <b-button type="submit" variant="primary mt-3">Salvar</b-button>
    </b-form>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'TaskCreate',
  data () {
    return {
      form: {
        name: '',
        due_date: '',
        id_task_status: null,
        id_user: null,
        id_task: null
      },
      user: JSON.parse(sessionStorage.getItem('user')),
      id_user: [
        { value: null, text: 'Selecione uma opção' }
      ],
      id_task_status: [
        { value: null, text: 'Selecione uma opção' }
      ],
      alertSuccess: false,
      alertDanger: false
    }
  },
  created()
  {
    var id_task_edit = this.$route.params.id;
    if(id_task_edit)
    {
      axios.get('http://127.0.0.1:8000/api/tasks/' + id_task_edit,
      {
        headers:
        {
          Authorization: "Bearer" + this.user.access_token
        }
      })
      .then(response => {
        var date = new Date(response.data.due_date);
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hour = date.getHours();
        var minute = date.getMinutes();
        var dueDate = year +
                      '-' +
                      (month < 10 ? '0' + month.toString() : month) +
                      '-' +
                      (day < 10 ? '0' + day.toString() : day) +
                      'T' +
                      (hour < 10 ? '0' + hour.toString() : hour) +
                      ':' +
                      (minute < 10 ? '0' + minute.toString() : minute);

        this.form.name           = response.data.name;
        this.form.due_date       = dueDate;
        this.form.id_user        = response.data.id_user;
        this.form.id_task_status = response.data.id_task_status;
        this.form.id_task        = response.data.id_task;
      });
    }
    axios.get('http://127.0.0.1:8000/api/task_statuses',
    {
      headers:
      {
        Authorization: "Bearer" + this.user.access_token
      }
    })
    .then(response =>
    {
      response.data.forEach(taskStatus => {
        this.id_task_status.push(new Object({
            value: taskStatus.id_task_status ,
            text: taskStatus.name
        }));
      });
    })
    axios.get('http://127.0.0.1:8000/api/users',
    {
      headers:
      {
        Authorization: "Bearer" + this.user.access_token
      }
    })
    .then(response =>
    {
      response.data.forEach(user => {
        this.id_user.push(new Object({
            value: user.id ,
            text: user.name
        }));
      });
    })
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
    backToIndex() {
       this.$router.push('/tasks');
    },
    onSubmit(event) {
      event.preventDefault();

      if(this.form.id_task != null && this.form.id_task > 0)
      {
        axios.put('http://127.0.0.1:8000/api/tasks/' + this.form.id_task,
        {
          name: this.form.name,
          due_date: this.form.due_date,
          id_task_status: this.form.id_task_status,
          id_user: this.form.id_user,
          id_task: this.form.id_task
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
          this.ShowSuccessDanger()
        })
      }
      else
      {
        axios.post('http://127.0.0.1:8000/api/tasks',
        {
          name: this.form.name,
          due_date: this.form.due_date,
          id_task_status: this.form.id_task_status,
          id_user: this.form.id_user
        },
        {
          headers:
          {
            Authorization: "Bearer" + this.user.access_token
          }
        })
        .then(response =>
        {
          this.ShowSuccessAlert()
        })
        .catch(e =>
        {
          this.ShowSuccessDanger()
        })
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>