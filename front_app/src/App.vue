<template>
  <div id="app" class="container">
    <b-skeleton animation="wave" width="100" v-if="loading"></b-skeleton>
    <InstallComponent v-if="!loading" :status="checkDatabase" />
    <div class="row" v-if="checkDatabase?.status == 'ok'">
      <div class="col-md-8">
        <b-tabs  v-model="tabIndex" content-class="mt-3">
          <b-tab title="List users">
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
                  <td>
                    <b-button variant="outline-primary" @click="showEditUser(user)">
                      Edit
                    </b-button>
                    <b-button variant="outline-primary" @click="showShowUser(user)">
                      Show
                    </b-button>
                  </td>
                </tr>
              </tbody>
            </table>
            <b-pagination
              v-model="users.page"
              @input="getUsers"
              :total-rows="users.total"
              :per-page="users.per_page"
            ></b-pagination>
          </b-tab>
          <b-tab title="Create">
            <h2>Create User</h2>
            <div class="mb-3">
              <b-form-input v-model="newUser.first_name" placeholder="first name"></b-form-input>
            </div>
            <div class="mb-3">
              <b-form-input v-model="newUser.last_name" placeholder="Last name"></b-form-input>
            </div>
            <div class="mb-3">
              <b-form-input type="email" v-model="newUser.email" placeholder="Email"></b-form-input>
            </div>
            <div class="mb-3">
              <b-form-input type="url" v-model="newUser.avatar" placeholder="Avatar Url"></b-form-input>
            </div>
            <div class="mb-3">
              <b-button variant="primary" @click="createUser()">Create User</b-button>
            </div>
          </b-tab>
          <b-tab title="Edit">
            <h2>Update User</h2>
            <div v-if="editUser">
              <div class="mb-3">
                <b-form-input v-model="editUser.first_name" placeholder="first name"></b-form-input>
              </div>
              <div class="mb-3">
                <b-form-input v-model="editUser.last_name" placeholder="Last name"></b-form-input>
              </div>
              <div class="mb-3">
                <b-form-input type="email" v-model="editUser.email" placeholder="Email"></b-form-input>
              </div>
              <div class="mb-3">
                <b-form-input type="url" v-model="editUser.avatar" placeholder="Avatar Url"></b-form-input>
              </div>
              <div class="mb-3">
                <b-button variant="primary" @click="updateUser()">Update User</b-button>
              </div>
            </div>
          </b-tab>
          <b-tab title="Show">
            <h2>Show user</h2>
            <div class="row">
              <div class="col">
                <b-form-input v-model="apiClient.client_id" placeholder="Cliet Id"></b-form-input>
              </div>
              <div class="col">
                <b-form-input v-model="apiClient.client_secret" placeholder="Cliet Secret"></b-form-input>
              </div>
              <div class="col">
                <b-form-input v-model="apiClient.user_id" placeholder="User Id"></b-form-input>
              </div>
              <div class="col">
                <b-button variant="primary" @click="getUser()">Get User Info</b-button>
              </div>
            </div>
            <div class="card" v-if="userInfo">
              <div class="card-body">
                <h5 class="card-title">{{ userInfo?.first_name + " " + userInfo?.last_name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ userInfo?.email }}</h6>
                <p class="card-text">{{ userInfo?.avatar }}</p>
              </div>
            </div>
          </b-tab>
        </b-tabs>
        
      </div>
      <div class="col-md-4">
        <ApiClientComponent />
      </div>
    </div>
  </div>
</template>

<script>
import InstallComponent from './components/InstallComponent.vue'
import ApiClientComponent from './components/ApiClientComponent.vue'
import axios from 'axios'
export default {
  components: {
    InstallComponent,
    ApiClientComponent
  },
  data() {
    return {
      loading: true,
      checkDatabase: null,
      newUser: {
        first_name: '',
        last_name: '',
        email: '',
        avatar: ''
      },
      editUser: null,
      users: {
        data: []
      },
      tabIndex: 0,
      apiClient: {
        client_id: '',
        client_secret: '',
        user_id: ''
      },
      userInfo: null
    }
  },
  mounted: function() {
    this.check()
  },
  methods: {
    check: function() {
      axios.get(process.env.VUE_APP_API_URL + '/api/install/check').then(res=>{
        this.checkDatabase = res.data
        this.loading = false
        if(this.checkDatabase.status == 'ok') {
          this.getUsers()
        }
      })
    },
    getUsers() {
      let page = this.users.page ?? 1
      axios.get(process.env.VUE_APP_API_URL + '/api/users?page='+page).then(res=>{
        this.users = res.data
      })
    },
    createUser() {
      axios.post(process.env.VUE_APP_API_URL + '/api/users', this.newUser).then(res=>{
        console.log(res)
        this.$toast.open('User created!');
        this.newUser = {
          first_name: '',
          last_name: '',
          email: '',
          avatar: ''
        }
        this.getUsers()
      })
    },
    showEditUser(user) {
      this.editUser = user
      this.tabIndex = 2
    },
    updateUser() {
      axios.put(process.env.VUE_APP_API_URL + '/api/users/'+this.editUser.id, this.editUser).then(res=>{
        console.log(res)
        this.$toast.open('User updated!');
        this.getUsers()
      })
    },
    showShowUser(user) {
      this.apiClient.user_id = user.id
      this.tabIndex = 3
    },
    getUser() {
      let headers = {
        'Accept': 'application/json',
        'client_id': this.apiClient.client_id,
        'client_secret': this.apiClient.client_secret
      }
      axios.get(process.env.VUE_APP_API_URL + '/api/users/'+this.apiClient.user_id, {headers}).then(res=>{
        this.userInfo = res.data
        this.$toast.open('User info!');
      }).catch(err=>{
        console.log(err)
        this.$toast.open({
          type: 'error',
          message: err?.response?.data?.message
        });
      })
    }
  },
}
</script>