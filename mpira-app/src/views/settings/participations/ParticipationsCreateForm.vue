
<template>
  <form @submit.prevent="saveChanges" class="card p-3 mb-3 bg-light">

    <div class="row g-2 align-items-end">

      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Season
          </label>

          <ion-select
            v-model="formData.season_id"
            interface="popover"
            placeholder="Select Season"
            :required="true"
          >

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

      <div class="col-md-5 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Tournament
          </label>

          <ion-select
            v-model="formData.tournament_id"
            interface="popover"
            placeholder="Select Tournament"
            :required="true"
          >

            <ion-select-option
              v-for="tournament in tournaments"
              :key="tournament.id"
              :value="tournament.id"
            >
              {{ tournament.tournament_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>

      <div class="col-md-4 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Team
          </label>

          <ion-select
            v-model="formData.team_id"
            interface="popover"
            placeholder="Select Team"
            :required="true"
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
      
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Home Stadium
          </label>

          <ion-select
            v-model="formData.stadium_id"
            interface="popover"
            placeholder="Select Stadium"
          >

            <ion-select-option
              v-for="stadium in stadiums"
              :key="stadium.id"
              :value="stadium.id"
            >
              {{ stadium.location_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>

      <div class="col-md-5 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Team Sponsor
          </label>

          <ion-select
            v-model="formData.sponsor_id"
            interface="popover"
            placeholder="Select Sponsor"
            :required="true"
          >

            <ion-select-option
              v-for="sponsor in sponsors"
              :key="sponsor.id"
              :value="sponsor.id"
            >
              {{ sponsor.sponsor_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>

      <div class="col-md-4 d-flex gap-2">

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
          :router-link="{name:'participations.index'}"
        >
          Cancel
        </ion-button>

      </div>
    </div>

  </form>
</template>

  
  <script setup lang="ts">
  
  import {reactive,ref} from 'vue'
  import {useRouter} from 'vue-router'
  
  import {
    IonSelect,
    IonSelectOption,
    IonButton,
    IonSpinner
  } from '@ionic/vue'
  
  import api from '@/api'
  
  
  const router=useRouter()
  
  
  interface Season{
    id:number
    season_code:string
  }
  
  
  interface Tournament{
    id:number
    tournament_name:string
  }
  
  
  interface Team{
    id:number
    team_name:string
  }
  
  
  interface Sponsor{
    id:number
    sponsor_name:string
  }
  
  
  interface Stadium{
    id:number
    location_name:string
  }
  
  
  const seasons=ref<Season[]>([])
  
  const tournaments=ref<Tournament[]>([])
  
  const teams=ref<Team[]>([])
  
  const sponsors=ref<Sponsor[]>([])
  
  const stadiums=ref<Stadium[]>([])
  const selectedParticipation = ref(null)
  
  const loading=ref(false)
  
  
  const formData=reactive({
  
    season_id:null as number|null,
  
    tournament_id:null as number|null,
  
    team_id:null as number|null,
  
    sponsor_id:null as number|null,
  
    stadium_id:null as number|null,
  
    is_active:true
  
  })
  
  
  async function fetchData(){
    try{
      const {data}=await api.get('/settings/participations/create')

      seasons.value=data.seasons ?? []
      tournaments.value=data.tournaments ?? []
      teams.value=data.teams ?? []
      sponsors.value=data.sponsors ?? []
      stadiums.value=data.stadiums ?? []

      selectedParticipation.value = data.selectedParticipation ?? null
    }
    catch(error:any){
      console.error(error.response?.data || error)
    }
  }
  
  
  async function saveChanges()  {
    loading.value=true 
    try{
      const payload={
        season_id: formData.season_id,
        tournament_id: formData.tournament_id,
        team_id: formData.team_id,
        sponsor_id: formData.sponsor_id, 
        stadium_id: formData.stadium_id,
      }
  
      const {data}=await api.post('/settings/participations',payload)
        if(data.success){
            router.replace({
            name:'participations.index',
            query:{
                search: data?.selectedParticipation?.team?.team_name ?? null
                }
            })
        }
    }
    catch(error:any){
      console.error(error.response?.data || error)
    }
    finally{
      loading.value=false
    }
  }
  
  
  fetchData()
  
  </script>