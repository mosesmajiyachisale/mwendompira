<template>
  <ion-header class="app-header">
    <ion-toolbar color="dark" class="app-toolbar">
      <ion-buttons slot="start">
        <ion-menu-button />
      </ion-buttons>

      <ion-title class="ion-no-padding">
        <Brand />
      </ion-title>
      
      <ion-title slot="end" class="ion-padding-end">
        <ion-button 
          fill="clear" 
          color="light"
          class="ion-no-padding"
          :routerLink="{ name: 'Home' }"
        >
          Home
        </ion-button>

        <ion-button 
          fill="clear" 
          color="light"
          class="ion-no-padding"
          :routerLink="{ name: 'Login' }"
        >
          Login
        </ion-button>
      </ion-title>
      
    </ion-toolbar>
    
  </ion-header>
</template>

<script setup lang="ts">
import {
  IonHeader,
  IonToolbar,
  IonMenuButton,
  IonButtons,
  IonButton,
  IonLabel,
  IonItem,
  IonTitle
} from '@ionic/vue'

import Brand from '@/components/Brand.vue'
</script>
