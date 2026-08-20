<template>
  <ion-page>

    <ion-content color="light" class="ion-no-padding">

      <div class="app-page">

        <!-- Page Header -->
        <ion-toolbar class="page-toolbar">
          <ion-title>Stadiums</ion-title>
        </ion-toolbar>


        <!-- Table Content -->
        <div class="page-content text-sm">
          <!-- Stadium List  -->
          <StadiumsList :key="stadiumsListKey" />
        </div>
      </div>
    </ion-content>
  </ion-page>
</template>


<script setup lang="ts">

import { onUnmounted, ref } from 'vue'
import { onIonViewDidEnter, onIonViewWillEnter } from '@ionic/vue'
import {
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle,
  IonButtons,
  IonButton,
  IonIcon,
  IonLabel,
} from '@ionic/vue'

import {add,pencilOutline,pencilSharp} from 'ionicons/icons'
import StadiumsList from './StadiumsList.vue'

import api from '@/api'

interface Stadium {
  id:number
  location_name:string
  parent_id:number|null
  parent?:{
    location_name:string
  }
}

const stadiums = ref<Stadium[]>([])
const loading = ref(false)
const stadiumsListKey = ref()

onIonViewWillEnter(() => {
  stadiumsListKey.value = Date.now()
})
</script>
