<template>
  
  <form @submit.prevent="saveChanges" class="card p-3 mb-3">
      <div class="row g-2 align-items-end">

        <div class="col-md-4 py-1 px-2">
          <div class="control-block">
            <label class="control-block-label">
              Stadium Name
            </label>
            <ion-input
              v-model="formData.location_name"
              placeholder="Enter Stadium Name"
              class="compact-input"
              :required="true"
            />
          </div>
        </div>
      
        <div class="col-md-3 py-1 px-2">
          <div class="control-block">
            <label class="control-block-label">
              District
            </label>
          <ion-select
            v-model="formData.parent_id"
            interface="popover"
            placeholder="Select District"
          >
            <ion-select-option
              v-for="district in districts"
              :key="district.id"
              :value="district.id"
            >
              {{ district.location_name}}
            </ion-select-option>
          </ion-select>
          </div>
        </div>
      
        <div class="col-md-5 d-flex gap-2">
          <ion-button
            type="submit"
            size="default"
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
            size="default"
            :router-link="{name:'stadiums.index'}"
          >
            Cancel
          </ion-button>
        </div>
      </div>
      
    </form>
</template>

<script setup lang="ts">

import { ref, reactive, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/api'

import { 
  IonSelect,
  IonSelectOption,
  IonInput,
  IonButton,
  IonSpinner,
} from '@ionic/vue'
import { search } from 'ionicons/icons'


const route = useRoute()
const router = useRouter()

const loading = ref(false)

interface District {
  id:number
  location_name:string
}

interface Stadium {
  id:number
  location_name:string
  parent_id:number|null
}


const districts = ref<District[]>([])
const stadiums = ref<District[]>([])
const selectedStadium = ref<Stadium|null>(null)


const formData = reactive({
  location_name:'' as string,
  parent_id:null as number|null
})


const fetchData = async()=>{
  try{
    const stadiumId = route.params.id ?? null
    const {data} = await api.get(`/settings/stadiums/${stadiumId}/edit`)

    selectedStadium.value = data.selectedStadium ?? null
    stadiums.value = data.stadiums ?? []
    districts.value = data.districts ?? []
    formData.location_name = data?.selectedStadium?.location_name || ''
    formData.parent_id = data?.selectedStadium?.parent_id || null

  }
  catch(error:any){

    console.error(error.response?.data || error)

  }

}


const saveChanges = async()=>{
  loading.value=true
  try{

    const stadiumId = route.params.id
    const payload = {
      location_name: formData.location_name,
      parent_id: formData.parent_id
    }
    const {data} = await api.put(`/settings/stadiums/${stadiumId}`,payload)
  }
  catch(error:any){

    console.error(error.response?.data || error)

  }
  finally{

    loading.value=false
    
    router.push({
      name: 'stadiums.index',
      query: {
        search: formData.location_name
      }
    })

  }

}

onMounted(()=>{

  fetchData()

})

</script>