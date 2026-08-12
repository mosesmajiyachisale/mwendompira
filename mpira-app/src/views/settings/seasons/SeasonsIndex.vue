<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>Seasons</ion-title>
        </ion-toolbar>


        <div class="page-content text-sm">
          <SeasonsList
            :key="seasonsListKey"
          />
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
  IonButtons,
  IonButton,
  IonIcon
} from '@ionic/vue'

import {add} from 'ionicons/icons'

import api from '@/api'
import SeasonsList from './SeasonsList.vue'


interface Season{

  id:number

  season_code:string

  start_date:string|null

  end_date:string|null

  status:string

  is_active:boolean

}


const seasons = ref<Season[]>([])

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


const seasonsListKey = ref(0)
onIonViewWillEnter(()=>{
  seasonsListKey.value = Date.now()
})
</script>