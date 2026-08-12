import type {RouteRecordRaw} from 'vue-router'

const fieldsRoutes:RouteRecordRaw[]=[

  {
    path:'/settings/fields',
    name:'fields.index',
    component:()=>import('@/views/settings/fields/FieldsIndex.vue')
  },
  
  {
    path:'/settings/fields/create',
    name:'fields.create',
    component:()=>import('@/views/settings/fields/FieldsCreate.vue')
  },
  
  {
    path:'/settings/fields/:id',
    name:'fields.edit',
    component:()=>import('@/views/settings/fields/FieldsEdit.vue')
  },

]

export default fieldsRoutes