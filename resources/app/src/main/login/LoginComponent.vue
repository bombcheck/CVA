<template>
  <div>
    <div class="login__form">
      <div class="cnf__input">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" v-model="user.email">
        <span class="error__span" v-if="errors.email">{{ errors.email[0] }}</span>
      </div>
      <div class="cnf__input">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="user.password" @keyup.enter="login(user)">
        <span class="error__span" v-if="errors.password">{{ errors.password[0] }}</span>
        <span class="error__span" v-if="errors.general">{{ errors.general[0] }}</span>
      </div>
      <div class="btn_login">
        <button type="submit" class="btn btn-primary login_btn" :disabled="showLoading" @click="login(user), user_(), showLoading=true">
          <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Login
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  data () {
    return {
      user: {
        email: '',
        password: ''
      },
      errors: {},
      showLoading: false
    }
  },
  mounted: function () {
    if (localStorage.getItem('vuex') != '' || localStorage.getItem('vuex') == undefined) {
      this.$router.push('/')
    }
    this.$store.watch(
      (state) => {
        return this.$store.getters['authStore/getErrors']
      },
      (val) => {
        this.errors = this.$store.getters['authStore/getErrors']
        this.showLoading = false
      })
  },
  methods: {
    ...mapActions('authStore', [
      'login','user_'
    ])
  }
}
</script>

