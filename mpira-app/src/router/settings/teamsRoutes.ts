import type {RouteRecordRaw} from 'vue-router'

const teamsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/teams',
    name:'teams.index',
    component:()=>import('@/views/settings/teams/TeamsIndex.vue')
  },

  {
    path:'/settings/teams/create',
    name:'teams.create',
    component:()=>import('@/views/settings/teams/TeamsCreate.vue')
  },

  {
    path:'/settings/teams/:id/edit',
    name:'teams.edit',
    component:()=>import('@/views/settings/teams/TeamsEdit.vue')
  }

]

export default teamsRoutes