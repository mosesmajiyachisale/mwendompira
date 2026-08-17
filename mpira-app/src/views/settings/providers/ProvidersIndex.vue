<template>
  <ion-page>
    <ion-content
      color="light"
      :fullscreen="true"
      class="ion-no-padding"
    >
      <div class="app-page">

        <ion-toolbar class="page-toolbar">
          <ion-title>Providers</ion-title>
        </ion-toolbar>

        <div class="page-content text-sm">
          <ProvidersList :key="providersListKey" />
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

import ProvidersList from './ProvidersList.vue'


const providersListKey=ref(0)
onIonViewWillEnter(()=>{
  providersListKey.value++
})
</script>