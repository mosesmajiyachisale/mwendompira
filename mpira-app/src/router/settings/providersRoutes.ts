import type {RouteRecordRaw} from 'vue-router'

const providersRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/providers',
    name:'providers.index',
    component:()=>import('@/views/settings/providers/ProvidersIndex.vue')
  },
  {
    path:'/settings/providers/create',
    name:'providers.create',
    component:()=>import('@/views/settings/providers/ProvidersCreate.vue')
  },
  {
    path:'/settings/providers/:id/edit',
    name:'providers.edit',
    component:()=>import('@/views/settings/providers/ProvidersEdit.vue')
  },

]

export default providersRoutes