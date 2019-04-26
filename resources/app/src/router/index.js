import Vue from 'vue'
import Router from 'vue-router'


import LoadingView from '@/components/Loading-view'

import AppView from '@/main/AppView'

import LoginView from '@/main/login/LoginComponent'
import ClientComponent from '@/main/clients/ClientsComponent'
import BrandsComponent from '@/main/brands/BrandsComponent'
import CampaignsComponent from '@/main/campaigns/CampaignsComponent'
import AssetRequest from '@/main/assetRequest/AssetRequest'
import UsersComponent from '@/main/users/UsersComponent'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'loading',
      component: LoadingView
    },
    {
      path: '/app',
      name: 'app-view',
      component: AppView,
      children: [
        {
          path: '/clients',
          name: 'clients',
          component: ClientComponent
        },
        {
          path: '/clients/brands/:clientId',
          name: 'clients-brands',
          component: BrandsComponent
        },
        {
          path: '/clients/campaigns/:clientId',
          name: 'clients-campaigns',
          component: CampaignsComponent
        },
        {
          path: '/brands',
          name: 'brands',
          component: BrandsComponent
        },
        {
          path: '/brands/campaigns/:brandId',
          name: 'brands-campaigns',
          component: CampaignsComponent
        },
        {
          path: '/clients/brands/:clientId',
          name: 'clients-brands',
          component: BrandsComponent
        },
        {
          path: '/assetRequest',
          name: 'asset-request',
          component: AssetRequest
        },
        {
          path: '/users',
          name: 'users',
          component: UsersComponent
        },
        {
          path: '/campaigns',
          name: 'campaigns',
          component: CampaignsComponent
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '*',
      redirect: '/',

    },
  ]
})
