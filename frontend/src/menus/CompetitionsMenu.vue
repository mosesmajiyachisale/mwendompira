<template>
  <!-- Settings menu -->
  <ion-accordion value="competitions">

    <ion-item slot="header" color="dark">
      <ion-icon :icon="trophySharp" slot="start"></ion-icon>
      <ion-label>Competitions</ion-label>
    </ion-item>


    <div slot="content">

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'seasons.index' }"
          :color="isActive('seasons.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('seasons.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="calendarOutline" slot="start"></ion-icon>
          <ion-label>Seasons</ion-label>
        </ion-item>
      </ion-menu-toggle>
      

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'tournaments.index' }"
          :color="isActive('tournaments.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('tournaments.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="trophyOutline" slot="start"></ion-icon>
          <ion-label>Tournaments</ion-label>
        </ion-item>
      </ion-menu-toggle>


      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'phases.index' }"
          :color="isActive('phases.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('phases.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="briefcaseOutline" slot="start"></ion-icon>
          <ion-label>Phases</ion-label>
        </ion-item>
      </ion-menu-toggle>

      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'sponsorships.index' }"
          :color="isActive('sponsorships.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('sponsorships.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="cashOutline" slot="start"></ion-icon>
          <ion-label>Sponsorships</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'participations.index' }"
          :color="isActive('participations.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('participations.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="createOutline" slot="start"></ion-icon>
          <ion-label>Participations</ion-label>
        </ion-item>
      </ion-menu-toggle>
      

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'stages.index' }"
          :color="isActive('stages.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('stages.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="locationOutline" slot="start"></ion-icon>
          <ion-label>Stages</ion-label>
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
  trophyOutline, trophySharp, pricetagOutline, 
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