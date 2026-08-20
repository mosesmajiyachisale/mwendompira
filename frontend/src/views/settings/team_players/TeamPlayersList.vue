<template>
  <div class="team_players-list mb-5 pb-5">

    <!-- =========================================================
         TOOLBAR
         ========================================================= -->

    <div
      class="d-flex justify-content-between align-items-center gap-2 flex-wrap"
    >

      <div class="d-flex align-items-center gap-2 flex-wrap">

        <!-- =====================================================
             SEARCH
             ===================================================== -->

        <ion-searchbar
          v-model="formData.search"
          placeholder="Search team players..."
          :debounce="300"
          class="team-player-search"
        />


        <!-- =====================================================
             SEASON
             ===================================================== -->

        <ion-select
          v-model="formData.season_id"
          interface="popover"
          aria-label="Season"
          placeholder="Season"
          class="season-select"
          @ion-change="handleSeasonChange"
        >

          <ion-select-option :value="null">
            All Seasons
          </ion-select-option>

          <ion-select-option
            v-for="season in seasons"
            :key="season.id"
            :value="season.id"
          >
            {{ season.season_code }}
          </ion-select-option>

        </ion-select>


        <!-- =====================================================
             TEAM
             ===================================================== -->

        <ion-select
          v-model="formData.team_id"
          interface="popover"
          aria-label="Team"
          placeholder="Team"
          class="team-select"
          :disabled="loadingTeams"
          @ion-change="handleTeamChange"
        >

          <ion-select-option :value="null">
            All Teams
          </ion-select-option>

          <ion-select-option
            v-for="team in teams"
            :key="team.id"
            :value="team.id"
          >
            {{ team.team_name }}
          </ion-select-option>

        </ion-select>


        <!-- =====================================================
             PER PAGE
             ===================================================== -->

        <ion-select
          v-model="perPage"
          interface="popover"
          aria-label="Items per page"
          class="per-page-select"
        >

          <ion-select-option :value="5">
            5
          </ion-select-option>

          <ion-select-option :value="10">
            10
          </ion-select-option>

          <ion-select-option :value="25">
            25
          </ion-select-option>

          <ion-select-option :value="50">
            50
          </ion-select-option>

        </ion-select>

      </div>


      <!-- =======================================================
           NEW TEAM PLAYER
           ======================================================= -->

      <ion-button
        size="small"
        @click="createTeamPlayer"
      >

        <ion-icon
          slot="start"
          :icon="add"
        />

        New Team Player

      </ion-button>

    </div>


    <!-- =========================================================
         TABLE
         ========================================================= -->

    <div class="table-responsive">

      <table
        class="table table-striped table-bordered table-hover table-sm align-middle mb-0"
      >

        <thead>

          <tr>

            <!-- NUMBER -->

            <th
              class="text-center"
              style="width: 60px;"
            >
              #
            </th>


            <!-- SEASON -->

            <th
              class="sortable"
              @click="sortBy('season')"
            >

              Season

              <span v-if="sortColumn === 'season'">

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- TEAM -->

            <th
              class="sortable"
              @click="sortBy('team')"
            >

              Team

              <span v-if="sortColumn === 'team'">

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- PLAYER -->

            <th
              class="sortable"
              @click="sortBy('player')"
            >

              Player

              <span v-if="sortColumn === 'player'">

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- POSITION -->

            <th
              class="sortable"
              @click="sortBy('position')"
            >

              Position

              <span v-if="sortColumn === 'position'">

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- SHIRT NUMBER -->

            <th
              class="sortable text-center"
              @click="sortBy('shirt_number')"
            >

              Shirt No.

              <span v-if="sortColumn === 'shirt_number'">

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- TRANSFER STATUS -->

            <th
              class="sortable"
              @click="sortBy('transfer_status')"
            >

              Transfer Status

              <span
                v-if="sortColumn === 'transfer_status'"
              >

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- LOAN STATUS -->

            <th
              class="sortable"
              @click="sortBy('loan_status')"
            >

              Loan Status

              <span
                v-if="sortColumn === 'loan_status'"
              >

                {{ sortDirection === 'asc' ? '▲' : '▼' }}

              </span>

            </th>


            <!-- ACTIONS -->

            <th
              class="text-center"
              style="width: 100px;"
            >
              Actions
            </th>

          </tr>

        </thead>


        <tbody>

          <!-- ===================================================
               LOADING
               =================================================== -->

          <tr v-if="loading">

            <td
              colspan="9"
              class="text-center text-muted py-4"
            >

              Loading team players...

            </td>

          </tr>


          <!-- ===================================================
               EMPTY
               =================================================== -->

          <tr
            v-else-if="paginatedTeamPlayers.length === 0"
          >

            <td
              colspan="9"
              class="text-center text-muted py-4"
            >

              <span v-if="formData.search">

                No team players found for
                "{{ formData.search }}".

              </span>

              <span v-else>

                No team players found.

              </span>

            </td>

          </tr>


          <!-- ===================================================
               DATA
               =================================================== -->

          <tr
            v-for="(teamPlayer, index) in paginatedTeamPlayers"
            :key="teamPlayer.id"
          >

            <!-- NUMBER -->

            <td class="text-center">

              {{ startIndex + index + 1 }}

            </td>


            <!-- SEASON -->

            <td>

              {{ teamPlayer.season?.season_code || '-' }}

            </td>


            <!-- TEAM -->

            <td>

              {{ teamPlayer.team?.team_name || '-' }}

            </td>


            <!-- PLAYER -->

            <td>

              {{ fullName(teamPlayer.player?.person) }}

            </td>


            <!-- POSITION -->

            <td>

              {{ teamPlayer.position?.position_name || '-' }}

            </td>


            <!-- SHIRT NUMBER -->

            <td class="text-center">

              {{ teamPlayer.shirt_number ?? '-' }}

            </td>


            <!-- TRANSFER STATUS -->

            <td>

              {{ teamPlayer.transfer_status?.status_name || '-' }}

            </td>


            <!-- LOAN STATUS -->

            <td>

              {{ teamPlayer.loan_status?.status_name || '-' }}

            </td>


            <!-- ACTIONS -->

            <td class="text-center">
              <ion-button
                fill="clear"
                size="small"
                :router-link="{
                  path: `/settings/team_players/${teamPlayer.id}/edit`,
                  query: {
                    season_id: teamPlayer.season_id,
                    team_id: teamPlayer.team_id
                  }
                }"
              >
                <ion-icon
                  :icon="pencilSharp"
                />
              </ion-button>

            </td>

          </tr>

        </tbody>

      </table>

    </div>


    <!-- =========================================================
         PAGINATION
         ========================================================= -->

    <div
      v-if="totalPages > 1"
      class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-2"
    >

      <!-- =======================================================
           RESULTS INFORMATION
           ======================================================= -->

      <div class="text-muted small">

        Showing

        {{ startIndex + 1 }}

        -

        {{
          Math.min(
            startIndex + perPage,
            sortedTeamPlayers.length
          )
        }}

        of

        {{ sortedTeamPlayers.length }}

      </div>


      <!-- =======================================================
           PAGINATION CONTROLS
           ======================================================= -->

      <div
        class="d-flex align-items-center gap-2"
      >

        <ion-button
          size="small"
          fill="outline"
          :disabled="page <= 1"
          @click="previousPage"
        >

          Previous

        </ion-button>


        <span class="small">

          Page {{ page }} of {{ totalPages }}

        </span>


        <ion-button
          size="small"
          fill="outline"
          :disabled="page >= totalPages"
          @click="nextPage"
        >

          Next

        </ion-button>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import {
  computed,
  ref,
  watch,
} from 'vue'


