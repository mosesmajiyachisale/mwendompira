<template>
  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3"
  >

    <div class="row g-2 align-items-end">
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Season Code
          </label>
          <ion-input
            v-model="formData.season_code"
            placeholder="Enter season code"
            class="compact-input"
            required
            :disabled="true"
          />
        </div>
      </div>

      
      <div class="col-md-4 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Start Date
          </label>
          <DateSelect
            v-model="formData.start_date"
            :min-year="minimumYear"
            :max-year="maximumYear"
          />
        </div>
      </div>
      
      <div class="col-md-4 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            End Date {{  }}
          </label>
          <DateSelect
            v-model="formData.end_date"
            :min-year="minimumYear"
            :max-year="maximumYear"
          />
        </div>
      </div>
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Active
          </label>
          
        <ion-select
          v-model="formData.is_active"
          interface="popover"
        >

          <ion-select-option :value="true">
            Yes
          </ion-select-option>

          <ion-select-option :value="false">
            No
          </ion-select-option>

        </ion-select>
        </div>
      </div>


      <div class="col-12 d-flex gap-2">

        <ion-button
          type="submit"
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
          :router-link="{name: 'seasons.index'}"
        >
          Cancel
        </ion-button>

      </div>

    </div>

  </form>
</template>


<script setup lang="ts">

import {reactive,ref} from 'vue'
import {useRoute,useRouter} from 'vue-router'

import {
  IonInput,
  IonSelect,
  IonSelectOption,
  IonButton,
  IonSpinner,
  IonItem,
  IonLabel,
  IonDatetime,
  IonDatetimeButton,
  IonModal,
} from '@ionic/vue'

import api from '@/api'
import DateSelect from '@/components/DateSelect.vue'
import { search } from 'ionicons/icons'


const route = useRoute()
const router = useRouter()
const loading = ref(false)

const currentYear = new Date().getFullYear()
const maximumYear = ref(currentYear);
const minimumYear = ref(currentYear - 50);

const formData = reactive({
  id: '',
  season_code:'',

  start_date:'',

  end_date:'',

  status:'upcoming',

  is_active:true

})



async function fetchData(){
  try{
    const seasonId = route.params.id
    const {data}=await api.get(`/settings/seasons/${seasonId}/edit`)
    console.log(data)
    const season =data.selectedSeason ?? null
    
    formData.id = season?.id ?? 0,
    formData.season_code =season?.season_code ?? ''
    formData.start_date =season?.start_date ?? ''
    formData.end_date =season?.end_date ?? ''
    formData.status =season?.status ?? 'upcoming'
    formData.is_active = Boolean(season?.is_active) ?? false

    minimumYear.value = Number(seasonId);
    maximumYear.value = Number(seasonId) + 1
  }
  catch(error:any){
    console.error(error.response?.data || error)
  }

}



async function saveChanges(){
  loading.value=true
  try{
    const seasonId =route.params.id
    const payload={
      season_code: formData.season_code,
      start_date: formData.start_date || null,
      end_date: formData.end_date || null,
      status: formData.status,
      is_active: formData.is_active
    }
    const {data}=await api.put(`/settings/seasons/${seasonId}`,payload)
    
    router.replace({
      name: 'seasons.index',
      query: {
        search: formData.season_code
      }
    });

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
