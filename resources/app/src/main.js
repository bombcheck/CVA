import Vue from 'vue'
import App from './App'
import router from './router'
import {store} from '@/store'
import '@/assets/scss/main.scss'

import libraries from './libraries'
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );

Vue.use(libraries)
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
