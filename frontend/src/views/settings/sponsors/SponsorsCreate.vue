<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>New Sponsor</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">

          <SponsorsCreateForm />

          <SponsorsList :key="sponsorsListKey" />

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

import SponsorsCreateForm from './SponsorsCreateForm.vue'
import SponsorsList from './SponsorsList.vue'

const sponsorsListKey = ref(0)

onIonViewWillEnter(() => {
  sponsorsListKey.value = Date.now()
})
</script>