import {
  add,
  pencilSharp,
} from 'ionicons/icons'


import {
  useRoute,
  useRouter,
} from 'vue-router'


import {
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
} from '@ionic/vue'


import api from '@/api'


// ================================================================
// TYPES
// ================================================================

interface Person {

  id: number

  first_name: string

  middle_name?: string | null

  last_name: string

}


interface Player {

  id: number

  person_id: number

  person?: Person

}


interface Team {

  id: number

  team_name: string

}


interface Season {

  id: number

  season_code: string

}


interface Position {

  id: number

  position_name: string

}


interface Status {

  id: number

  status_name: string

  status_code: string

}


interface TeamPlayer {

  id: number

  season_id: number

  team_id: number

  player_id: number

  position_id: number

  shirt_number?: number | null

  transfer_status_id: number
  loan_status_id: number

  season?: Season

  team?: Team

  player?: Player

  position?: Position

  transfer_status?: Status

  loan_status?: Status

}


// ================================================================
// ROUTER
// ================================================================

const route = useRoute()

const router = useRouter()


// ================================================================
// DATA
// ================================================================

const teamPlayers =
  ref<TeamPlayer[]>([])


const seasons =
  ref<Season[]>([])


const teams =
  ref<Team[]>([])


const loading =
  ref(false)


