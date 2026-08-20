<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="dark">
        <ion-buttons slot="start">
          <ion-back-button default-href="/settings/providers" />
        </ion-buttons>

        <ion-title>
          New Provider
        </ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content color="light">
      <div class="container-fluid py-3">

        <div class="mb-3">
          <h4 class="mb-1">
            Edit Provider
          </h4>

          <p class="text-muted mb-0">
            Register a person as a provider.
          </p>
        </div>

        <ProvidersEditForm />
        <ProvidersList :key="providersListKey"></ProvidersList>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonButtons,
  IonBackButton,
} from '@ionic/vue'
import { onIonViewWillEnter } from '@ionic/vue';
import { ref } from 'vue';

import ProvidersEditForm from './ProvidersEditForm.vue'
import ProvidersList from './ProvidersList.vue';

const providersListKey=ref(0)
onIonViewWillEnter(()=>{
  providersListKey.value++
})
</script>