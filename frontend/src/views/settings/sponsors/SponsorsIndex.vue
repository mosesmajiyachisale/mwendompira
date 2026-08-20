<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>Sponsors</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">
          <SponsorsList :key="sponsorsListKey" />
        </div>

      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { onIonViewWillEnter } from '@ionic/vue'

import {
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle,
  IonButtons,
  IonButton,
  IonIcon
} from '@ionic/vue'

import {
  add
} from 'ionicons/icons'

import api from '@/api'
import SponsorsList from './SponsorsList.vue'

interface Sponsor {
  id: number
  sponsor_name: string
  sponsor_code: string | null
  sponsor_desc: string | null
}


const sponsors = ref<Sponsor[]>([])

const loading = ref(false)

const fetchData = async()=>{

  loading.value = true

  try{

    const {data} = await api.get(
      '/settings/sponsors',
      {
        params:{
          season_id:2026
        }
      }
    )

    sponsors.value = data.sponsors ?? []

  }catch(err){

    console.error(err)

  }finally{

    loading.value = false

  }

}

// onIonViewWillEnter(fetchData)

const sponsorsListKey = ref(0)

onIonViewWillEnter(() => {
  sponsorsListKey.value = Date.now()
})
</script>