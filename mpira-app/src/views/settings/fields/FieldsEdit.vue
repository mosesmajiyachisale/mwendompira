```vue
<template>
  <ion-page>

    <ion-header>
      <ion-toolbar color="dark">

        <ion-buttons slot="start">
          <ion-back-button default-href="/settings/fields" />
        </ion-buttons>

        <ion-title>
          Edit Field
        </ion-title>

      </ion-toolbar>
    </ion-header>


    <ion-content class="ion-padding">

      <FieldsEditForm></FieldsEditForm>
      <FieldsList></FieldsList>

    </ion-content>

  </ion-page>
</template>


<script setup lang="ts">

import { ref } from 'vue'

import {
  useRoute,
  useRouter
} from 'vue-router'

import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonButtons,
  IonBackButton
} from '@ionic/vue'

import api from '@/api'
import FieldsEditForm from './FieldsEditForm.vue'
import FieldsList from './FieldsList.vue'


interface Field {

  id:number

  field_name:string

  field_code:string

  field_desc:string|null

  is_active:boolean

}


const route = useRoute()
const router = useRouter()

const field = ref<Field | null>(null)

const loading = ref(false)


async function fetchData(){

  loading.value = true

  try{

    const {data} = await api.get(
      `/settings/fields/${route.params.id}`
    )

    field.value = data.field

  }
  catch(error){

    console.error(error)

  }
  finally{

    loading.value = false

  }

}


function handleSaved(){

  router.push({
    name:'fields.index'
  })

}


fetchData()

</script>
```
