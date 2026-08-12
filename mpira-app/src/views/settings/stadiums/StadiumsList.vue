<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <ion-searchbar
        v-model="search"
        placeholder="Search stadium..."
        :debounce="300"
      />

      <ion-select
        v-model="perPage"
        interface="popover"
        class="ion-no-padding"
        style="width:120px"
      >
        <ion-select-option
          v-for="size in pageSizes"
          :key="size"
          :value="size"
        >
          {{ size }} rows
        </ion-select-option>
      </ion-select>
      
      <ion-buttons slot="end">
        <ion-button
          size="small"
          fill="solid"
          color="primary"
          :routerLink="{name:'stadiums.create'}"
        >
          <ion-icon
            slot="start"
            :icon="add"
          />
          New Stadium
        </ion-button>
      </ion-buttons>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th role="button" @click="sortBy('location_name')">
              Name {{ sortIcon('location_name') }}
            </th>
            <th role="button" @click="sortBy('district')">
              District {{ sortIcon('district') }}
            </th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="loading">
            <td colspan="4" class="text-center">
              Loading stadiums...
            </td>
          </tr>

          <tr v-else-if="paginatedStadiums.length === 0">
            <td colspan="4" class="text-center">
              No stadiums found.
            </td>
          </tr>

          <tr
            v-for="(stadium,index) in paginatedStadiums"
            :key="stadium.id"
          >
            <td>{{ start + index + 1 }}</td>

            <td>
              {{ stadium.location_name }}
            </td>

            <td>
              {{ stadium.parent?.location_name || '-' }}
            </td>

            <td>
              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'stadiums.edit',
                  params:{id:stadium.id}
                }"
              >
                Edit
                <ion-icon :icon="pencilSharp" slot="start"></ion-icon>
              </ion-button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
      <div>
        <ion-button
          size="small"
          :disabled="page <= 1"
          @click="page--"
        >
          Previous
        </ion-button>

        <span class="mx-2">
          {{ page }} / {{ pages }}
        </span>

        <ion-button
          size="small"
          :disabled="page >= pages"
          @click="page++"
        >
          Next
        </ion-button>
      </div>

      <div>
        Total: {{ filtered.length }}
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {computed,ref,watch,onMounted} from 'vue'
import { onIonViewDidEnter, onIonViewWillEnter } from '@ionic/vue'
import {useRoute,useRouter} from 'vue-router'
import {
  IonButtons,
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import {pencilSharp, add} from 'ionicons/icons'
import api from '@/api'

interface Stadium{
  id:number
  location_name:string
  parent?:{
    location_name:string
  }
}

type SortColumn = 'location_name'|'district'

const route = useRoute()
const router = useRouter()

const stadiums = ref<Stadium[]>([])
const loading = ref(false)

const pageSizes = [5,10,25,50]

const search = ref(String(route.query.search || ''))

const page = ref(
  Number(route.query.page || 1)
)

const perPage = ref(
  Number(route.query.perPage || 10)
)

const sortColumn = ref<SortColumn>('location_name')
const sortDirection = ref<'asc'|'desc'>('asc')


async function fetchData(){
  loading.value=true

  try{
    const {data}=await api.get('/settings/stadiums')
    stadiums.value=data.stadiums ?? []
  }
  catch(error){
    console.error(error)
  }
  finally{
    loading.value=false
  }
}




onIonViewWillEnter(() => {
  fetchData()
})(()=>{
  fetchData()
})

watch(
  () => route.query.search,
  (searchText) => {
    fetchData
  }
)


const filtered = computed(()=>{

  let rows=[...stadiums.value]

  if(search.value){

    const q=search.value.toLowerCase()

    rows=rows.filter(stadium=>
      stadium.location_name.toLowerCase().includes(q) ||
      (stadium.parent?.location_name || '')
        .toLowerCase()
        .includes(q)
    )
  }


  rows.sort((a,b)=>{

    const aValue =
      sortColumn.value==='location_name'
        ? a.location_name
        : a.parent?.location_name || ''

    const bValue =
      sortColumn.value==='location_name'
        ? b.location_name
        : b.parent?.location_name || ''

    const result=aValue.localeCompare(bValue)

    return sortDirection.value==='asc'
      ? result
      : -result
  })

  return rows
})


const pages = computed(()=>
  Math.max(
    1,
    Math.ceil(filtered.value.length/perPage.value)
  )
)

watch(
  pages,
  value=>{
    if(page.value>value){
      page.value=value
    }
  }
)

watch(
  () => route.query.search,
  (value) => {
    search.value = typeof value === 'string' ? value : ''
  },
  {
    immediate: true
  }
)

const start = computed(()=>
  (page.value-1)*perPage.value
)


const paginatedStadiums = computed(()=>
  filtered.value.slice(
    start.value,
    start.value+perPage.value
  )
)


function sortBy(column:SortColumn){

  if(sortColumn.value===column){

    sortDirection.value =
      sortDirection.value==='asc'
        ? 'desc'
        : 'asc'

  }else{

    sortColumn.value=column
    sortDirection.value='asc'

  }
}


function sortIcon(column:SortColumn){

  if(sortColumn.value!==column){
    return ''
  }

  return sortDirection.value==='asc'
    ? '▲'
    : '▼'
}
</script>