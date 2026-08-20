<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>Edit Tournament</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">

          <TournamentsEditForm />

          <TournamentsList :key="tournamentsListKey" />

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

import TournamentsEditForm from './TournamentsEditForm.vue'
import TournamentsList from './TournamentsList.vue'

const tournamentsListKey = ref<number>(0)

onIonViewWillEnter(() => {
  tournamentsListKey.value = Date.now()
})
</script>