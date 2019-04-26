<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side" v-if="$route.name == 'campaigns'">All Campaigns</h2>
      <h2 class="title_side" v-if="$route.name == 'clients-campaigns'">Campaigns of client: {{client.name}}</h2>
      <h2 class="title_side" v-if="$route.name == 'brands-campaigns'">Campaigns of brands: {{brand.name}}</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()" v-if="user.role_id == 1 || user.role_id == 2">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table__main">
      <div class="table__row" v-for="campaign in campaigns">
        <div class='table__th--data'>
          <div class='table__th'>Title:</div>
          <div class='table__td table_td--click'>{{campaign.title}}</div>
        </div>
        <div class="table__tags">
          <span class="tag">{{campaign.client.name}}</span>
          <span class="tag">{{campaign.brand.name}}</span>
        </div>
        <div class="table__button">
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.sms_verified == 0),'btn-success': (campaign.sms_verified == 1)}" @click="openModal(campaign.id, 'sms'), modalAsset('sms', campaign.sms_verified)">SMS</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.call_verified == 0),'btn-success': (campaign.call_verified == 1)}" @click="openModal(campaign.id, 'call'), modalAsset('call', campaign.call_verified)">Call</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.email_verified == 0),'btn-success': (campaign.email_verified == 1)}" @click="openModal(campaign.id, 'email'), modalAsset('email', campaign.email_verified)">Email</button>
        </div>
        <div class="table__td--action" v-if="user.role_id != 4">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="returnBack(campaign.id, 'CAMPAIGN')"  v-if="user.role_id == 1 || user.role_id == 2">
                <div class="dropdown__item--icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Return back all</span>
              </li>
              <li class="dropdown__item" data-toggle="modal" v-on:click="applyChange(campaign.id, 'CAMPAIGN')"  v-if=" user.role_id == 3">
                <div class="dropdown__item--icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Apply for change</span>
              </li>
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(campaign.id), modalEdit(), changeAssetControl(true, false, false)" v-if="(user.role_id == 1 || user.role_id == 2)">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy(campaign.id)" v-if="(!(campaign.sms_verified == 1 && campaign.call_verified == 1 && campaign.email_verified == 1))">
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
          <div class="modal-container modal-container_lg">
            <div class="modal-header-stepper">
              <div :class="{'step': true, 'step_active': (step == 0)}" @click="step = 0" >
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Details</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step == 1)}" @click="step = 1">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">SMS</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step == 2)}" @click="step = 2">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Call</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step == 3)}" @click="step = 3">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Email</span>
              </div>
              <i class="fa fa-times close_modal" @click="showModal = false"></i>
            </div>
            <div class="modal-body-customize modal-body-stepper">
              <campaign-details-data v-if="step == 0" :details="details" :errors="errors"></campaign-details-data>
              <campaign-details-sms v-if="step == 1" :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-sms>
              <campaign-details-call v-if="step == 2" :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-call>
              <campaign-details-email v-if="step == 3" :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-email>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id != 4">
              <button class="btn btn-primary" @click="step++" v-if="step != 3">Next</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save(details, null)" v-if="step == 3">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-sms" v-if="showModalSMS">
      <div class="modal-mask ">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span :class="{'modal-title': true, 'text-success': (details.sms_verified == 1), 'text-danger': (details.sms_verified == 0)}">SMS</span>
              <div class="modal-close" @click="showModalSMS = false, changeAssetControl(false, false, false)"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-sms :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-sms>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id != 4">
              <button class="btn btn-success" @click="approve(details,'sms')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': !cCAsset.btn_c}" v-if="cCAsset.btn_c" @click="applyChange(details.id, 'SMS')">Apply for change</button>
              <button class="btn btn-primary" @click="save(details, 'sms')" v-if="details.sms_verified == 0 && cCAsset.btn_a == false">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-call" v-if="showModalCall">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container modal-container_lg">
            <div class="modal-header-customize ">
              <span :class="{'modal-title': true, 'text-success': (details.call_verified == 1), 'text-danger': (details.call_verified == 0)}">Call</span>
              <div class="modal-close" @click="showModalCall = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-call :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-call>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id != 4">
              <button class="btn btn-success" @click="approve(details,'call')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': !cCAsset.btn_c}" v-if="cCAsset.btn_c" @click="applyChange(details.id, 'CALL')">Apply for change</button>
              <button class="btn btn-primary" @click="save(details, 'call')" v-if="details.call_verified == 0 && cCAsset.btn_a == false">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-email" v-if="showModalEmail">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container modal-container_lg">
            <div class="modal-header-customize">
              <span :class="{'modal-title': true, 'text-success': (details.email_verified == 1), 'text-danger': (details.email_verified == 0)}">Email</span>
              <div class="modal-close" @click="showModalEmail = false, changeAssetControl(true, false, false)"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-email :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-email>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id != 4">
              <button class="btn btn-success" @click="approve(details,'email')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': !cCAsset.btn_c}" v-if="cCAsset.btn_c" @click="applyChange(details.id, 'EMAIL')">Apply for change</button>
              <button class="btn btn-primary" @click="save(details, 'email')" v-if="details.email_verified == 0 && cCAsset.btn_a == false">
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

  import CampaignDetailsEmail from '@/main/campaigns/details/email'
  import CampaignDetailsSms from '@/main/campaigns/details/sms'
  import CampaignDetailsCall from '@/main/campaigns/details/call'
  import CampaignDetailsData from '@/main/campaigns/details/detailsData'

  export default{
    components: {
      Treeselect,
      CampaignDetailsEmail,
      CampaignDetailsSms,
      CampaignDetailsCall,
      CampaignDetailsData
    },
    data () {
      return {
        campaigns: {},
        details: {},
        search: {},
        errors: {},
        client: {},
        brand: {},
        user: {},
        showModal: false,
        showModalSMS: false,
        showModalCall: false,
        showModalEmail: false,
        approveMode: true,
        showLoading: false,
        disabled: false,
        detailRequest: {},
        cCAsset: {
          btn_s: true,
          btn_c:  false,
          btn_a: false,
        },
        modal: '',
        step: 0,
        normalizerName (node) {
          return {
            id: node.id,
            label: node.name
          }
        }
      }
    },
    computed: {
    },
    watch: {
      '$route': function () {
        if (this.$route.path == '/campaigns') {
          this.getAll()
        }
      },
    },
    mounted: function () {
      this.getUser()
      this.getAll()
    },
    methods: {
      getAll: function () {
        if(this.$route.name == 'clients-campaigns' ) {
          this.getClientDetails(this.$route.params.clientId)
          Http.get(`/campaigns/clients/`+ this.$route.params.clientId + '?include=client,brand')
            .then(response => {
              this.campaigns = response.data
            })
        } else if(this.$route.name == 'brands-campaigns' ) {
          this.getBrandDetails(this.$route.params.brandId)
          Http.get(`/campaigns/brands/`+ this.$route.params.brandId + '?include=client,brand')
            .then(response => {
              this.campaigns = response.data
            })
        } else {
          Http.get(`/campaigns?include=client,brand`)
            .then(response => {
              this.campaigns = response.data
            })
        }
      },
      getDetails: function (idCampaign) {
        this.errors = {}
        Http.get(`/campaigns/` + idCampaign)
          .then(response => {
            this.details = response.data
          })
          .catch(e => {
            this.errors = e.body
          })
      },
      save: function (data ,asset) {
        let vm = this
        vm.errors = {}
        vm.showLoading = true
        if (data.id != undefined) {
          Http.put('/campaigns/' + data.id, vm.details)
            .then(response => {
              vm.getAll()
              vm.errors = {}
              vm.showLoading = false
              vm.showModal = false

              if (asset == 'sms') {
                if(response.data.sms_verified == 0) {
                  vm.changeAssetControl(false, false, true)
                }
              } else if (asset == 'call') {
                if(vm.details.call_verified == 0) {
                  vm.changeAssetControl(false, false, true)
                }
              } else if (asset == 'email') {
                if(vm.details.email_verified == 0) {
                  vm.changeAssetControl(false, false, true)
                }
              }
              alert.success()
            })
            .catch(e => {
              vm.showLoading = false
              vm.errors = e.response.data.errors
              vm.changeAssetControl(true, false, false)
              vm.step = 0
              if(vm.errors == {}) {
                alert.failed()
              }
            })
        } else {
          Http.post(`/campaigns`, this.details)
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
              vm.step = 0
              if(vm.errors == {}) {
                alert.failed()
              }
            })
        }
      },
      destroy: function (idCampaing) {
        let vm = this
        alert.deletePopUp(function () {
          Http.delete(`/campaigns/` + idCampaing)
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
        this.showModal = true
        this.details = {}
        this.details.sms_verified= 0
        this.details.call_verified = 0
        this.details.sms_script= ''
        this.details.call_script = ''
        this.details.email_verified = 0

        this.step = 0
      },
      modalEdit: function() {
        this.modal = 'Edit'
        this.showModal = true
        this.step = 0
      },
      returnBack: function(idCampaign, entity) {
        this.detailRequest.campaign_id = idCampaign
        this.detailRequest.entity = entity

        Http.post(`/requests/`, this.detailRequest)
          .then(response => {
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      },
      approve: function (data,asset) {
        let vm = this
        vm.errors = {}

        if(asset == 'sms') this.details.sms_verified = true
        if(asset == 'call') this.details.call_verified = true
        if(asset == 'email') this.details.email_verified = true
        console.log(123)
        alert.deletePopUp(function () {
          vm.showLoading = true
          Http.put('/campaigns/' + data.id, vm.details)
            .then(response => {
              vm.getAll()
              console.log(123321)
              vm.showLoading = false
              vm.changeAssetControl(false, true, false)
              alert.success()
            })
            .catch(e => {
              console.log(123123321)

              vm.showLoading = false
              vm.errors = e.response.data.errors
              if(asset == 'sms') this.details.sms_verified = false
              if(asset == 'call') this.details.call_verified = false
              if(asset == 'email') this.details.email_verified = false
              if(vm.errors == {}) {
                alert.failed()
              }
            })
        }, '')
      },
      sendEmail: function() {
      },
      changeAssetControl: function (s,c,a) {
        var vm = this
        vm.cCAsset.btn_s = s
        vm.cCAsset.btn_c = c
        vm.cCAsset.btn_a = a
        vm.disabled = c


      },
      modalAsset :function (asset, verified) {
        var vm = this
        if(asset == 'sms' || asset == 'call' || asset == 'email') {
          if(verified == 1) {
            this.changeAssetControl(false, true, false)
          } else {
            vm.changeAssetControl(true, false, false)
          }
        }
      },
      openModal: function (campaignID, asset) {
        this.getDetails(campaignID)
        if(asset == 'sms') {
          this.showModalSMS = true
        } else if (asset == 'call') {
          this.showModalCall = true
        } else if (asset == 'email'){
          this.showModalEmail = true
        }
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
      getBrandDetails: function (brandID) {
        this.errors = {}
        Http.get(`/brands/` + brandID)
          .then(response => {
            this.brand = response.data
          })
          .catch(e => {
          })
      },
      getUser: function () {
        Http.get(`auth/details`)
          .then(response => {
            this.user = response.data
            if (response.data.role_id == 4) {
              this.changeAssetControl(false,false,false)
            }
          })
      },
      applyChange: function (idCampaign, entity) {
        let vm = this
        vm.detailRequest.campaign_id = idCampaign
        vm.detailRequest.entity = entity

        alert.deletePopUp(function () {
          Http.post(`/requests`, vm.detailRequest)
            .then(response => {
              alert.success()
            })
            .catch(e => {
              alert.failed_(e.response.data.errors.message)
            })
        }, '')
      }
    }
  }
</script>
