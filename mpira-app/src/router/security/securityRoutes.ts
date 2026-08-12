import type {RouteRecordRaw} from 'vue-router'

import usersRoutes from './usersRoutes'
import rolesRoutes from './rolesRoutes'
import permissionsRoutes from './permissionsRoutes'

const securityRoutes:RouteRecordRaw[]=[
  ...usersRoutes,
  ...rolesRoutes,
  ...permissionsRoutes
]

export default securityRoutes