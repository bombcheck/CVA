import Vue from 'vue'
import Vuex from 'vuex'

import persistedState from 'vuex-persistedstate'
import authStore from './auth'


Vue.use(Vuex)

export const store = new Vuex.Store({
  modules: {
    authStore: authStore,
  },
  plugins: [persistedState()]
})
