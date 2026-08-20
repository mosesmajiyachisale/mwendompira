import type {RouteRecordRaw} from 'vue-router'

const teamPlayersRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/team_players',
    name:'team_players.index',
    component:()=>import('@/views/settings/team_players/TeamPlayersIndex.vue')
  },

  {
    path:'/settings/team_players/create',
    name:'team_players.create',
    component:()=>import('@/views/settings/team_players/TeamPlayersCreate.vue')
  },

  {
    path:'/settings/team_players/:id/edit',
    name:'team_players.edit',
    component:()=>import('@/views/settings/team_players/TeamPlayersEdit.vue')
  }

]

export default teamPlayersRoutes