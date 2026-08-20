import type {RouteRecordRaw} from 'vue-router'

const positionsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/positions',
    name:'positions.index',
    component:()=>import('@/views/settings/positions/PositionsIndex.vue')
  },

]

export default positionsRoutes