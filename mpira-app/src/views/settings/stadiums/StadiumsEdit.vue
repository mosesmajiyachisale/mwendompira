<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">
        <ion-toolbar class="page-toolbar">
          <ion-title>Edit Stadiums</ion-title>
        </ion-toolbar>
        <div class="page-content md:text-sm">
          <StadiumsEditForm />          
          <StadiumsList :key="stadiumsListKey" />
        </div>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { onIonViewDidEnter, onIonViewWillEnter } from '@ionic/vue'
import { useRoute } from 'vue-router'
import {
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle,
  IonButtons,
  IonButton,
  IonIcon
} from '@ionic/vue'
import { arrowBack } from 'ionicons/icons'
import api from '@/api'
import StadiumsEditForm from './StadiumsEditForm.vue'
import StadiumsList from './StadiumsList.vue'

const route = useRoute()

interface Stadium {
  id:number
  location_name:string
  parent_id:number|null
  parent?:{
    location_name:string
  }
}

interface District {
  id:number
  district_name:string
}

const stadiums = ref<Stadium[]>([])
const districts = ref<District[]>([])
const selectedStadium = ref<Stadium | null>(null)
const loading = ref(false)
const stadiumsListKey = ref()

onIonViewWillEnter(()=>{
  stadiumsListKey.value = Date.now()
})
</script>