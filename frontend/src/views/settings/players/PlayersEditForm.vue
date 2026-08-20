<template>

    <form
      @submit.prevent="saveChanges"
      class="card p-3 mb-3 bg-light"
    >
  
      <div v-if="loadingPlayer" class="text-center py-3">
        Loading player...
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
  
            Save Changes
  
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
  
  
  const route = useRoute()
  const router = useRouter()
  
  
  const loading = ref(false)
  const loadingPlayer = ref(true)
  
  
const today = new Date()
const currentYear =today.getFullYear()
const minAge = 10;
const maxAge = 35;
const startYear = currentYear - maxAge
const endYear = currentYear - minAge
  
  
  interface PersonForm {
  
    first_name: string
  
    middle_name: string | null
  
    last_name: string
  
    gender: 'Male' | 'Female' | null
  
    dob: string | null
  
    location_id: number | null
  
  }
  
  
  interface FormData {
  
    person: PersonForm
  
    player_code: number | null
  
    preferred_name: string | null
  
    preferred_foot: 'Both' | 'Left' | 'Right'
  
    height_cm: number | null
  
  }
  
  
  const formData = reactive<FormData>({
  
    person: {
  
      first_name: '',
  
      middle_name: null,
  
      last_name: '',
  
      gender: null,
  
      dob: null,
  
      location_id: null
  
    },
  
    player_code: null,
  
    preferred_name: null,
  
    preferred_foot: 'Right',
  
    height_cm: null
  
  })
  
  
  /*
  |--------------------------------------------------------------------------
  | Player ID
  |--------------------------------------------------------------------------
  */
  
  const playerId = Number(route.params.id)
  
  
  /*
  |--------------------------------------------------------------------------
  | Load Player
  |--------------------------------------------------------------------------
  */
  
  async function fetchData() {
    loadingPlayer.value = true
    try {
      const { data } = await api.get(`/settings/players/${playerId}`)
      const player = data.selectedPlayer || null
      if (!player) {
        console.error('Player not found')
        return
      }

      const person = player.person
  
      formData.person.first_name =person?.first_name ?? ''
      formData.person.middle_name =person?.middle_name ?? null
      formData.person.last_name =person?.last_name ?? ''
      formData.person.gender =person?.gender ?? null
      formData.person.dob =person?.dob ?? null
      formData.person.location_id =person?.location_id ?? null
      formData.player_code = player.player_code ?? null
      formData.preferred_name =player.preferred_name ?? null
      formData.preferred_foot =player.preferred_foot ?? 'Right'
      formData.height_cm =player.height_cm !== null &&player.height_cm !== undefined ? Number(player.height_cm) : null
  
    }
    catch (error: any) {
  
      console.error(
        'PLAYER LOAD ERROR:',
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
  
      loadingPlayer.value = false
  
    }
  
  }
  
  
  /*
  |--------------------------------------------------------------------------
  | Save Changes
  |--------------------------------------------------------------------------
  */
  
  async function saveChanges() {  
    loading.value = true
    try {
        const payload = {
            person: {
            first_name:formData.person.first_name.trim(),
            middle_name:formData.person.middle_name?.trim() || null,
            last_name:formData.person.last_name.trim(),
            gender:formData.person.gender || null,
            dob:formData.person.dob || null,
            location_id:formData.person.location_id || null      
            },
            player_code: formData.player_code || null,
            preferred_name: formData.preferred_name?.trim() || null,
            preferred_foot: formData.preferred_foot || 'Right',
            height_cm:  formData.height_cm !== null && 
                        formData.height_cm !== undefined &&
                        formData.height_cm !== 0 ? Number(formData.height_cm) : null
        }
 
        
      const { data } = await api.put(`/settings/players/${playerId}`,payload)
  
        if (data.success) {
            router.replace({
                name: 'players.index',
                query: {
                    search:
                    data?.selectedPlayer?.person?.last_name ?? undefined
                }
            })
        }
  
    }
    catch (error: any) {
      console.error(
        'PLAYER UPDATE ERROR:',
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
  
  
  /*
  |--------------------------------------------------------------------------
  | Load immediately
  |--------------------------------------------------------------------------
  */
  
  fetchData()
  
  </script>