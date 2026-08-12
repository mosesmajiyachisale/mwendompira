import type {RouteRecordRaw} from 'vue-router'

const participationsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/participations',
    name:'participations.index',
    component:()=>import('@/views/settings/participations/ParticipationsIndex.vue')
  },

  {
    path:'/settings/participations/create',
    name:'participations.create',
    component:()=>import('@/views/settings/participations/ParticipationsCreate.vue')
  },

  {
    path:'/settings/participations/:id/edit',
    name:'participations.edit',
    component:()=>import('@/views/settings/participations/ParticipationsEdit.vue')
  }

]

export default participationsRoutes