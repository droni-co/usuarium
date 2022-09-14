<template>
  <div id="app" class="container">
    <b-skeleton animation="wave" width="100" v-if="loading"></b-skeleton>
    <InstallComponent v-if="!loading" :status="checkDatabase" />
    <div class="row" v-if="checkDatabase?.status == 'ok'">
      <div class="col-md-8">
        <UsersComponent />
      </div>
      <div class="col-md-4">
        Api clients
      </div>
    </div>
  </div>
</template>

<script>
import InstallComponent from './components/InstallComponent.vue'
import UsersComponent from './components/UsersComponent.vue'
import axios from 'axios'
export default {
  components: {
    InstallComponent,
    UsersComponent
  },
  data() {
    return {
      loading: true,
      checkDatabase: null
    }
  },
  mounted: function() {
    this.check()
  },
  methods: {
    check: function() {
      axios.get(process.env.VUE_APP_API_URL + '/api/install/check').then(res=>{
        this.checkDatabase = res.data
        console.log("🚀 ~ file: App.vue ~ line 28 ~ axios.get ~ checkDatabase", this.checkDatabase)
        this.loading = false
        
      })
    }
  },
}
</script>