const loadingTeams =
  ref(false)


// ================================================================
// FORM DATA
// ================================================================

const formData = ref({

  search:
    typeof route.query.search === 'string'
      ? route.query.search
      : '',

  season_id:
    route.query.season_id
      ? Number(route.query.season_id)
      : null,

  team_id:
    route.query.team_id
      ? Number(route.query.team_id)
      : null,

})


// ================================================================
// PAGINATION
// ================================================================

const perPage =
  ref(
    Number(route.query.perPage) || 10
  )


const page =
  ref(
    Number(route.query.page) || 1
  )


// ================================================================
// SORTING
// ================================================================

const sortColumn =
  ref(
    typeof route.query.sort === 'string'
      ? route.query.sort
      : 'player'
  )


const sortDirection =
  ref<'asc' | 'desc'>(
    route.query.direction === 'desc'
      ? 'desc'
      : 'asc'
  )


// ================================================================
// REQUEST CONTROL
// ================================================================

let requestId = 0


// ================================================================
// FULL NAME
// ================================================================

const fullName = (
  person?: Person
): string => {

  if (!person) {

    return '-'

  }

  return [

    person.first_name,

    person.middle_name,

    person.last_name,

  ]
    .filter(Boolean)
    .join(' ')

}


// ================================================================
// CREATE TEAM PLAYER
// ================================================================
//
// IMPORTANT:
//
// Carry the current list filters into the create form.
//
// Example:
//
// /settings/team_players?season_id=3&team_id=7
//
// becomes:
//
// /settings/team_players/create?season_id=3&team_id=7
//
// ================================================================

const createTeamPlayer = () => {

  router.push({

    name: 'team_players.create',

    query: {

      season_id:
        formData.value.season_id ?? undefined,

      team_id:
        formData.value.team_id ?? undefined,

    }

  })

}


// ================================================================
// FETCH DATA
// ================================================================

const fetchData = async () => {

  const currentRequestId =
    ++requestId

  loading.value = true

  try {

    const { data } = await api.get(
      '/settings/team_players',
      {
        params: {

          season_id:
            formData.value.season_id,

          team_id:
            formData.value.team_id,

        },
      }
    )


    // ------------------------------------------------------------
    // TEAM PLAYERS
    // ------------------------------------------------------------

    teamPlayers.value =
      data?.teamPlayers || []


    // ------------------------------------------------------------
    // SEASONS
    // ------------------------------------------------------------

    seasons.value =
      data?.seasons || []


    // ------------------------------------------------------------
    // TEAMS
    // ------------------------------------------------------------

    teams.value =
      data?.teams || []


    // ------------------------------------------------------------
    // VALIDATE SELECTED TEAM
    // ------------------------------------------------------------

    if (
      formData.value.team_id !== null &&
      !teams.value.some(
        team =>
          team.id ===
          formData.value.team_id
      )
    ) {

      formData.value.team_id = null

    }


    // ------------------------------------------------------------
    // PAGE VALIDATION
    // ------------------------------------------------------------

    if (
      page.value > totalPages.value
    ) {

      page.value =
        totalPages.value

    }

  }
  catch (error) {

    console.error(
      'TEAM PLAYERS LOAD ERROR:',
      error
    )

    teamPlayers.value = []

  }
  finally {

    if (
      currentRequestId === requestId
    ) {

      loading.value = false

    }

  }

}


// ================================================================
// FILTERED TEAM PLAYERS
// ================================================================

