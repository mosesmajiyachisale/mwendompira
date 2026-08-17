import type {RouteRecordRaw} from 'vue-router'

const playersRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/players',
    name:'players.index',
    component:()=>import('@/views/settings/players/PlayersIndex.vue')
  },  
  {
    path:'/settings/players/create',
    name:'players.create',
    component:()=>import('@/views/settings/players/PlayersCreate.vue')
  },  
  {
    path:'/settings/players/:id/edit',
    name:'players.edit',
    component:()=>import('@/views/settings/players/PlayersEdit.vue')
  }

]

export default playersRoutes