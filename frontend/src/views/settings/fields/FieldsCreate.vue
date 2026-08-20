```vue
<template>
  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">

        <ion-buttons slot="start">
          <ion-back-button
            default-href="/settings/fields"
          />
        </ion-buttons>

        <ion-title>
          New Field
        </ion-title>

      </ion-toolbar>
    </ion-header>


    <ion-content class="ion-padding">

      <FieldsCreateForm></FieldsCreateForm>
      <FieldsList></FieldsList>

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
  IonBackButton
} from '@ionic/vue'

import FieldsCreateForm from './FieldsCreateForm.vue'
import FieldsList from './FieldsList.vue';


</script>
```
