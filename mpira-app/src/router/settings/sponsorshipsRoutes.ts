import type {RouteRecordRaw} from 'vue-router'

const sponsorshipsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/sponsorships',
    name:'sponsorships.index',
    component:()=>import('@/views/settings/sponsorships/SponsorshipsIndex.vue')
  },

  {
    path:'/settings/sponsorships/create',
    name:'sponsorships.create',
    component:()=>import('@/views/settings/sponsorships/SponsorshipsCreate.vue')
  },

  {
    path:'/settings/sponsorships/:id/edit',
    name:'sponsorships.edit',
    component:()=>import('@/views/settings/sponsorships/SponsorshipsEdit.vue')
  }

]

export default sponsorshipsRoutes