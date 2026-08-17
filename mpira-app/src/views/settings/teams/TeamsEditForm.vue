<template>
  <form @submit.prevent="saveChanges" class="card p-3 mb-3 bg-light">
    <div class="row g-2 align-items-end">
  
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Name
          </label>
          <ion-input
            v-model="formData.team_name"
            placeholder="Enter Team Name"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>
      
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Nickname
          </label>
          <ion-input
            v-model="formData.nickname"
            placeholder="Enter Nickname"
            class="compact-input"
            :required="false"
          />
        </div>
      </div>
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Code
          </label>
          <ion-input
            v-model="formData.team_code"
            placeholder="Enter Code"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>
      
    
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Established
          </label>
        <ion-select v-model="formData.est"
          interface="popover"
          placeholder="Select Year"
        >
          <ion-select-option v-for="year in years" :key="year" :value="year" >
            {{ year}}
          </ion-select-option>
        </ion-select>
        </div>
      </div>
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            District
          </label>
        <ion-select v-model="formData.district_id"
          interface="popover"
          placeholder="Select District"
        >
          <ion-select-option v-for="district in districts" :key="district.id" :value="district.id" >
            {{ district?.district_name}}
          </ion-select-option>
        </ion-select>
        </div>
      </div>


      <div class="col-md-5 d-flex gap-2">

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
          :router-link="{name:'teams.index'}"
        >
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



interface District{
  id:number
  district_name:string
}

const districts=ref<District[]>([])


const loading=ref(false)


const formData=reactive({

  team_name:'',

  team_code:'',

  nickname:'',

  est:'',

  district_id:null as number|null

})


const currentYear = new Date().getFullYear();
const YearsCount = 150;
const years = Array.from(
  { length: YearsCount },
  (_, i) => currentYear - i
)

async function fetchData(){

  try{

    const teamId=route.params.id

    if(!teamId){
      return
    }


    const {data}=await api.get(
      `/settings/teams/${teamId}/edit`
    )

    const team=data.selectedTeam
    districts.value = data.districts ?? []

    formData.team_name = team?.team_name ?? ''
    formData.team_code = team?.team_code ?? ''
    formData.nickname = team?.nickname ?? ''
    formData.est = team?.est ?? ''
    formData.district_id = team?.district_id ?? null
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

    const teamId=route.params.id


    const payload={
      team_name: formData.team_name,
      team_code: formData.team_code || null,
      nickname: formData.nickname || null,
      est: formData.est || null,
      district_id: formData.district_id || null
    }


    const {data}=await api.put(
      `/settings/teams/${teamId}`,
      payload
    )


    if(data.success){

      router.replace({

        name:'teams.index',

        query:{
          search:
            formData.team_name
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