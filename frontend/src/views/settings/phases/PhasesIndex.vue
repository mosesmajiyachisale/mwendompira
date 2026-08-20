<template>
  <ion-page>
      <ion-content color="light" class="ion-no-padding">

          <div class="app-page">

              <ion-toolbar class="page-toolbar">
                  <ion-title>Phases</ion-title>
              </ion-toolbar>


              <div class="page-contentg text-sm">
                  <!-- =================================================
                       PHASES
                       ================================================= -->
                  <div class="row mx-0">

                      <div class="col-md-12">

                          <PhasesList
                              :key="phasesListKey"
                          />

                      </div>

                  </div>

              </div>

          </div>

      </ion-content>

  </ion-page>
</template>


<script setup lang="ts">

import { ref } from 'vue'
import { onIonViewWillEnter } from '@ionic/vue'

import {
  IonPage,
  IonContent,
  IonToolbar,
  IonTitle
} from '@ionic/vue'

import PhasesList from './PhasesList.vue'
import StagesList from '../stages/StagesIndex.vue'


const phasesListKey = ref(0)
const stagesListKey = ref(0)


onIonViewWillEnter(() => {

  phasesListKey.value = Date.now()
  stagesListKey.value = Date.now() + 1

})

</script>

<style scoped>

</style>