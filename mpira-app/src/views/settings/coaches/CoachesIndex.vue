<template>
  <ion-page>

    <ion-content
      color="light"
      class="ion-no-padding"
    >

      <div class="app-page">

        <ion-toolbar class="page-toolbar">

          <ion-title>
            Coaches
          </ion-title>

        </ion-toolbar>

        <div class="page-content text-sm">

          <CoachesList :key="coachesListKey"i />

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
  IonTitle
} from '@ionic/vue'
import { onIonViewWillEnter } from '@ionic/vue';
import { ref } from 'vue';

import CoachesList from './CoachesList.vue'

const coachesListKey = ref(0)
  onIonViewWillEnter(() => {
    coachesListKey.value = Date.now()
  })
</script>