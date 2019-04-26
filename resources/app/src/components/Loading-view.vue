<template>
  <div class="app__container">
    <div class="img_loading_middle">
      <img src="@/assets/img/loading-animated.gif" alt="Loading.."/>
    </div>
  </div>
</template>
<script>
import {Http} from '@/helpers/http-helper'

export default {


  name: 'app',
  data () {
    return {
      user: {}
    }
  },
  computed: {
    route () {
      return this.$route.path
    }
  },
  components: {
  },
  mounted: function () {
    this.getUser()
  },
  watch: {
    route: function () {
      console.log('123')
    }
  },
  methods: {
    getUser: function () {
      Http.get(`auth/details`)
        .then(response => {
          this.user = response.data

          if( response.data.role_id != 1 || response.data.role_id != 2) {
            this.$router.push({name: 'brands'})
          } else {
            this.$router.push({name: 'clients'})
          }
        })
        .catch(e => {
          if (e.response.status != 200) {
            localStorage.setItem('vuex', '')
            this.$router.push('login')
          }
        })
    }
  }
}
</script>
