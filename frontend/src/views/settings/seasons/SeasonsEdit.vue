<template>
  <ion-page>

    <ion-content color="light" class="ion-no-padding">

      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>
            Edit Season
          </ion-title>
        </ion-toolbar>


        <div class="page-content text-sm">

          <SeasonsEditForm />

          <SeasonsList
            :key="seasonsListKey"
            :seasons="seasons"
            :loading="loading"
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


import {arrowBack} from 'ionicons/icons'

import SeasonsEditForm from './SeasonsEditForm.vue'
import SeasonsList from './SeasonsList.vue'

import api from '@/api'


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

const seasonsListKey = ref(0)



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



onIonViewWillEnter(()=>{
  seasonsListKey.value = Date.now()
})

</script>