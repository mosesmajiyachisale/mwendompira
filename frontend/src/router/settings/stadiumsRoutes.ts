import type {RouteRecordRaw} from 'vue-router'

const stadiumsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/stadiums',
    name:'stadiums.index',
    component:()=>import('@/views/settings/stadiums/StadiumsIndex.vue')
  },

  {
    path:'/settings/stadiums/create',
    name:'stadiums.create',
    component:()=>import('@/views/settings/stadiums/StadiumsCreate.vue')
  },

  {
    path:'/settings/stadiums/:id/edit',
    name:'stadiums.edit',
    component:()=>import('@/views/settings/stadiums/StadiumsEdit.vue')
  }

]

export default stadiumsRoutes