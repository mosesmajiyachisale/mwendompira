<template>
  <form @submit.prevent="saveChanges" class="card p-3 mb-3">
    <div class="row g-2 align-items-end">
        
      <div class="col-md-3 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Sponsor Name
          </label>
          <ion-input
            v-model="formData.sponsor_name"
            placeholder="Enter Sponsor Name"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>
      
      <div class="col-md-2 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Code
          </label>
          <ion-input
            v-model="formData.sponsor_code"
            placeholder="Enter Sponsor Code"
            class="compact-input"
            :required="true"
          />
        </div>
      </div>

      <div class="col-md-4 py-1 px-2">
        <div class="control-block">
          <label class="control-block-label">
            Description
          </label>
          <ion-input
            v-model="formData.sponsor_desc"
            placeholder="Enter Sponsor Description"
            class="compact-input"
          />
        </div>
      </div>


      <div class="col-md-3 d-flex gap-2">
        <ion-button type="submit" :disabled="loading">
          <ion-spinner v-if="loading" slot="start"/>
          Save Changes
        </ion-button>
        
        <ion-button type="button" color="warning" :router-link="{name:'sponsors.index'}">
          Cancel
        </ion-button>
      </div>

    </div>
  </form>
</template>

<script setup lang="ts">
import {reactive,ref} from 'vue'
import {onIonViewWillEnter} from '@ionic/vue'
import {useRouter} from 'vue-router'

import {
  IonInput,
  IonButton,
  IonSpinner
} from '@ionic/vue'

import api from '@/api'

const router=useRouter()

const loading=ref(false)

const formData=reactive({
  sponsor_name:'',
  sponsor_code:'',
  sponsor_desc:''
})

async function fetchData(){

  try{

    await api.get('/settings/sponsors')

  }
  catch(error:any){

    console.error(
      error.response?.data || error
    )

  }

}

async function saveChanges(){

  loading.value=true

  try{

    const payload={

      sponsor_name:
        formData.sponsor_name,

      sponsor_code:
        formData.sponsor_code || null,

      sponsor_desc:
        formData.sponsor_desc || null

    }

    const {data}=await api.post(
      '/settings/sponsors',
      payload
    )

    if(data.success){

      router.replace({

        name:'sponsors.index',

        query:{
          search:formData.sponsor_name
        }

      })

    }

  }
  catch(error:any){

    console.error(
      error.response?.data || error
    )

  }
  finally{

    loading.value=false

  }

}

fetchData()
</script>