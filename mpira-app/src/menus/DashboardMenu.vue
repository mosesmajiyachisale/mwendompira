<template>
  <ion-item
    button
    color="dark"
    :routerLink="{ name: 'Home' }"
    @click="closeMenu"
  >
    <ion-icon :icon="speedometerSharp" slot="start" />
    <ion-label>Dashboard</ion-label>
  </ion-item>
</template>

<script setup lang="ts">
import {
  IonItem,
  IonLabel,
  IonIcon,
  menuController
} from '@ionic/vue'

import {
  speedometerOutline, speedometerSharp
} from 'ionicons/icons'

const closeMenu = async () => {
  await menuController.close()
}
</script>