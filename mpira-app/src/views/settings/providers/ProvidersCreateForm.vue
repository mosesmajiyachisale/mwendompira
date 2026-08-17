<template>
  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3 bg-light"
  >

    <div class="row g-2 align-items-end">


      <!-- =====================================================
           PERSON
           ===================================================== -->

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


      <!-- =====================================================
           PROVIDER
           ===================================================== -->

      <!-- Provider Type -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Provider Type
          </label>

          <ion-select
            v-model="formData.provider_type_id"
            interface="popover"
            placeholder="Select Provider Type"
            required
          >

            <ion-select-option
              v-for="type in provider_types"
              :key="type.id"
              :value="type.id"
            >
              {{ type.provider_type_name }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>


      <!-- Provider Code -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Provider Code
          </label>

          <ion-input
            v-model="formData.provider_code"
            type="number"
            placeholder="Provider Code"
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

            <ion-select-option :value="null">
              None
            </ion-select-option>

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


      <!-- Season Started -->
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">

          <label class="control-block-label">
            Season Started
          </label>

          <ion-select
            v-model="formData.season_started"
            interface="popover"
            placeholder="Select Season"
          >

            <ion-select-option :value="null">
              Not Specified
            </ion-select-option>

            <ion-select-option
              v-for="season in seasons"
              :key="season.id"
              :value="season.id"
            >
              {{ season.season_code }}
            </ion-select-option>

          </ion-select>

        </div>
      </div>

      <!-- =====================================================
           BUTTONS
           ===================================================== -->

      <div class="col-md-6 d-flex gap-2 py-1 px-2">

        <ion-button
          type="submit"
          size="small"
          :disabled="loading"
        >

          <ion-spinner
            v-if="loading"
            slot="start"
          />

          Save Provider

        </ion-button>


        <ion-button
          type="button"
          color="warning"
          size="small"
          :router-link="{ name: 'providers.index' }"
        >
          Cancel
        </ion-button>

      </div>

    </div>

  </form>
</template>


<script setup lang="ts">

import {
  onMounted,
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


// ================================================================
// ROUTER / LOADING
// ================================================================

const router = useRouter()

const loading = ref(false)


// ================================================================
// DATE RANGE
// ================================================================

const today = new Date()

const currentYear = today.getFullYear()

const minAge = 18
const maxAge = 80

const startYear = currentYear - maxAge
const endYear = currentYear - minAge


// ================================================================
// LOOKUPS
// ================================================================

const provider_types = ref<any[]>([])
const qualifications = ref<any[]>([])
const seasons = ref<any[]>([])

// ================================================================
// FORM DATA
// ================================================================

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


// ================================================================
// LOAD LOOKUPS
// ================================================================

async function fetchData() {
  try {
    const { data } = await api.get('/settings/providers')

    provider_types.value = data?.provider_types || []
    qualifications.value = data?.qualifications || []
    seasons.value = data?.seasons || []
  }
  catch (error) {
    console.error('PROVIDER TYPES LOAD ERROR:', error)
  }
}


// ================================================================
// SAVE
// ================================================================

async function saveChanges() {
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

      provider_code: formData.provider_code || null,
      preferred_name: formData.preferred_name?.trim() || null,
      professional_qualification_id: formData.professional_qualification_id || null,
      provider_type_id: formData.provider_type_id || null,
      season_started: formData.season_started || null,
      is_active: formData.is_active,
    }

    const { data } = await api.post('/settings/providers', payload )

    if (data.success) {
      router.replace({
        name: 'providers.index',
        query: {
          search: data?.selectedProvider?.person?.last_name || undefined
        }
      })
    }
  }
  catch (error: any) {

    console.error(
      'PROVIDER SAVE ERROR:',
      error
    )

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


// ================================================================
// INITIALIZE
// ================================================================
fetchData();

</script>