import type {RouteRecordRaw} from 'vue-router'

const phasesRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/phases',
    name:'phases.index',
    component:()=>import('@/views/settings/phases/PhasesIndex.vue')
  },

]

export default phasesRoutes