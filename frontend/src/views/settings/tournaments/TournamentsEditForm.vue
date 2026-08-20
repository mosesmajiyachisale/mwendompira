<template>
  <form @submit.prevent="saveChanges" class="card p-3 mb-3">
    <div class="row g-2 align-items-end">
      
      <div class="col-md-4 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Name
          </label>
          <ion-input
            v-model="formData.tournament_name"
            placeholder="Enter Tournament Name"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Code
          </label>
          <ion-input
            v-model="formData.tournament_code"
            placeholder="Enter Tournament Code"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>

      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Type
          </label>
          <ion-select
            v-model="formData.tournament_type_id"
            interface="popover"
            placeholder="Select tournament type"
          >
            <ion-select-option
              v-for="tournament_type in tournament_types"
              :key="tournament_type.id"
              :value="tournament_type.id"
            >
              {{ tournament_type.tournament_type_name }}
            </ion-select-option>
          </ion-select>
        </div>
      </div>

      <div class="col-md-4 d-flex gap-2">

        <ion-button type="submit" :disabled="loading">
          <ion-spinner v-if="loading" slot="start"/>
          Save Changes
        </ion-button>

        <ion-button type="button" color="warning" :router-link="{name:'tournaments.index'}">
          Cancel
        </ion-button>

      </div>

    </div>
  </form>
</template>

<script setup lang="ts">
import {reactive,ref} from 'vue'
import {onIonViewWillEnter} from '@ionic/vue'
import {useRoute,useRouter} from 'vue-router'

import {
  IonInput,
  IonSelect,
  IonSelectOption,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'

const route=useRoute()
const router=useRouter()

const loading=ref(false)

interface TournamentType{
  id:number
  tournament_type_name:string
}

const tournament_types=ref<TournamentType[]>([])

const formData=reactive({

  tournament_name:'',
  tournament_code:'',
  tournament_type_id:null as number|null

})


async function fetchData(){

  try{

    const tournamentId=Number(route.params.id)

    const {data}=await api.get(
      `/settings/tournaments/${tournamentId}/edit`
    )

    tournament_types.value = data.tournament_types ?? []

    const tournament = data.selectedTournament

    formData.tournament_name = data.selectedTournament ?.tournament_name ?? ''

    formData.tournament_code =
      tournament?.tournament_code ?? ''

    formData.tournament_type_id =
      tournament?.tournament_type_id ?? null

  }
  catch(error:any){

    console.error(
      error.response?.data || error
    )

  }

}


async function saveChanges(){

  loading.value=true

  try{

    const tournamentId =
      Number(route.params.id)

    const payload={

      tournament_name:
        formData.tournament_name,

      tournament_code:
        formData.tournament_code || null,

      tournament_type_id:
        formData.tournament_type_id

    }


    const {data}=await api.put(
      `/settings/tournaments/${tournamentId}`,
      payload
    )


    if(data.success){

      router.replace({

        name:'tournaments.index',

        query:{
          search:
            formData.tournament_name
        }

      })

    }

  }
  catch(error:any){

    console.error(
      error.response?.data || error
    )

  }
  finally{

    loading.value=false

  }

}

fetchData()
</script>