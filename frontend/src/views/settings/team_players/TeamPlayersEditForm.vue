```vue
<template>
  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3 bg-light"
  >

    <div class="row g-2 align-items-end">

      <!-- =====================================================
           TEAM PLAYER
           ===================================================== -->

      <!-- Season -->
      <div class="col-md-4 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Season
          </label>

          <ion-select
            v-model="formData.season_id"
            interface="popover"
            placeholder="Select Season"
            required
            @ion-change="fetchData"
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

        </div>
      </div>


      <!-- Team -->
      <div class="col-md-8 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Team
          </label>

          <ion-select
            v-model="formData.team_id"
            interface="popover"
            placeholder="Select Team"
            required
          >

            <ion-select-option
              v-for="team in teams"
              :key="team.id"
              :value="team.id"
            >
              {{ team.team_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Player -->
      <div class="col-md-6 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Player
          </label>

          <ion-select
            v-model="formData.player_id"
            interface="popover"
            placeholder="Select Player"
            required
          >

            <ion-select-option
              v-for="player in players"
              :key="player.id"
              :value="player.id"
            >
              {{ player.person?.first_name }}
              {{ player.person?.middle_name }}
              {{ player.person?.last_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Position -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Position
          </label>

          <ion-select
            v-model="formData.position_id"
            interface="popover"
            placeholder="Select Position"
            required
          >

            <ion-select-option
              v-for="position in positions"
              :key="position.id"
              :value="position.id"
            >
              {{ position.position_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Shirt Number -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Shirt Number
          </label>

          <ion-input
            v-model.number="formData.shirt_number"
            type="number"
            min="1"
            placeholder="Shirt Number"
          />

        </div>
      </div>


      <!-- Transfer Status -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Transfer Status
          </label>

          <ion-select
            v-model="formData.transfer_status_id"
            interface="popover"
            placeholder="Select Transfer Status"
            required
          >

            <ion-select-option
              v-for="status in transfer_statuses"
              :key="status.id"
              :value="status.id"
            >
              {{ status.status_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Loan Status -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Loan Status
          </label>

          <ion-select
            v-model="formData.loan_status_id"
            interface="popover"
            placeholder="Select Loan Status"
            required
          >

            <ion-select-option
              v-for="status in loan_statuses"
              :key="status.id"
              :value="status.id"
            >
              {{ status.status_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- =====================================================
           BUTTONS
           ===================================================== -->

      <div class="col-md-6 d-flex gap-2 py-1 px-2">

        <ion-button
          type="submit"
          size="small"
          :disabled="loading"
        >

          <ion-spinner
            v-if="loading"
            slot="start"
          />

          Save Changes

        </ion-button>


        <ion-button
          type="button"
          color="warning"
          size="small"
          :router-link="{ name: 'team_players.index' }"
        >
          Cancel
        </ion-button>

      </div>

    </div>

  </form>
</template>


<script setup lang="ts">

import {
  onMounted,
  reactive,
  ref, watch
} from 'vue'

import {
  useRouter,useRoute
} from 'vue-router'

import {
  IonInput,
  IonSelect,
  IonSelectOption,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'


// ================================================================
// ROUTER / LOADING
// ================================================================

const router = useRouter()
const route = useRoute()

const loading = ref(false)


// ================================================================
// LOOKUPS
// ================================================================

const seasons = ref<any[]>([])
const teams = ref<any[]>([])
const players = ref<any[]>([])
const positions = ref<any[]>([])
const transfer_statuses = ref<any[]>([])
const loan_statuses = ref<any[]>([])


// ================================================================
// FORM DATA
// ================================================================

const formData = reactive({

  season_id: null as number | null,

  team_id: null as number | null,

  player_id: null as number | null,

  position_id: null as number | null,

  shirt_number: null as number | null,

  transfer_status_id: null as number | null,

  loan_status_id: null as number | null

})


// ================================================================
// LOAD LOOKUPS
// ================================================================

async function fetchData() {

  try {
    
    const teamPlayerId = Number(route.params.id)
    const { data } = await api.get(
      `/settings/team_players/${teamPlayerId}`,
      {
        params: {
          season_id: formData.season_id,
          team_id: formData.team_id,
        },
      }
    )
    
    
    const teamPlayer = data?.selectedTeamPlayer || null
    
    formData.season_id = teamPlayer?.season_id || null
    formData.team_id = teamPlayer?.team_id || null
    formData.player_id = teamPlayer?.player_id || null
    formData.position_id = teamPlayer?.position_id || null
    formData.shirt_number = teamPlayer?.shirt_number || null
    formData.transfer_status_id = teamPlayer?.transfer_status_id || null
    formData.loan_status_id = teamPlayer?.loan_status_id || null

    seasons.value = data?.seasons || []
    teams.value = data?.teams || []
    players.value = data?.players || []
    positions.value = data?.positions || []
    transfer_statuses.value = data?.transfer_statuses || []
    loan_statuses.value = data?.loan_statuses || []
  }
  catch (error) {

    console.error(
      'TEAM PLAYERS LOOKUPS LOAD ERROR:',
      error
    )

  }

}


// ================================================================
// SAVE
// ================================================================
async function saveChanges() {
  loading.value = true

  try {
    const teamPlayerId = Number(route.params.id)

    const payload = {
      season_id: formData.season_id ?? null,
      team_id: formData.team_id ?? null,
      player_id: formData.player_id ?? null,
      position_id: formData.position_id ?? null,
      shirt_number: formData.shirt_number ?? null,
      transfer_status_id: formData.transfer_status_id ?? null,
      loan_status_id: formData.loan_status_id ?? null,
    }
    
    const { data } = await api.put(`/settings/team_players/${teamPlayerId}`,payload)

    router.replace({
        name: 'team_players.index',
        query: {
          search: data?.selectedTeamPlayer?.player?.person?.last_name || undefined
        }
      })
  }
  catch (error: any) {
    console.error('TEAM PLAYER SAVE ERROR:',error)
    console.error('STATUS:',error.response?.status)
    console.error('DATA:',error.response?.data)
    console.error('MESSAGE:',error.message)
    console.error('REQUEST:',error.request)
  }
  finally {
    loading.value = false
  }
}


watch(
  [
    () => formData.season_id,
    () => formData.team_id,
  ],
  async (
    [seasonId, teamId],
    [oldSeasonId, oldTeamId]
  ) => {

    // Reset pagination when either filter changes

    // Update URL
    await router.replace({
      name: 'team_players.create',
      query: {
        ...route.query,

        season_id:
          seasonId !== null
            ? String(seasonId)
            : undefined,

        team_id:
          teamId !== null
            ? String(teamId)
            : undefined,

        page: undefined,
      }
    })

    // Reload team players
    await fetchData()

  }
)
// ================================================================
// INITIALIZE
// ================================================================

fetchData()

</script>
```
