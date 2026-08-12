<template>
  <ion-app>

    <!-- Sidebar Menu -->
    <Sidebar />

    <!-- Main Layout -->
    <ion-page id="main-content">

      <!-- App Header -->
      <AppHeader />

      <!-- Page Content -->
      <ion-router-outlet />

      <!-- App Footer -->
      <AppFooter />

    </ion-page>

  </ion-app>
</template>

<script setup lang="ts">
import { IonApp, IonPage, IonRouterOutlet } from '@ionic/vue'

import Sidebar from './menus/Sidebar.vue'
import AppHeader from './components/AppHeader.vue'
import AppFooter from './components/AppFooter.vue'
</script>

<style scoped>

</style>