<template>
  <ion-menu content-id="main-content">

    <ion-header class="menu-header">
      <ion-toolbar color="dark" class="menu-toolbar">

        <ion-buttons slot="start">
          <ion-button @click="closeMenu" fill="clear">
            <ion-icon :icon="close" />
          </ion-button>
        </ion-buttons>

        <ion-title class="ion-no-padding">
          <Brand />
        </ion-title>

      </ion-toolbar>
    </ion-header>

    <ion-content color="dark">

      <ion-list lines="full" class="ion-no-padding">

        <ion-accordion-group :value="activeAccordion">
          
          <DashboardMenu></DashboardMenu>
          <CompetitionsMenu></CompetitionsMenu>
          <TeamsSquardsMenu></TeamsSquardsMenu>
          <MatchesMenu></MatchesMenu>
          <StandingsStatisticsMenu></StandingsStatisticsMenu>
          <SecurityMenu></SecurityMenu>
          <SettingsMenu></SettingsMenu>

        </ion-accordion-group>

      </ion-list>

    </ion-content>

  </ion-menu>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import {
  IonHeader,
  IonContent,
  IonToolbar,
  IonMenu,
  IonIcon,
  IonButton,
  IonButtons,
  IonList,
  IonAccordionGroup,
  IonTitle,
  menuController
} from '@ionic/vue'

import { close } from 'ionicons/icons'

import Brand from '@/components/Brand.vue'
import SecurityMenu from './SecurityMenu.vue'
import SettingsMenu from './SettingsMenu.vue'
import DashboardMenu from './DashboardMenu.vue'
import CompetitionsMenu from './CompetitionsMenu.vue'
import TeamsSquardsMenu from './TeamsSquardsMenu.vue'
import MatchesMenu from './MatchesMenu.vue'
import StandingsStatisticsMenu from './StandingsStatisticsMenu.vue'

const route = useRoute()

const activeAccordion = computed(() => {
  if (route.path.startsWith('/security')) {
    return 'security'
  }

  if (route.path.startsWith('/settings')) {
    return 'settings'
  }

  return undefined
})

const closeMenu = async () => {
  await menuController.close()
}
</script>