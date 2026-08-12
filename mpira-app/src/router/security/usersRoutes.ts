import type {RouteRecordRaw} from 'vue-router'

const usersRoutes:RouteRecordRaw[]=[

  {
    path:'/security/users',
    name:'users.index',
    component:()=>import('@/views/security/users/UsersIndex.vue')
  }

]

export default usersRoutes