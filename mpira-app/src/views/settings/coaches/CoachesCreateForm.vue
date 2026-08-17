<template>

  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3 bg-light"
  >

    <div
      v-if="loading"
      class="text-center py-3"
    >
      Loading coach...
    </div>


    <div
      v-else
      class="row g-2 align-items-end"
    >

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


      <!-- Date of Birth -->
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


      <!-- Coach Code -->
      <div class="col-md-3 py-1 px-2">

        <div class="control-block">

          <label class="control-block-label">
            Coach Code
          </label>

          <ion-input
            v-model="formData.provider_code"
            type="number"
            placeholder="Coach Code"
          />

        </div>

      </div>


      <!-- Professional Qualification -->
      <div class="col-md-3 py-1 px-2">

        <div class="control-block">

          <label class="control-block-label">
            Professional Qualification
          </label>

          <ion-select
            v-model="formData.professional_qualification_id"
            interface="popover"
            placeholder="Select Qualification"
          >

            <ion-select-option
              v-for="qualification in qualifications"
              :key="qualification.id"
              :value="qualification.id"
            >
              {{ qualification.qualification_name }}
            </ion-select-option>

          </ion-select>

        </div>

      </div>


      <!-- Buttons -->
      <div class="col-md-6 d-flex gap-2">

        <ion-button
          type="submit"
          size="small"
          :disabled="saving"
        >

          <ion-spinner
            v-if="saving"
            slot="start"
          />

          Update Coach

        </ion-button>


        <ion-button
          type="button"
          color="warning"
          size="small"
          :router-link="{
            name: 'coaches.index'
          }"
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
  useRoute,
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


interface Qualification {
  id: number
  qualification_name: string
}


const route = useRoute()
const router = useRouter()


const loading = ref(false)
const saving = ref(false)


const qualifications =
  ref<Qualification[]>([])


  
const today = new Date()
const currentYear =today.getFullYear()
const minAge = 20;
const maxAge = 60;

const startYear = currentYear - maxAge
const endYear = currentYear - minAge

const formData = reactive({
  person: {
    first_name: '',
    middle_name: '',
    last_name: '',
    gender: null as 'Male' | 'Female' | null,
    dob: null as string | null,
    location_id: null as number | null
  },

  provider_code: null as number | null,
  preferred_name: '',
  professional_qualification_id: null as number | null,
  provider_type_id: null as number | null,
  season_started: null as number | null,
  is_active: true
})


/*
|--------------------------------------------------------------------------
| Coach ID
|--------------------------------------------------------------------------
*/

const coachId = Number(route.params.id)


/*
|--------------------------------------------------------------------------
| Load Coach
|--------------------------------------------------------------------------
*/

async function fetchData() {

  loading.value = true
  try {
    const { data } = await api.get(`/settings/coaches`)

    qualifications.value = data.qualifications ?? []
    
  }
  catch (error: any) {
    console.error('COACH LOAD ERROR:',error)
    console.error('STATUS:',error.response?.status)
    console.error('DATA:',error.response?.data)
    console.error('MESSAGE:',error.message)
  }
  finally {
    loading.value = false
  }

}


async function saveChanges() {

  saving.value = true
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

      provider_code: formData.provider_code || null,
      preferred_name: formData.preferred_name?.trim() || null,
      professional_qualification_id: formData.professional_qualification_id || null,
      provider_type_id: formData.provider_type_id || null,
      season_started: formData.season_started || null,
      is_active: formData.is_active,
    }


    const { data } = await api.post(`/settings/coaches`,payload)
    if (data?.success) {
      const selectedCoach = data.selectedCoach || null
      router.replace({
        name: 'coaches.index',
        query: {
          search: selectedCoach?.person?.last_name ?? undefined
        }
      })
    }
    
  }

  catch (error: any) {
    console.error('COACH UPDATE ERROR:',error)
    console.error('STATUS:',error.response?.status)
    console.error('DATA:',error.response?.data)
    console.error('MESSAGE:',error.message)
  }

  finally {
    saving.value = false
  }

}


/*
|--------------------------------------------------------------------------
| Initial load
|--------------------------------------------------------------------------
*/

fetchData()

</script>