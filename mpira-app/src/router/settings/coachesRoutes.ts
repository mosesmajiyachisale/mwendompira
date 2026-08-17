import type {RouteRecordRaw} from 'vue-router'

const coachesRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/coaches',
    name:'coaches.index',
    component:()=>import('@/views/settings/coaches/CoachesIndex.vue')
  },
  {
    path:'/settings/coaches/create',
    name:'coaches.create',
    component:()=>import('@/views/settings/coaches/CoachesCreate.vue')
  },
  {
    path:'/settings/coaches/:id/edit',
    name:'coaches.edit',
    component:()=>import('@/views/settings/coaches/CoachesEdit.vue')
  },

]

export default coachesRoutes