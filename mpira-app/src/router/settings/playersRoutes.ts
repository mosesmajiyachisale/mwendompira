import type {RouteRecordRaw} from 'vue-router'

const playersRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/players',
    name:'players.index',
    component:()=>import('@/views/settings/players/PlayersIndex.vue')
  }

]

export default playersRoutes