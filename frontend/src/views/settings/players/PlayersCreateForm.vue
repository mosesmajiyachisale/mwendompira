<template>
  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3 bg-light"
  >

    <div class="row g-2 align-items-end">

      <!-- First Name -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            First Name
          </label>

          <ion-input
            v-model="formData.person.first_name"
            placeholder="First Name"
            required
          />

        </div>
      </div>


      <!-- Middle Name -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Middle Name
          </label>

          <ion-input
            v-model="formData.person.middle_name"
            placeholder="Middle Name"
          />

        </div>
      </div>


      <!-- Last Name -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Last Name
          </label>

          <ion-input
            v-model="formData.person.last_name"
            placeholder="Last Name"
            required
          />

        </div>
      </div>
      
      <!-- Preferred Name -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Preferred Name
          </label>

          <ion-input
            v-model="formData.preferred_name"
            placeholder="Preferred Name"
          />

        </div>
      </div>



      <!-- Gender -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Gender
          </label>

          <ion-select
            v-model="formData.person.gender"
            interface="popover"
            placeholder="Select Gender"
            required
          >

            <ion-select-option value="Male">
              Male
            </ion-select-option>

            <ion-select-option value="Female">
              Female
            </ion-select-option>

          </ion-select>

        </div>
      </div>

      
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Date of Birth
          </label>
          <DateSelect
            v-model="formData.person.dob"
            :min-year="startYear"
            :max-year="endYear"
          />
        </div>
      </div>

      <!-- Height -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Height (cm)
          </label>

          <ion-input
            v-model="formData.height_cm"
            type="number"
            min="150"
            max="220"
            placeholder="Height"
          />

        </div>
      </div>


      <!-- Preferred Foot -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Preferred Foot
          </label>

          <ion-select
            v-model="formData.preferred_foot"
            interface="popover"
            placeholder="Select Foot"
            required
          >

            <ion-select-option value="Right">
              Right
            </ion-select-option>

            <ion-select-option value="Left">
              Left
            </ion-select-option>

            <ion-select-option value="Both">
              Both
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Player Code -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Player Code
          </label>

          <ion-input
            v-model="formData.player_code"
            type="number"
            placeholder="Player Code"
          />

        </div>
      </div>


      <!-- Buttons -->
      <div class="col-md-6 d-flex gap-2">

        <ion-button
          type="submit"
          size="small"
          :disabled="loading"
        >

          <ion-spinner
            v-if="loading"
            slot="start"
          />

          Save Player

        </ion-button>


        <ion-button
          type="button"
          color="warning"
          size="small"
          :router-link="{name:'players.index'}"
        >
          Cancel
        </ion-button>

      </div>

    </div>

  </form>
</template>


<script setup lang="ts">

import {
  reactive,
  ref
} from 'vue'

import {
  useRouter
} from 'vue-router'

import {
  IonInput,
  IonSelect,
  IonSelectOption,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'

import DateSelect from '@/components/DateSelect.vue'


const router=useRouter()
const loading=ref(false)

const today = new Date()
const currentYear =today.getFullYear()
const minAge = 10;
const maxAge = 35;
const startYear = currentYear - maxAge
const endYear = currentYear - minAge

const formData=reactive({
  person:{
    first_name:'',
    middle_name:'',
    last_name:'',
    gender:null as 'Male'|'Female'|null,
    dob:null as string|null,
    location_id:null as number|null
  },
  player_code:null as number|null,
  preferred_name:'',
  preferred_foot:'Right' as 'Both'|'Left'|'Right',
  height_cm: null
})

async function saveChanges(){
loading.value = true
try {
  const payload = {

    person: {
      first_name: formData.person.first_name.trim(),
      middle_name: formData.person.middle_name?.trim() || null,
      last_name: formData.person.last_name.trim(),
      gender: formData.person.gender || null,
      dob: formData.person.dob || null,
      location_id: formData.person.location_id || null,
    },

    player_code: formData.player_code || null,
    preferred_name: formData.preferred_name?.trim() || null,
    preferred_foot: formData.preferred_foot || 'Right',
    height_cm: formData.height_cm  ? Number(formData.height_cm) : null,
  }


  const { data } = await api.post('/settings/players',payload)

  if(data.success){

    router.replace({
      name: 'players.index',
      query: {
        search:
          data?.selectedPlayer?.person?.last_name
          ?? undefined
      }
    })

  }

}
catch(error:any){

  console.error('PLAYER SAVE ERROR:', error)

  console.error(
    'STATUS:',
    error.response?.status
  )

  console.error(
    'DATA:',
    error.response?.data
  )

  console.error(
    'MESSAGE:',
    error.message
  )

}
finally {

  loading.value = false

}

}

</script>