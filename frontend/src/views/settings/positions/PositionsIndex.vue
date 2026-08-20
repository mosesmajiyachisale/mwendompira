<template>
    <ion-page>
      <ion-content color="light" class="ion-no-padding">
        <div class="app-page">  
          <ion-toolbar class="page-toolbar">
            <ion-title>Positions</ion-title>
          </ion-toolbar>
          <div class="text-sm">
            <PositionsList :key="positionsListKey"></PositionsList>
          </div>
          <div class="slots-card pt-3">
            <PositionSlots :formation_id="formation_id"></PositionSlots>
          </div>
        </div>
      </ion-content>
    </ion-page>
  </template>
  
  
  <script setup lang="ts">
  import {ref} from 'vue'
  import {onIonViewWillEnter} from '@ionic/vue'
  
  import {
    IonPage,
    IonContent,
    IonToolbar,
    IonTitle,
  } from '@ionic/vue'
  
  import {add} from 'ionicons/icons'
  
  import api from '@/api'
  import PositionsList from './PositionsList.vue'
  import PositionSlots from '../formations/PositionSlots.vue'
  
  
  interface Season{
  
    id:number
  
    season_code:string
  
    start_date:string|null
  
    end_date:string|null
  
    status:string
  
    is_active:boolean
  
  }
  
  
  const seasons = ref<Season[]>([])
  const formation_id = ref(null)
  const loading = ref(false)
  
  
  async function fetchData(){
  
    loading.value=true
  
    try{
  
      const {data}=await api.get(
        '/settings/seasons'
      )
  
  
      seasons.value =
        data.seasons ?? []
  
  
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
  
  
  const positionsListKey = ref(0)
  onIonViewWillEnter(()=>{
    positionsListKey.value = Date.now()
  })
  </script>

<style scoped>


/* Tablet and larger */
@media (min-width: 768px) {

    .slots-card {
        width: 45% !important;
        margin: 0 0 0.5rem 0 !important;
    }

}
</style>