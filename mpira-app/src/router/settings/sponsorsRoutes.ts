import type {RouteRecordRaw} from 'vue-router'

const sponsorsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/sponsors',
    name:'sponsors.index',
    component:()=>import('@/views/settings/sponsors/SponsorsIndex.vue')
  },

  {
    path:'/settings/sponsors/create',
    name:'sponsors.create',
    component:()=>import('@/views/settings/sponsors/SponsorsCreate.vue')
  },

  {
    path:'/settings/sponsors/:id/edit',
    name:'sponsors.edit',
    component:()=>import('@/views/settings/sponsors/SponsorsEdit.vue')
  }

]

export default sponsorsRoutes