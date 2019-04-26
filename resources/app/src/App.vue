<template>
  <div id="app" class="app__container">
    <router-view :class="{'col-md-12':true, 'noPadding': true }"/>
  </div>
</template>

<script>

export default {
  name: 'app',
  computed: {
    route () {
      return this.$route.path
    }
  },
  components: {
  },
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
        this.$router.push('/')
      }
    }
  }
}
</script>

