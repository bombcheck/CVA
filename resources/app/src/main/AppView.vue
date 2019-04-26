<template>
  <div class="app__container">
    <left-menu></left-menu>
    <router-view :class="{'container':true, 'col-md-10':true}"></router-view>
  </div>
</template>

<script>

import LeftMenu from '@/navigation/LeftMenu'

export default {
  name: 'app',
  computed: {
    route () {
      return this.$route.path
    }
  },
  components: {
    LeftMenu
  },
  watch: {
    mounted: function () {
      if (localStorage.getItem('vuex') == '') {
        this.$router.push('login')
      }
      if (localStorage.getItem('vuex') == null) {
        localStorage.setItem('vuex', '')
        this.$router.push('login')
      }
    },
    watch: {
      route: function () {
        if (this.$route.path == '/') {
          this.$router.push('clients')
        }
      }
    }
  }
}
</script>
