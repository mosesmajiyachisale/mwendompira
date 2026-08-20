<template>
  <ion-page>
    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>New Team</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">

          <TeamsCreateForm />

          <TeamsList :key="teamsListKey"/>

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

import TeamsCreateForm from './TeamsCreateForm.vue'
import TeamsList from './TeamsList.vue'


const teamsListKey=ref(0)


onIonViewWillEnter(()=>{

  teamsListKey.value=Date.now()

})

</script>