<template>
  <div v-bind:class="{'menu':true, 'sidebar':true,}">
    <div class="logo">
      <div class="first__letters">
        <p>{{user.username | firstLetter}}</p>
      </div>
      <p class="user__name">{{user.username}}</p>
      <p class="user__client-name" v-if="user.client_id != null">{{userClient[0].name}}</p>
    </div>
    <div class="user__actions">
      <a @click="logout()"><i class="fa fa-power-off" aria-hidden="true"></i></a>
    </div>
    <div class='list'>
      <router-link to="/clients" v-if='user.role_id == "1"' v-bind:class='{"list__tile--link" : true, "list__tile--link-active" : (routes[1] == "clients")}'>
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-building-o"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Clients</span>
        </div>
      </router-link>
      <router-link to="/assetRequest" v-if="user.role_id == 1 || user.role_id == 2" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] == 'assetRequest')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-bell-o"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Asset request</span>
        </div>
      </router-link>
      <router-link to="/brands" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] == 'brands')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-square-o"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Brands</span>
        </div>
      </router-link>
      <router-link to="/campaigns" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] == 'campaigns')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-sticky-note"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Campaigns</span>
        </div>
      </router-link>
      <router-link to="/users" v-if="user.role_id == 1 || user.role_id == 2" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] == 'users')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-users"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Users</span>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'

  export default {
    props: [],
    data () {
      return {
        routes: [],
        user: {},
        userClient: {}
      }
    },
    filters: {
      capitalize: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      },
      firstLetter: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0)
      }
    },
    watch: {
      '$route': function () {
        this.watchRoute()
      }
    },
    mounted: function () {
      this.getUser()
      this.getUserClient()
      this.watchRoute()
    },
    methods: {
      watchRoute: function () {
        this.routes = String(this.$route.path).split('/')
        if (this.user.role_id == 2) {
          if (this.routes[2] == undefined) {
            this.routes[2] = 'brands'
          }
        }
        else {
          if (this.routes[2] == undefined) {
            this.routes[2] = 'clients'
          }
        }

      },
      logout: function () {
        localStorage.setItem('vuex', '')
        this.$router.push({name: 'login'})
        Http.get(`/auth/logout`)
      },
      getUserClient: function () {
        Http.get(`auth/clients`)
          .then(response => {
            this.userClient = response.data
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
