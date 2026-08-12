import type {RouteRecordRaw} from 'vue-router'

const coachesRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/coaches',
    name:'coaches.index',
    component:()=>import('@/views/settings/coaches/CoachesIndex.vue')
  }

]

export default coachesRoutes