const filteredTeamPlayers =
  computed(() => {

    const search =
      formData.value.search
        ?.trim()
        .toLowerCase()


    // ------------------------------------------------------------
    // NO SEARCH
    // ------------------------------------------------------------

    if (!search) {

      return [
        ...teamPlayers.value
      ]

    }


    // ------------------------------------------------------------
    // SEARCH
    // ------------------------------------------------------------

    return teamPlayers.value.filter(
      (teamPlayer) => {

        const playerName =
          fullName(
            teamPlayer.player?.person
          ).toLowerCase()


        const teamName =
          (
            teamPlayer.team?.team_name || ''
          ).toLowerCase()


        const seasonCode =
          (
            teamPlayer.season?.season_code || ''
          ).toLowerCase()


        const positionName =
          (
            teamPlayer.position?.position_name || ''
          ).toLowerCase()


        const shirtNumber =
          String(
            teamPlayer.shirt_number ?? ''
          ).toLowerCase()


        const transferStatus =
          (
            teamPlayer.transfer_status?.status_name || ''
          ).toLowerCase()


        const loanStatus =
          (
            teamPlayer.loan_status?.status_name || ''
          ).toLowerCase()


        return (

          playerName.includes(search) ||

          teamName.includes(search) ||

          seasonCode.includes(search) ||

          positionName.includes(search) ||

          shirtNumber.includes(search) ||

          transferStatus.includes(search) ||

          loanStatus.includes(search)

        )

      }
    )

  })


// ================================================================
// SORTED TEAM PLAYERS
// ================================================================

const sortedTeamPlayers =
  computed(() => {

    const items = [
      ...filteredTeamPlayers.value
    ]


    items.sort(
      (a, b) => {

        let valueA:
          string | number = ''

        let valueB:
          string | number = ''


        switch (
          sortColumn.value
        ) {

          // ------------------------------------------------------
          // PLAYER
          // ------------------------------------------------------

          case 'player':

            valueA =
              fullName(
                a.player?.person
              ).toLowerCase()

            valueB =
              fullName(
                b.player?.person
              ).toLowerCase()

            break


          // ------------------------------------------------------
          // TEAM
          // ------------------------------------------------------

          case 'team':

            valueA =
              (
                a.team?.team_name || ''
              ).toLowerCase()

            valueB =
              (
                b.team?.team_name || ''
              ).toLowerCase()

            break


          // ------------------------------------------------------
          // SEASON
          // ------------------------------------------------------

          case 'season':

            valueA =
              (
                a.season?.season_code || ''
              ).toLowerCase()

            valueB =
              (
                b.season?.season_code || ''
              ).toLowerCase()

            break


          // ------------------------------------------------------
          // POSITION
          // ------------------------------------------------------

          case 'position':

            valueA =
              (
                a.position?.position_name || ''
              ).toLowerCase()

            valueB =
              (
                b.position?.position_name || ''
              ).toLowerCase()

            break


          // ------------------------------------------------------
          // SHIRT NUMBER
          // ------------------------------------------------------

          case 'shirt_number':

            valueA =
              a.shirt_number ?? -1

            valueB =
              b.shirt_number ?? -1

            break


          // ------------------------------------------------------
          // TRANSFER STATUS
          // ------------------------------------------------------

          case 'transfer_status':

            valueA =
              (
                a.transfer_status?.status_name || ''
              ).toLowerCase()

            valueB =
              (
                b.transfer_status?.status_name || ''
              ).toLowerCase()

            break


          // ------------------------------------------------------
          // LOAN STATUS
          // ------------------------------------------------------

          case 'loan_status':

            valueA =
              (
                a.loan_status?.status_name || ''
              ).toLowerCase()

            valueB =
              (
                b.loan_status?.status_name || ''
              ).toLowerCase()

            break

        }


        if (valueA < valueB) {

          return sortDirection.value === 'asc'
            ? -1
            : 1

        }


        if (valueA > valueB) {

          return sortDirection.value === 'asc'
            ? 1
            : -1

        }


        return 0

      }
    )


    return items

  })


// ================================================================
// PAGINATION
// ================================================================

const totalPages =
  computed(() => {

    return Math.max(

      1,

      Math.ceil(

        sortedTeamPlayers.value.length /
        perPage.value

      )

    )

  })


const startIndex =
  computed(() => {

    return (

      page.value - 1

    ) *

    perPage.value

  })


const paginatedTeamPlayers =
  computed(() => {

    return sortedTeamPlayers.value.slice(

      startIndex.value,

      startIndex.value +
      perPage.value

    )

  })


// ================================================================
// SORT
// ================================================================

const sortBy = (
  column: string
) => {

  if (
    sortColumn.value === column
  ) {

    sortDirection.value =
      sortDirection.value === 'asc'
        ? 'desc'
        : 'asc'

  }
  else {

    sortColumn.value =
      column

    sortDirection.value =
      'asc'

  }


  page.value = 1

  updateRouteQuery()

}


// ================================================================
// PREVIOUS PAGE
// ================================================================

