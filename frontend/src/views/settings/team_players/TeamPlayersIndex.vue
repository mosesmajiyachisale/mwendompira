<template>
    <ion-page>
      <ion-content
        color="light"
        :fullscreen="true"
        class="ion-no-padding"
      >
        <div class="app-page">
  
          <ion-toolbar class="page-toolbar">
            <ion-title>Team Players</ion-title>
          </ion-toolbar>
  
          <div class="page-content text-sm">
            <TeamPlayersList :key="TeamPlayersListKey" />
          </div>
  
        </div>
      </ion-content>
    </ion-page>
  </template>
  
  <script setup lang="ts">
  import {
    IonPage,
    IonContent,
    IonToolbar,
    IonTitle,
  } from '@ionic/vue'
  import { onIonViewWillEnter } from '@ionic/vue';
  import { ref } from 'vue';
  
  import TeamPlayersList from './TeamPlayersList.vue'
  
  
  const TeamPlayersListKey=ref(0)
  onIonViewWillEnter(()=>{
    TeamPlayersListKey.value++
  })
  </script>