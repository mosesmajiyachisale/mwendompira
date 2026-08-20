<template>
  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">

        <ion-title>
          Qualifications
        </ion-title>

      </ion-toolbar>
    </ion-header>


    <ion-content class="ion-padding">

      <div
        class="d-flex justify-content-between align-items-center mb-3"
      >

        <div>
          <h4 class="mb-1">
            Qualifications
          </h4>

          <p class="text-muted mb-0">
            Manage academic and professional qualifications.
          </p>
        </div>


        <ion-button
          color="primary"
          :routerLink="{
            name: 'qualifications.create'
          }"
        >

          <ion-icon
            slot="start"
            :icon="addOutline"
          />

          Add Qualification

        </ion-button>

      </div>


      <QualificationsList />

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
  IonButton,
  IonIcon
} from '@ionic/vue'

import {
  addOutline
} from 'ionicons/icons'

import QualificationsList
  from './QualificationsList.vue'

</script>