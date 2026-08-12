```vue
<template>
  <form
    @submit.prevent="saveChanges"
    class="card p-3 mb-3"
  >

    <div class="row g-2 align-items-end">

      <!-- Field Name -->
      <div class="col-md-4 py-1 px-2">

        <div class="control-block">

          <label class="control-block-label">
            Name
          </label>

          <ion-input
            v-model="formData.field_name"
            placeholder="Enter Field Name"
            class="compact-input"
            :required="true"
          />

        </div>

      </div>


      <!-- Field Code -->
      <div class="col-md-2 py-1 px-2">

        <div class="control-block">

          <label class="control-block-label">
            Code
          </label>

          <ion-input
            v-model="formData.field_code"
            placeholder="Enter Field Code"
            class="compact-input"
            :required="true"
          />

        </div>

      </div>


      <!-- Description -->
      <div class="col-md-6 py-1 px-2">

        <div class="control-block">

          <label class="control-block-label">
            Description
          </label>

          <ion-input
            v-model="formData.field_desc"
            placeholder="Enter Field Description"
            class="compact-input"
          />

        </div>

      </div>


      <!-- Buttons -->
      <div class="col-md-4 d-flex gap-2">

        <ion-button
          type="submit"
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
          :router-link="{name:'fields.index'}"
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
  onIonViewWillEnter,
  IonInput,
  IonToggle,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'


const route = useRoute()
const router = useRouter()


const loading = ref(false)


const formData = reactive({

  field_name: '',

  field_code: '',

  field_desc: '',

  is_active: true

})


async function fetchData(){

  try {
    const fieldId = Number(route.params.id)
    const {data} = await api.get(`/settings/fields/${fieldId}/edit`)
    const field = data.selectedField
    formData.field_name = field?.field_name ?? ''
    formData.field_code = field?.field_code ?? ''
    formData.field_desc = field?.field_desc ?? ''
    formData.is_active = field?.is_active ?? true
  }
  catch(error:any){
    console.error(error.response?.data || error)
  }

}


async function saveChanges(){
  loading.value = true
  try {
    const fieldId = Number(route.params.id)

    const payload = {
      field_name: formData.field_name,
      field_code: formData.field_code,
      field_desc: formData.field_desc || null,
      is_active: formData.is_active
    }

    const {data} = await api.put(`/settings/fields/${fieldId}`,payload)
    router.replace({
      name: 'fields.index',
      query: {
        search:formData.field_name
      }
      })

  }
  catch(error:any){

    console.error(error.response?.data || error)

  }
  finally{
    loading.value = false
  }

}

fetchData()
</script>
```
