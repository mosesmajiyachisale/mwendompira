<template>
  <!-- Settings menu -->
  <ion-accordion value="teamssquads">

    <ion-item slot="header" color="dark">
      <ion-icon :icon="peopleOutline" slot="start"></ion-icon>
      <ion-label>Teams & Squads</ion-label>
    </ion-item>


    <div slot="content">

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'teams.index' }"
          :color="isActive('teams.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('teams.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="shieldOutline" slot="start"></ion-icon>
          <ion-label>Teams</ion-label>
        </ion-item>
      </ion-menu-toggle>

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'coaches.index' }"
          :color="isActive('coaches.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('coaches.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="manOutline" slot="start"></ion-icon>
          <ion-label>Coaches</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'providers.index' }"
          :color="isActive('providers.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('providers.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="manOutline" slot="start"></ion-icon>
          <ion-label>Providers</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'players.index' }"
          :color="isActive('players.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('players.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="walkOutline" slot="start"></ion-icon>
          <ion-label>Players</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'team_players.index' }"
          :color="isActive('team_players.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('team_players.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="shieldOutline" slot="start"></ion-icon>
          <ion-label>Squads</ion-label>
        </ion-item>
      </ion-menu-toggle>

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'positions.index' }"
          :color="isActive('positions.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('positions.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="manOutline" slot="start"></ion-icon>
          <ion-label>Positions</ion-label>
        </ion-item>
      </ion-menu-toggle>
      
      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'formations.index' }"
          :color="isActive('formations.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('formations.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="walkOutline" slot="start"></ion-icon>
          <ion-label>Formations</ion-label>
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
  calendarOutline,
  trophyOutline,
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
  personAddOutline,peopleOutline
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