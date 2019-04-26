<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">All Users</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table_3td">
      <div class="table__row" v-for="user in users">
        <div class='table__th--data'>
          <div class="table__th">Username: </div>
          <div class='table__td table_td--click'>{{user.username}}</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th"></div>
          <div class='table__td table_td--click'>{{user.role.name}}</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th"></div>
          <div class='table__td table_td--click'><i :class="{'fa': true, 'fa-circle': true, 'text-success': (user.active == true), 'text-danger': (user.active == false)}"></i></div>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(user.id), modalEdit(user.id), fetchRole()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy(user.id)">
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
                  <div class="cnf__input col-md-6">
                    <label>First name</label>
                    <input type="text" class="form-control" placeholder=" Enter first name" v-model="details.first_name">
                    <span class="error__span" v-if="errors.first_name">{{ errors.first_name[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Last name</label>
                    <input type="text" class="form-control" placeholder=" Enter last name" v-model="details.last_name">
                    <span class="error__span" v-if="errors.last_name">{{ errors.last_name[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder=" Enter username" v-model="details.username">
                    <span class="error__span" v-if="errors.username">{{ errors.username[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder=" Enter email" v-model="details.email">
                    <span class="error__span" v-if="errors.email">{{ errors.email[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder=" Enter password" v-model="details.password">
                    <span class="error__span" v-if="errors.password">{{ errors.password[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" placeholder=" Retype password" v-model="details.retype_password">
                    <span class="error__span" v-if="errors.retype_password">{{ errors.retype_password[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12">
                    <label>Role</label>
                    <treeselect :options="roles" placeholder=" Choose role" :normalizer='normalizer' v-model="details.role_id">
                      <label slot="option-label" slot-scope="{ node }">
                      {{ node.raw.name }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.role">{{ errors.role[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12" v-if="customizeUser.clients">
                    <label>Client</label>
                    <treeselect :options="clients" placeholder=" Choose client" :normalizer="normalizer" v-model="details.client_id">
                      <label slot="option-label" slot-scope="{ node }">
                        {{ node.raw.name }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.client_id">{{ errors.client_id[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12" v-if="customizeUser.brands && modal == 'Add new'">
                    <label>Brands</label>
                    <treeselect :options="brands" :multiple="true" placeholder=" Choose brands" :normalizer="normalizer" v-model="details.brands">
                      <label slot="option-label" slot-scope="{ node }">
                        {{ node.raw.name }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.brands">{{ errors.brands[0] }}</span>
                  </div>

                  <div class="user__vehicles-holder" v-if="customizeUser.brands && modal == 'Edit'">
                    <div class="table__holder auto--overflow-y roles--table col-md-6">
                      <div class="table__header">
                        <label class="col-md-10">No Access brands</label>
                        <label class="col-md-2">+</label>
                      </div>
                      <div class="table__cell has--grid" v-for="(brandNA, index) in brandsNotAllow" :key="index">
                        <div class="col-md-10 grid__input">
                          <label class="font-100 text-left">{{ brandNA.name }}</label>
                        </div>
                        <div class="col-md-2 grid__input click">
                          <label class="font-100 click"><a v-on:click="addOrRemoveBrands(brandNA.id, details.id, 'add')"><i class="fa fa-plus" aria-hidden="true"></i></a></label>
                        </div>
                      </div>
                    </div>
                    <div class="table__holder auto--overflow-y roles--table col-md-6">
                      <div class="table__header">
                        <label class="col-md-10">Access brands</label>
                        <label class="col-md-2">-</label>
                      </div>
                      <div class="table__cell has--grid" v-for="(brandA, index) in brandsAllow" :key="index">
                        <div class="col-md-10 grid__input">
                          <label class="font-100 text-left">{{ brandA.name }}</label>
                        </div>
                        <div class="col-md-2 grid__input click">
                          <label class="font-100 click"><a v-on:click="addOrRemoveBrands(brandA.id, details.id, 'remove')"><i class="fa fa-minus" aria-hidden="true"></i></a></label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="cnf__input ">
                    <input type="checkbox" v-model="details.active">
                    <label>Active</label>
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

import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import alert from '@/services/sweetAlert.js'
import swal from 'sweetalert2/dist/sweetalert2.js'

export default{
  components: {
    Treeselect
  },
  data () {
    return {
      users: {},
      clients: [],
      brands: [],
      brandsAllow: [],
      brandsNotAllow: [],
      roles: [
        {id: 1, name:'Super Admin'},
        {id: 2, name:'Client Admin'},
        {id: 3,name:'Client User'},
        {id: 4, name:'Client Viewer'}
      ],
      details: {
        active: true
      },
      errors: {},
      showModal: false,
      showLoading: false,
      modal: '',
      customizeUser: {
        clients: false,
        brands: false
      },
      normalizer (node) {
        return {
          id: node.id,
          label: node.name
        }
      },
    }
  },
  computed: {
    roleId () {
      return this.details.role_id
    },
    clientId () {
      return this.details.client_id
    }
  },
  watch: {
    clientId: function () {
      this.details.brands = []
      if(this.modal != 'Edit') {
        this.fetchBrands(this.clientId)
      }
    },
    roleId: function () {
      this.fetchClients()
      if (this.roleId == 2) {
        if (this.details.role_id) {
          this.roles = [{id: 2,name:'Client Admin'}, {id: 3,name:'Client User'}, {id: 4, name:'Client Viewer'}]
        }
        this.customizeUser.clients = true
        this.customizeUser.brands = false
      } else if (this.roleId == 3 || this.roleId == 4) {
        this.customizeUser.clients = true
        this.customizeUser.brands = true
      } else {
        this.customizeUser.clients = false
        this.customizeUser.brands = false
      }
    }
  },
  mounted: function () {
    this.getAll()
    this.getUser()
  },
  methods: {
    getAll: function () {
      Http.get(`/users?include=role`)
        .then(response => {
          this.users = response.data
        })
    },
    getDetails: function (idUser) {
      this.errors = {}
      Http.get(`/users/` + idUser +'?include=brands')
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
        Http.put('/users/' + data.id, vm.details)
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
        Http.post(`/users`, this.details)
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
    destroy: function (idUser) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/users/` + idUser)
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
      this.details.active = true
      if (this.user.role_id == 2) {
        this.roles = [{id: 3,name:'Client User'}, {id: 4, name:'Client Viewer'}]
      }
      this.showModal = true
    },
    modalEdit: function(user_id) {
      this.modal = 'Edit'
      this.showModal = true
      if (this.user.role_id == 2) {
        this.roles = [{id: 3,name:'Client User'}, {id: 4, name:'Client Viewer'}]
      }
      this.ftechBrandss(user_id)
    },
    fetchRole: function () {

    },
    fetchClients: function () {
      if (this.user.role_id != 1) {
        Http.get(`/auth/clients`)
          .then(response => {
            this.clients = response.data
            this.fetchBrands_()
          })
      } else {
        Http.get(`/clients`)
          .then(response => {
            this.clients = response.data
          })
      }
    },
    fetchBrands: function (clientId) {
      Http.get(`/brands/clients/`+ clientId + '?include=client')
        .then(response => {
          this.brands = response.data
        })
    },
    ftechBrandss: function (user_id) {
      Http.get(`/users/brands/not/` + user_id)
        .then(response => {
          this.brandsNotAllow = response.data
        })

      Http.get(`/users/brands/` + user_id)
        .then(response => {
          this.brandsAllow = response.data
        })
    },
    addOrRemoveBrands: function (brand_id, user_id, mode) {
      if (mode == 'add') {
        Http.post(`/users/brands/`+ user_id +`/`+ brand_id+`/add`)
          .then(response => {
            this.ftechBrandss(user_id)
          })
          .catch(e => {
          })
      }

      if (mode == 'remove') {
        Http.post(`/users/brands/`+ user_id +`/`+ brand_id+`/remove`)
          .then(response => {
            this.ftechBrandss(user_id)
          })
          .catch(e => {
          })
      }
    },
    getUser: function () {
      Http.get(`auth/details`)
        .then(response => {
          this.user = response.data
        })
    }
  }
}
</script>
