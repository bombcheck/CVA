<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">All Clients</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table__main table_with-out--tags">
      <div class="table__row" v-for="client in clients">
        <div class='table__th--data'>
          <div class="table__th">Name: </div>
          <div class='table__td table_td--click'>{{client.name}}</div>
        </div>
        <div class="table__button">
          <button class="btn btn__row" @click="$router.push({ name: 'clients-brands', params: { clientId: client.id }})">Brands</button>
          <button class="btn btn__row" @click="$router.push({ name: 'clients-campaigns', params: { clientId: client.id }})">Campaigns</button>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(client.id), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy(client.id)">
                <div class="dropdown__item--icon"><i class="fa fa-trash" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Delete</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <transition name="modal" v-if="showModal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span class="modal-title">{{modal}}</span>
              <div class="modal-close" @click="showModal = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <div class="form-line">
                  <div class="cnf__input col-md-12">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder=" Enter name" v-model="details.name">
                    <span class="error__span" v-if="errors.name">{{ errors.name[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12">
                    <label>iWinBack API Key</label>
                    <input type="text" class="form-control" placeholder=" Enter iwinback api key" v-model="details.iwinback_api_key">
                    <span class="error__span" v-if="errors.iwinback_api_key">{{ errors.iwinback_api_key[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12">
                    <label>iWinBack API Secret</label>
                    <input type="text" class="form-control" placeholder=" Enter iwinback api secret" v-model="details.iwinback_api_secret">
                    <span class="error__span" v-if="errors.iwinback_api_secret">{{ errors.iwinback_api_secret[0] }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-light" @click="showModal = false">Close</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save(details)">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'

import alert from '@/services/sweetAlert.js'
import swal from 'sweetalert2/dist/sweetalert2.js'

export default{
  data () {
    return {
      clients: {},
      details: {},
      errors: {},
      showModal: false,
      showLoading: false,
      user: {},
      modal: '',
    }
  },
  computed: {
  },
  watch: {
    showModal: function() {
    }
  },
  mounted: function () {
    // this.getUser()
    this.getAll()
  },
  methods: {
    getAll: function () {
      Http.get(`/clients`)
        .then(response => {
          this.clients = response.data
        })
    },
    getDetails: function (idClient) {
      this.errors = {}
      Http.get(`/clients/` + idClient)
        .then(response => {
          this.details = response.data
        })
        .catch(e => {
          this.errors = e.body
        })
    },
    save: function (data) {
      let vm = this
      vm.errors = {}
      vm.showLoading = true
      if (data.id != undefined) {
        Http.put('/clients/' + data.id, vm.details)
          .then(response => {
            vm.getAll()
            vm.errors = {}
            vm.showLoading = false
            vm.showModal = false
            alert.success()
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
            console.log(vm.errors)
            if(vm.errors == {}) {
              alert.failed()
            }
          })
      } else {
        Http.post(`/clients`, this.details)
          .then(response => {
            vm.getAll()
            vm.showLoading = false
            vm.showModal = false
            vm.errors = {}
            vm.details = {}
            alert.success()
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
            if(vm.errors == {}) {
              alert.failed()
            }
            console.log(vm.errors)
          })
      }
    },
    destroy: function (idClient) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/clients/` + idClient)
          .then(response => {
            vm.getAll()
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      }, '')
    },
    modalAdd: function() {
      this.modal = 'Add new'
      this.details = {}
      this.showModal = true
    },
    modalEdit: function() {
      this.modal = 'Edit'
      this.showModal = true
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
  }
}
</script>
