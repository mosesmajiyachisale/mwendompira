<template>
    <a href="/home" class="brand"
      button
                    color="medium"
                    :router-link="{ name: 'users.index' }">
      <ion-icon
        :icon="football"
        color="light"
        size="large"
      />
      <span class="text-warning">Mwendo</span>
      <span class="text-success">mpira</span>
    </a>
  </template>
  
  <script setup lang="ts">
  import { IonIcon } from '@ionic/vue'
  import { footballOutline, footballSharp, football } from 'ionicons/icons'
  </script>
  
  <style scoped>
    .brand 
    {
      display: inline-flex;
      text-decoration: none;
      align-items: center;
      gap: 0;
      width: fit-content;
      font-family: "Montserrat", "Arial Black", sans-serif;
      font-style: italic;
      letter-spacing: 2px;
    }
    

    .brand ion-icon 
    {
        font-size: clamp(10px, 2vw, 20px);
        flex: 0 0 28px;
        margin: 0;
        padding: 0;
    }

    .brand span 
    {
        margin: 0;
        padding: 0;
        line-height: 1;
        font-size: clamp(10px, 2vw, 20px);
    }
  </style>