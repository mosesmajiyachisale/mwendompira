```vue
<template>
  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">

        <ion-buttons slot="start">
          <ion-back-button default-href="/settings" />
        </ion-buttons>

        <ion-title>
          Fields
        </ion-title>

      </ion-toolbar>
    </ion-header>


    <ion-content class="ion-padding">

      <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
          <h4 class="mb-0">
            Fields
          </h4>

          <small class="text-muted">
            Manage fields relevant to sports and management.
          </small>
        </div>

      </div>


      <FieldsList :key="seasonsListKey" />

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
  IonButton,
  IonIcon
} from '@ionic/vue'

import {
  add
} from 'ionicons/icons'
import { onIonViewWillEnter } from '@ionic/vue'
import FieldsList from './FieldsList.vue'
import { ref } from 'vue'

const seasonsListKey = ref(0)
onIonViewWillEnter(()=>{
  seasonsListKey.value = Date.now()
})
</script>
```
