import type {RouteRecordRaw} from 'vue-router'

const seasonsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/seasons',
    name:'seasons.index',
    component:()=>import('@/views/settings/seasons/SeasonsIndex.vue')
  },

  {
    path:'/settings/seasons/:id/edit',
    name:'seasons.edit',
    component:()=>import('@/views/settings/seasons/SeasonsEdit.vue')
  }

]

export default seasonsRoutes