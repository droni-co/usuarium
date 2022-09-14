<template>
  <div>
    <h3>Api Clients</h3>
    <b-input-group>
      <b-form-input v-model="newApiClient" placeholder="Name for api client"></b-form-input>
      <b-input-group-append>
        <b-button variant="primary" @click="createApiClient()">Create</b-button>
      </b-input-group-append>
    </b-input-group>
    
    <table class="table table-striped">
      <tbody>
        <tr v-for="apiClient in apiClients" :key="apiClient.id">
          <th scope="row">
            Client id: <code>{{ apiClient.id }}</code> <br>
            Name: {{ apiClient.name }}<br>
            Secret: <code>{{ apiClient.secret }}</code>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
  
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'ApiClientComponent',
    data() {
      return {
        apiClients: {
          data: []
        },
        newApiClient: ''
      }
    },
    mounted: function() {
      this.getApiClients()
    },
    methods: {
      getApiClients() {
        axios.get(process.env.VUE_APP_API_URL + '/api/api_clients').then(res=>{
          this.apiClients = res.data
        })
      },
      createApiClient() {
        axios.post(process.env.VUE_APP_API_URL + '/api/api_clients', {name: this.newApiClient}).then(res=>{
          console.log(res)
          this.getApiClients()
        })
      }
    }

  }
</script>