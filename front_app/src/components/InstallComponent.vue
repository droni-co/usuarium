<template>
    
    <b-alert class="mt-3" show :variant="checkDatabase?.status == 'error' ? 'danger' : 'success'">
      <strong>{{ checkDatabase?.status}}</strong>
      <p>{{ checkDatabase?.message}}</p>
      <b-button v-if="checkDatabase?.status == 'error'" variant="outline-primary" @click="migrate()">
        Run migrations
      </b-button>
      <b-button v-if="checkDatabase?.status == 'ok'" variant="outline-primary" @click="fetcher()">
        Fetch data from Api
      </b-button>
    </b-alert>
  
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'InstallComponent',
    props: {
      status: {
        type: Object,
        default: null
      }
    },
    data() {
      return {
        checkDatabase: null
      }
    },
    mounted: function() {
      this.checkDatabase = this.status
    },
    methods: {
      migrate() {
        axios.get(process.env.VUE_APP_API_URL + '/api/install/migrate').then(res=>{
          this.checkDatabase = res.data          
        })
      },
      fetcher() {
        axios.get(process.env.VUE_APP_API_URL + '/api/install/fetcher').then(res=>{
          this.checkDatabase = res.data          
        })
      }
    }

  }
</script>