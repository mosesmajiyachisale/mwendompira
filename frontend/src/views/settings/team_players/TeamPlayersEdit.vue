```vue
<template>
  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">

        <ion-buttons slot="start">
          <ion-back-button
            default-href="/settings/team-players"
          />
        </ion-buttons>

        <ion-title>
          New Team Player
        </ion-title>

      </ion-toolbar>
    </ion-header>


    <ion-content color="light">

      <div class="container-fluid py-3">

        <!-- =====================================================
             PAGE HEADER
             ===================================================== -->

        <div class="mb-3">

          <h4 class="mb-1">
            New Team Player
          </h4>

          <p class="text-muted mb-0">
            Register a player as a member of a team for a season.
          </p>

        </div>


        <!-- =====================================================
             CREATE FORM
             ===================================================== -->

        <TeamPlayersEditForm />


        <!-- =====================================================
             TEAM PLAYERS LIST
             ===================================================== -->

        <TeamPlayersList
          :key="teamPlayersListKey"
        />

      </div>

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
  onIonViewWillEnter
} from '@ionic/vue'

import {ref} from 'vue'

import TeamPlayersEditForm from './TeamPlayersEditForm.vue'
import TeamPlayersList from './TeamPlayersList.vue'

// ================================================================
// REFRESH LIST
// ================================================================

const teamPlayersListKey = ref(0)


onIonViewWillEnter(() => {

  teamPlayersListKey.value++

})

</script>
```