const previousPage = () => {

  if (
    page.value > 1
  ) {

    page.value--

    updateRouteQuery()

  }

}


// ================================================================
// NEXT PAGE
// ================================================================

const nextPage = () => {

  if (
    page.value <
    totalPages.value
  ) {

    page.value++

    updateRouteQuery()

  }

}


// ================================================================
// SEASON CHANGE
// ================================================================

const handleSeasonChange = async () => {

  page.value = 1


  // --------------------------------------------------------------
  // A season change resets the team filter.
  // --------------------------------------------------------------

  formData.value.team_id = null


  // --------------------------------------------------------------
  // Reload data for the new season.
  // --------------------------------------------------------------

  await fetchData()


  // --------------------------------------------------------------
  // Store the new season in the URL.
  // --------------------------------------------------------------

  await updateRouteQuery()

}


// ================================================================
// TEAM CHANGE
// ================================================================

const handleTeamChange = async () => {

  page.value = 1


  await fetchData()


  await updateRouteQuery()

}


// ================================================================
// UPDATE ROUTE QUERY
// ================================================================

const updateRouteQuery = async () => {

  const query:
    Record<string, string> = {}


  // --------------------------------------------------------------
  // SEARCH
  // --------------------------------------------------------------

  if (
    formData.value.search?.trim()
  ) {

    query.search =
      formData.value.search.trim()

  }


  // --------------------------------------------------------------
  // SEASON
  // --------------------------------------------------------------

  if (
    formData.value.season_id !== null
  ) {

    query.season_id =
      String(
        formData.value.season_id
      )

  }


  // --------------------------------------------------------------
  // TEAM
  // --------------------------------------------------------------

  if (
    formData.value.team_id !== null
  ) {

    query.team_id =
      String(
        formData.value.team_id
      )

  }


  // --------------------------------------------------------------
  // PER PAGE
  // --------------------------------------------------------------

  if (
    perPage.value !== 10
  ) {

    query.perPage =
      String(
        perPage.value
      )

  }


  // --------------------------------------------------------------
  // PAGE
  // --------------------------------------------------------------

  if (
    page.value !== 1
  ) {

    query.page =
      String(
        page.value
      )

  }


  // --------------------------------------------------------------
  // SORT
  // --------------------------------------------------------------

  if (
    sortColumn.value !== 'player'
  ) {

    query.sort =
      sortColumn.value

  }


  // --------------------------------------------------------------
  // SORT DIRECTION
  // --------------------------------------------------------------

  if (
    sortDirection.value !== 'asc'
  ) {

    query.direction =
      sortDirection.value

  }


  await router.replace({

    query,

  })

}


// ================================================================
// SEARCH WATCH
// ================================================================

watch(
  () => formData.value.search,

  () => {

    page.value = 1

    updateRouteQuery()

  }
)


// ================================================================
// PER PAGE WATCH
// ================================================================

watch(
  perPage,

  () => {

    page.value = 1

    updateRouteQuery()

  }
)

// ================================================================
// WATCH URL
// ================================================================

let syncingFromUrl = false

watch(
  () => route.query,
  async (query) => {

    syncingFromUrl = true

    formData.value.search =
      typeof query.search === 'string'
        ? query.search
        : ''

    formData.value.season_id =
      query.season_id
        ? Number(query.season_id)
        : null

    formData.value.team_id =
      query.team_id
        ? Number(query.team_id)
        : null

    perPage.value =
      query.perPage
        ? Number(query.perPage)
        : 10

    page.value =
      query.page
        ? Number(query.page)
        : 1

    sortColumn.value =
      typeof query.sort === 'string'
        ? query.sort
        : 'player'

    sortDirection.value =
      query.direction === 'desc'
        ? 'desc'
        : 'asc'

    syncingFromUrl = false

    await fetchData()

  },
  { deep: true }
)

// ================================================================
// INITIAL LOAD
// ================================================================

fetchData()

</script>


<style scoped>

.team_players-list {

  width: 100%;

}


.team-player-search {

  width: 300px;

  padding: 0;

}


.season-select {

  width: 130px;

}


.team-select {

  width: 160px;

}


.per-page-select {

  width: 90px;

}


.sortable {

  cursor: pointer;

  user-select: none;

  white-space: nowrap;

}


.sortable:hover {

  text-decoration: underline;

}


table {

  font-size: 0.875rem;

}


th {

  white-space: nowrap;

}


td {

  vertical-align: middle;

}

</style>