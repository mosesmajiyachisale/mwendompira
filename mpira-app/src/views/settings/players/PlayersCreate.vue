<template>
  <ion-page>

    <ion-content
      color="light"
      class="ion-no-padding"
    >

      <div class="app-page">

        <ion-toolbar class="page-toolbar">

          <ion-title>
            New Player
          </ion-title>

        </ion-toolbar>


        <div class="page-content text-sm">

          <PlayersCreateForm />

          <PlayersList
            :key="playersListKey"
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

import PlayersCreateForm from './PlayersCreateForm.vue'
import PlayersList from './PlayersList.vue'


const playersListKey=ref(0)


onIonViewWillEnter(()=>{

  playersListKey.value=Date.now()

})

</script>