<template>
  <div>
    <h2>Users</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">User</th>
          <th scope="col">Timestamps</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users.data" :key="user.id">
          <th scope="row">{{ user.id }}</th>
          <td>
            {{ user.first_name + " " + user.last_name}}<br>
            {{ user.email }}
          </td>
          <td>
            <small>
              {{ user.created_at }}<br>
              {{ user.updated_at }}
            </small>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'InstallComponent',
    data() {
      return {
        users: []
      }
    },
    mounted: function() {
      this.getUsers()
    },
    methods: {
      getUsers() {
        axios.get(process.env.VUE_APP_API_URL + '/api/users').then(res=>{
          this.users = res.data
        })
      }
    }

  }
</script>