import type {RouteRecordRaw} from 'vue-router'

import tournamentsRoutes from './tournamentsRoutes'
import seasonsRoutes from './seasonsRoutes'
import sponsorsRoutes from './sponsorsRoutes'
import stadiumsRoutes from './stadiumsRoutes'
import teamsRoutes from './teamsRoutes'
import sponsorshipsRoutes from './sponsorshipsRoutes'
import participationsRoutes from './participationsRoutes'
import coachesRoutes from './coachesRoutes'
import providersRoutes from './providersRoutes'
import playersRoutes from './playersRoutes'
import qualificationsRoutes from './qualificationsRoutes'
import fieldsRoutes from './fieldsRoutes'
import formationsRoutes from './formationsRoutes'
import stagesRoutes from './stagesRoutes'
import phasesRoutes from './phasesRoutes'
import positionsRoutes from './positionsRoutes'

const settingsRoutes:RouteRecordRaw[]=[
  ...tournamentsRoutes,
  ...seasonsRoutes,
  ...sponsorsRoutes,
  ...stadiumsRoutes,
  ...teamsRoutes,
  ...sponsorshipsRoutes,
  ...participationsRoutes,
  ...coachesRoutes,
  ...providersRoutes,
  ...playersRoutes,
  ...qualificationsRoutes,
  ...fieldsRoutes,
  ...formationsRoutes,
  ...stagesRoutes,
  ...phasesRoutes,
  ...positionsRoutes,
]

export default settingsRoutes