<template>
  <ion-page>

    <ion-content
      color="light"
      class="ion-no-padding"
    >

      <div class="app-page">

        <ion-toolbar class="page-toolbar">

          <ion-title>
            Edit Coach
          </ion-title>

        </ion-toolbar>


        <div class="page-content text-sm">

          <CoachesEditForm />

          <CoachesList
            :key="coachesListKey"
          />

        </div>

      </div>

    </ion-content>

  </ion-page>
</template>


<script setup lang="ts">

import { ref } from 'vue'

import {
  onIonViewWillEnter,
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle
} from '@ionic/vue'

import CoachesEditForm from './CoachesEditForm.vue'
import CoachesList from './CoachesList.vue'


const coachesListKey = ref(0)


onIonViewWillEnter(() => {

  coachesListKey.value = Date.now()

})

</script>