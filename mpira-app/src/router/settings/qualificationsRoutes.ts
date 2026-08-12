import type {RouteRecordRaw} from 'vue-router'

const qualificationsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/qualifications',
    name:'qualifications.index',
    component:()=>import('@/views/settings/qualifications/QualificationsIndex.vue')
  },

]

export default qualificationsRoutes