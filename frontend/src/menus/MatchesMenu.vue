<template>
  <ion-accordion value="matches">

    <ion-item slot="header" color="dark">
      <ion-icon :icon="shieldCheckmark" slot="start"></ion-icon>
      <ion-label>Matches</ion-label>
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
          <ion-label>Fixtures</ion-label>
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
          <ion-label>Results</ion-label>
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
          <ion-label>Lineups</ion-label>
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
    <ion-label>Events</ion-label>
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
    <ion-label>Performances</ion-label>
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