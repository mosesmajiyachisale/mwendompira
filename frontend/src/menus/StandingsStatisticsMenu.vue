<template>
  <ion-accordion value="standingsstatistics">

    <ion-item slot="header" color="dark">
      <ion-icon :icon="shieldCheckmark" slot="start"></ion-icon>
      <ion-label>Standings & Statistics</ion-label>
    </ion-item>

    <div slot="content">

      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'users.index' }"
          :color="isActive('users.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('users.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="people" slot="start"></ion-icon>
          <ion-label>Standings</ion-label>
        </ion-item>
      </ion-menu-toggle>


      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'roles.index' }"
          :color="isActive('roles.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('roles.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="personCircle" slot="start"></ion-icon>
          <ion-label>Player Statistics</ion-label>
        </ion-item>
      </ion-menu-toggle>


      <ion-menu-toggle :auto-hide="true">
        <ion-item
          button
          :routerLink="{ name: 'permissions.index' }"
          :color="isActive('permissions.index') ? 'lighter-dark' : 'light-dark'"
          :class="[
            'submenu-item',
            isActive('permissions.index') ? 'submenu-item-active' : ''
          ]"
        >
          <ion-icon :icon="key" slot="start"></ion-icon>
          <ion-label>Team Statistics</ion-label>
        </ion-item>
      </ion-menu-toggle>

    </div>

  </ion-accordion>
</template>


<script setup lang="ts">
import { useRoute } from 'vue-router'

import {
  IonAccordion,
  IonItem,
  IonLabel,
  IonIcon,
  IonMenuToggle
} from '@ionic/vue'

import {
  shieldCheckmark,
  people,
  personCircle,
  key
} from 'ionicons/icons'


const route = useRoute()

const isActive = (name: string) => route.name === name
</script>