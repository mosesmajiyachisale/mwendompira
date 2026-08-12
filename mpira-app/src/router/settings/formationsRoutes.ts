import type {RouteRecordRaw} from 'vue-router'

const formationsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/formations',
    name:'formations.index',
    component:()=>import('@/views/settings/formations/FormationsIndex.vue')
  }

]

export default formationsRoutes