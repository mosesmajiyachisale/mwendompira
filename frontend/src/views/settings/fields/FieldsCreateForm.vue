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
      <div class="col-md-4 py-1 px-2">

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
      <div class="col-md-2 d-flex gap-2">

        <ion-button
          type="submit"
          :disabled="loading"
        >

          <ion-spinner
            v-if="loading"
            slot="start"
          />

          Save

        </ion-button>


        <ion-button
          type="button"
          color="warning"
          :router-link="{
            name:'fields.index'
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
  useRouter
} from 'vue-router'

import {
  IonInput,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'


const router = useRouter()


const loading =
  ref(false)


const formData =
  reactive({

    field_name: '',

    field_code: '',

    field_desc: ''

  })


async function saveChanges() {
  loading.value = true
  try {
    const payload = {
      field_name: formData.field_name,
      field_code: formData.field_code,
      field_desc: formData.field_desc || null
    }

    const { data } = await api.post('/settings/fields',payload)

    if (data.success) {
      router.replace({
        name: 'fields.index',
        query: {
          search:formData.field_name
        }
      })
    }
  }
  catch (error: any) {
    console.error(error.response?.data || error)
  }
  finally {
    loading.value = false
  }

}

</script>
```
