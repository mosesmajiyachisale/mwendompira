import type {RouteRecordRaw} from 'vue-router'

const stagesRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/stages',
    name:'stages.index',
    component:()=>import('@/views/settings/stages/StagesIndex.vue')
  },

]

export default stagesRoutes