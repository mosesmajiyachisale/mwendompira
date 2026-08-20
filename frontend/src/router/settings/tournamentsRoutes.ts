import type {RouteRecordRaw} from 'vue-router'

const tournamentsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/tournaments',
    name:'tournaments.index',
    component:()=>import('@/views/settings/tournaments/TournamentsIndex.vue')
  },

  {
    path:'/settings/tournaments/create',
    name:'tournaments.create',
    component:()=>import('@/views/settings/tournaments/TournamentsCreate.vue')
  },

  {
    path:'/settings/tournaments/:id/edit',
    name:'tournaments.edit',
    component:()=>import('@/views/settings/tournaments/TournamentsEdit.vue')
  }

]

export default tournamentsRoutes