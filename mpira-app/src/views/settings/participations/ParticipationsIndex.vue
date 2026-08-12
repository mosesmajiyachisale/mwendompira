<template>
    <ion-page>
  
      <ion-content
        color="light"
        class="ion-no-padding"
      >
  
        <div class="app-page">
  
          <ion-toolbar class="page-toolbar">
  
            <ion-title>
              Participations
            </ion-title>
  
          </ion-toolbar>
  
  
          <div class="page-content text-sm">
  
            <ParticipationsList
              :key="participationsListKey"
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
  
  import ParticipationsList from './ParticipationsList.vue'
  
  
  const participationsListKey=ref(0)
  
  
  onIonViewWillEnter(()=>{
  
    participationsListKey.value++
  
  })
  
  </script>