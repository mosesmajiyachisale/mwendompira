<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>Tournaments</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">

          <TournamentsList
            :key="tournamentsListKey"
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

import TournamentsList from './TournamentsList.vue'

const tournamentsListKey = ref(0)

onIonViewWillEnter(()=>{

  tournamentsListKey.value = Date.now()

})
</script>