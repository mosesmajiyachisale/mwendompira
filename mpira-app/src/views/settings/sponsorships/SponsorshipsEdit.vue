<template>
    <ion-page>
  
      <ion-content
        color="light"
        class="ion-no-padding"
      >
  
        <div class="app-page">
  
  
          <ion-toolbar class="page-toolbar">
  
            <ion-title>
              Edit Sponsorship
            </ion-title>
  
          </ion-toolbar>
  
  
  
          <div class="page-content text-sm">
  
  
            <SponsorshipsEditForm />
  
  
            <SponsorshipsList
              :key="sponsorshipsListKey"
            />
  
  
          </div>
  
  
        </div>
  
  
      </ion-content>
  
  
    </ion-page>
  </template>
  
  
  
  <script setup lang="ts">
  
  import {ref} from 'vue'
  
  import {
    onIonViewWillEnter
  } from '@ionic/vue'
  
  
  import {
    IonPage,
    IonContent,
    IonToolbar,
    IonTitle
  } from '@ionic/vue'
  
  
  import SponsorshipsEditForm from './SponsorshipsEditForm.vue'
  
  import SponsorshipsList from './SponsorshipsList.vue'
  
  
  
  const sponsorshipsListKey=ref(0)
  
  
  
  onIonViewWillEnter(()=>{
  
    sponsorshipsListKey.value=Date.now()
  
  })
  
  
  </script>