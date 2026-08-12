import type {RouteRecordRaw} from 'vue-router'

const permissionsRoutes:RouteRecordRaw[]=[

  {
    path:'/security/permissions',
    name:'permissions.index',
    component:()=>import('@/views/security/permissions/PermissionsIndex.vue')
  }

]

export default permissionsRoutes