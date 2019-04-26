<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">Asset request</h2>
    </div>
    <div class="horizontal__line"></div>
    <div class="table_4td">
      <div class="table__row" v-for="request in requests">
        <div class='table__th--data'>
          <div class="table__th">User: </div>
          <div class='table__td table_td--click'>{{request.user.username}}</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th">Campaign:</div>
          <div class='table__td table_td--click'>{{request.campaign.title}}</div>
        </div>
        <div class='table__th--data'>
          <div class='table__td table_td--click'>{{request.entity}}</div>
        </div>
        <div class="table__button">
          <button :class="{'btn': true, 'btn__': true, 'btn__asset': true, 'btn-danger': true}">
            <i class="fa fa-times" @click="destroy(request.id)"> </i>
          </button>
          <button :class="{'btn': true, 'btn__': true, 'btn__asset': true, 'btn-success': true}">
            <i class="fa fa-check" @click="approveRequest(request.id)"> </i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'
import alert from '@/services/sweetAlert.js'

export default {
  data() {
    return {
      requests: {},
      errors: {},
      showModal: false,
      showLoading: false,
      user: {},
      modal: '',
    }
  },
  computed: {},
  watch: {
    showModal: function () {
    }
  },
  mounted: function () {
    // this.getUser()
    this.getAll()
  },
  methods: {
    getAll: function () {
      Http.get(`/requests`)
        .then(response => {
          this.requests = response.data
        })
    },
    getDetails: function (idRequest) {
      this.errors = {}
      Http.get(`/requests/` + idRequest)
        .then(response => {
          this.details = response.data
        })
        .catch(e => {
          this.errors = e.body
        })
    },
    approveRequest: function (idAsset) {
      let vm = this
      alert.deletePopUp(function () {
        Http.get(`/requests/approve/` + idAsset)
          .then(response => {
            vm.getAll()
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      }, '')
    },
    destroy: function (idAsset) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/requests/` + idAsset)
          .then(response => {
            vm.getAll()
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      }, '')
    },
    getUser: function () {
      Http.get(`auth/details`)
        .then(response => {
          this.user = response.data
          if (response.data.role_id != 1) {
            this.$router.push('brands')
          }
        })
    }
  },
}
</script>
