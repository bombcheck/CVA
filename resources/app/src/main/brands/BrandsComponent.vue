<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side" v-if="$route.name == 'brands'">All Brands</h2>
      <h2 class="title_side" v-if="$route.name == 'clients-brands'">Brands of client: {{client.name}}</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()" v-if="user.role_id == 1 || user.role_id == 2">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table_2td">
      <div class="table__row" v-for="brand in brands">
        <div class='table__th--data'>
          <div class="table__th">Name: </div>
          <div class='table__td table_td--click'>{{brand.name}}</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th">Client: </div>
          <div class='table__td table_td--click'>{{brand.client.name}}</div>
        </div>
        <div class="table__button">
          <button class="btn btn__row" @click="$router.push({ name: 'brands-campaigns', params: { brandId: brand.id }})">Campaigns</button>
        </div>
        <div class="table__td--action" v-if="user.role_id == 1 || user.role_id == 2">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" @click="getDetails(brand.id), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy()" @click="destroy(brand.id)">
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
                    <label>Client</label>
                    <treeselect :options="clients" placeholder=" Choose client" :normalizer="normalizerName" v-model="details.client_id">
                      <label slot="option-label" slot-scope="{ node }">
                        {{ node.raw.name }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.name">{{ errors.name[0] }}</span>
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
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default{
  components: {
    Treeselect
  },
  data () {
    return {
      brands: {},
      clients: [],
      client: {},
      details: {},
      errors: {},
      user: {},
      showModal: false,
      showLoading: false,
      modal: '',
      clientId: null,
      normalizerName (node) {
        return {
          id: node.id,
          label: node.name
        }
      }
    }
  },
  computed: {
    paramClientId: function () {
      return this.$route.params.clientId
    }
  },
  watch: {
    '$route': function () {
      if (this.$route.path == '/brands') {
        this.clientId = null
        this.getAll()
      }
    },
    paramClientId: function () {}
  },
  mounted: function () {
    this.getUser()
    if(this.$route.params.clientId == undefined) {
      this.clientId = null
    }
    else {
      this.clientId = this.$route.params.clientId
    }
    this.getAll()
  },
  methods: {
    getAll: function () {
      if(this.$route.name == 'clients-brands' ) {
        this.getClientDetails(this.$route.params.clientId)
        Http.get(`/brands/clients/`+ this.$route.params.clientId + '?include=client')
          .then(response => {
            this.brands = response.data
          })
      } else {
        Http.get(`/brands?include=client`)
          .then(response => {
            this.brands = response.data
          })
      }
    },
    getDetails: function (idBrand) {
      this.errors = {}
      Http.get(`/brands/` + idBrand)
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
        Http.put('/brands/' + data.id, vm.details)
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
            if(vm.errors == {}) {
              alert.failed()
            }
          })
      } else {
        Http.post(`/brands`, this.details)
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
          })
      }
    },
    destroy: function (idBrand) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/brands/` + idBrand)
          .then(response => {
            vm.getAll()
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      }, '')
    },
    fetchClients: function () {
      if(this.user.client_id == null) {
        Http.get(`/clients`)
          .then(response => {
            this.clients = response.data
          })
      } else if (this.user.role_id != 1) {
        Http.get(`/auth/clients`)
          .then(response => {
            this.clients = response.data
          })
      }
    },
    modalAdd: function() {
      this.modal = 'Add new'
      this.fetchClients()
      this.details = {}
      this.showModal = true
    },
    modalEdit: function() {
      this.modal = 'Edit'
      this.showModal = true
      this.fetchClients()
    },
    getClientDetails: function (clientID) {
      this.errors = {}
      Http.get(`/clients/` + clientID)
        .then(response => {
          this.client = response.data
        })
        .catch(e => {
        })
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
