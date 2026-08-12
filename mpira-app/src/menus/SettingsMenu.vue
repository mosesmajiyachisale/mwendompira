<template>
  <!-- Settings menu -->
  <ion-accordion value="settings">

    <ion-item slot="header" color="dark">
      <ion-icon :icon="settingsOutline" slot="start"></ion-icon>
      <ion-label>Settings</ion-label>
    </ion-item>


    <div slot="content">


      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'sponsors.index' }"
          :color="isActive('sponsors.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('sponsors.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="briefcaseOutline" slot="start"></ion-icon>
          <ion-label>Sponsors</ion-label>
        </ion-item>
      </ion-menu-toggle>
      

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'stadiums.index' }"
          :color="isActive('stadiums.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('stadiums.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="locationOutline" slot="start"></ion-icon>
          <ion-label>Stadiums</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'qualifications.index' }"
          :color="isActive('qualifications.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('qualifications.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="walkOutline" slot="start"></ion-icon>
          <ion-label>Qualifications</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'fields.index' }"
          :color="isActive('fields.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('fields.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="walkOutline" slot="start"></ion-icon>
          <ion-label>Fields</ion-label>
        </ion-item>
      </ion-menu-toggle>

    </div>

  </ion-accordion>
</template>


<script setup lang="ts">
import { useRoute } from 'vue-router'

import {
  IonMenuToggle,
  IonItem,
  IonLabel,
  IonAccordion,
  IonIcon
} from '@ionic/vue'

import {
  settingsOutline,
  calendarOutline,
  trophyOutline,
  businessOutline, businessSharp,storefrontOutline,
  logoUsd, diamondOutline,walletOutline, cashOutline,
  shieldOutline,personOutline,footballOutline,
  walkOutline,fitnessOutline,
  diamondSharp,
  manOutline,
  mapOutline,
  leafOutline,
  locationOutline,
  walletSharp,
  briefcaseOutline,
  clipboardOutline,
  createOutline,
  personAddOutline
} from 'ionicons/icons'


const route = useRoute()

const isActive = (name: string) => route.name === name
</script>

<style scoped>
.player-icon {
  display: flex;
  align-items: center;
  gap: 0px;
  margin-inline-end: 0px;
}

.player-icon ion-icon {
  font-size: 18px;
}
</style>