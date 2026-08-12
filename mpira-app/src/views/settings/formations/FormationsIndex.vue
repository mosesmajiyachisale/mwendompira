```vue
<template>

  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">
        <ion-title>
          Formation
        </ion-title>
      </ion-toolbar>
    </ion-header>


    <ion-content class="ion-padding">
      <div class="full-pitch">
        <div class="d-flex justify-between">

          <div class="mx-0 semi-pitch">
            <!-- =====================================================
          FORMATION SELECT
          ===================================================== -->
          <div class="control-block">
              <label class="control-block-label">
                Formation
              </label>

              <ion-select
                v-model="home_formation_id"
                interface="popover"
                placeholder="Select Formation"
                :required="true"
              >
                <ion-select-option
                  v-for="formation in formations"
                  :key="formation.id"
                  :value="formation.id"
                >
                  {{ formation.formation_name }}
                </ion-select-option>

              </ion-select>

            </div>
          </div>

          <div class="mx-0 semi-pitch">
            <!-- =====================================================
          FORMATION SELECT
          ===================================================== -->
          <div class="control-block">
              <label class="control-block-label">
                Formation
              </label>

              <ion-select
                v-model="away_formation_id"
                interface="popover"
                placeholder="Select Formation"
                :required="true"
              >
                <ion-select-option
                  v-for="formation in formations"
                  :key="formation.id"
                  :value="formation.id"
                >
                  {{ formation.formation_name }}
                </ion-select-option>

              </ion-select>

            </div>
          </div>

        </div>

      </div>
      
      <div class="full-pitch">
        <div class="d-flex justify-between">
          <div class="mx-0 mt-2 semi-pitch">
            <formations-home-team :formation_id="home_formation_id"></formations-home-team>
          </div>

          <div class="mx-0 mt-2 semi-pitch">
            <formations-away-team :formation_id="away_formation_id"></formations-away-team>
          </div>
        </div>
      </div>

    </ion-content>

  </ion-page>

</template>


<script setup lang="ts">
import { ref } from 'vue';
import api from '@/api.js';
import {
  onIonViewWillEnter,
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import FormationsHomeTeam from './FormationsHomeTeam.vue'
import FormationsAwayTeam from './FormationsAwayTeam.vue';

interface Slot {
  id: number
  slot_side: string
  slot_code: string
  slot_name: string
  grid_x: number
  grid_y: number
  slot_desc: string
  position_id: number
}

interface Formation {
  id: number
  formation_name: string
  formation_desc: string
  slots: Slot[]
}

const formations = ref<Formation[]>([])
const slots = ref<Slot[]>([])
const home_formation_id = ref<number | null>(null)
const away_formation_id = ref<number | null>(null)
const loading = ref(false)
  
const fetchData = async () => {
  loading.value = true
  try {
    const { data } =await api.get('/settings/formations')

    formations.value = data?.formations ?? []
    slots.value = data?.slots ?? []
    if (formations.value.length > 0) {
      if(home_formation_id.value === null){
        home_formation_id.value = formations.value[0].id
      }
      if(away_formation_id.value === null){
        away_formation_id.value = formations.value[0].id
      }
      slots.value = formations.value[0].slots ?? []
    }

  } catch (error) {
    console.error('Failed to load formations:',error)
  } finally {
    loading.value = false
  }
}


onIonViewWillEnter(() => {
  fetchData();
})
</script>

<style scoped>

  .semi-pitch{
    width: 50%;
  }

  .full-pitch{
  }

  @media (min-width: 1200px){
    .full-pitch{
      width: 50%;
    }
  }
  
  @media (min-width: 1000px) and (max-width:1200px){
    .full-pitch{
      width: 50%;
    }
  }
  
  @media (min-width: 800px) and (max-width:1000px){
    .full-pitch{
      width: 60%;
    }
  } 
  
  @media (min-width: 600px) and (max-width:800px){
    .full-pitch{
      width: 75%;
    }
  }  
  
  @media (max-width: 600px) {
    .full-pitch{
      width: 100%;
    }
  }
</style>
