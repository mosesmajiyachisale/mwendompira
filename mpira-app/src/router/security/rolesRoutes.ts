import type {RouteRecordRaw} from 'vue-router'

const rolesRoutes:RouteRecordRaw[]=[

  {
    path:'/security/roles',
    name:'roles.index',
    component:()=>import('@/views/security/roles/RolesIndex.vue')
  }

]

export default rolesRoutes