<template>
  <ion-page>

    <ion-content color="light" class="ion-no-padding">

      <div class="app-page">

        <!-- Page Header -->
        <ion-toolbar class="page-toolbar">
          <ion-title>Stadiums</ion-title>
        </ion-toolbar>
        

        <!-- Table Content -->
        <div class="page-content md:text-sm">
          <StadiumsCreateForm />
          <!-- Stadium List  -->
          <StadiumsList :stadiums="stadiums" :loading="loading"/>

        </div>
      </div>
    </ion-content>
  </ion-page>
</template>


<script setup lang="ts">
import StadiumsList from './StadiumsList.vue'
import StadiumsCreateForm from './StadiumsCreateForm.vue'
import { ref } from 'vue'
import { onIonViewWillEnter } from '@ionic/vue'
import { useRouter } from 'vue-router'

import {
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle,
  IonButtons,
  IonButton,
  IonIcon,
  IonItem,
  IonInput,
  IonList,
  IonSelect,
  IonSelectOption,
  IonSpinner,
  IonAlert,
  IonLabel,

} from '@ionic/vue'

import {add, arrowBack, locationOutline, pencilSharp} from 'ionicons/icons'

import api from '@/api'

const router = useRouter()

interface Stadium {
  id: number
  stadium_name: string
  parent?: {
    location_name: string
  }
}

interface District {
  id: number
  district_name: string
}


const stadiums = ref<Stadium[]>([])
const districts = ref<District[]>([])
const loading = ref(false)

const stadium_name = ref(null)
const district_id = ref(null)
const stadiumsListKey = ref()

const feedbackMessage = ref(null)

const fetchData = async () => {

  loading.value = true

  try {

    const { data } = await api.get('/settings/stadiums', {
      params: {
        season_id: 2026
      }
    })

    
    stadiums.value = data.stadiums || []
    districts.value = data.districts || []


  } catch (err) {

    console.error(err)

  } finally {

    loading.value = false

  }

}


const createStadium = async () => {
  loading.value = true

  try {

    const { data } = await api.post('/settings/stadiums', {
      stadium_name: stadium_name.value,
      parent_id: district_id.value,
    })
    
    if(data.success){
      feedbackMessage.value = data.message || null
    }
    // Clear the form
    stadium_name.value = null
    district_id.value = null

    // Refresh the list
    await fetchData()

  } catch (error: any) {

    console.error(error.response?.data || error)

  } finally {

    loading.value = false

  }

}


const cancel = () =>{
  loading.value=false
  stadium_name.value = null
  district_id.value = null
  feedbackMessage.value = null
  router.replace({
    name: 'stadiums.index',
  });
}

onIonViewWillEnter(() => {
  fetchData()
  stadiumsListKey.value = Date.now()
})

</script>
