<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <ion-searchbar
        v-model="search"
        placeholder="Search season..."
        :debounce="300"
      />

      <ion-select
        v-model="perPage"
        interface="popover"
        class="ion-no-padding"
        style="width:120px"
      >
        <ion-select-option :value="5">
          5 rows
        </ion-select-option>

        <ion-select-option :value="10">
          10 rows
        </ion-select-option>

        <ion-select-option :value="25">
          25 rows
        </ion-select-option>

        <ion-select-option :value="50">
          50 rows
        </ion-select-option>
      </ion-select>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
          <tr>
            <th>#</th>

            <th
              role="button"
              @click="sortBy('season_code')"
            >
              Season {{ sortIcon('season_code') }}
            </th>

            <th>
              Start Date {{ sortIcon('start_date') }}
            </th>

            <th>
              End Date {{ sortIcon('end_date') }}
            </th>

            <th>
              Active
            </th>

            <th></th>
          </tr>
        </thead>

        <tbody>

          <tr v-if="loading">
            <td
              colspan="7"
              class="text-center"
            >
              Loading seasons...
            </td>
          </tr>

          <tr v-else-if="paginatedSeasons.length===0">
            <td
              colspan="7"
              class="text-center"
            >
              No seasons found.
            </td>
          </tr>

          <tr
            v-for="(season,index) in paginatedSeasons"
            :key="season.id"
          >
            <td>
              {{ start + index + 1 }}
            </td>

            <td>
              {{ season.season_code }}
            </td>

            <td>
              {{ formatDate(season.start_date) }}
            </td>

            <td>{{ formatDate(season.end_date) }}
            </td>

            <td>
              {{ season.is_active ? 'Yes' : 'No' }}
            </td>

            <td class="text-end">
              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'seasons.edit',
                  params:{
                    id:season.id
                  }
                }"
              >
                <ion-icon
                  slot="start"
                  :icon="pencilSharp"
                />
                Edit
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
          :disabled="page===1"
          @click="page--"
        >
          Previous
        </ion-button>

        <span class="mx-2">
          {{ page }} / {{ pages }}
        </span>

        <ion-button
          size="small"
          :disabled="page===pages"
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
import {
  computed,
  ref,
  watch
} from 'vue'

import {
  useRoute
} from 'vue-router'

import {
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import {
  pencilSharp
} from 'ionicons/icons'

import api from '@/api'

interface Season{
  id:number
  season_code:string
  start_date:string|null
  end_date:string|null
  status:'upcoming'|'active'|'finished'
  is_active:boolean
}

type SortColumn =
  | 'season_code'
  | 'start_date'
  | 'end_date'
  | 'status'

const route = useRoute()

const seasons = ref<Season[]>([])
const loading = ref(false)

const search = ref(
  typeof route.query.search === 'string'
    ? route.query.search
    : ''
)

const page = ref(1)

const perPage = ref(10)

const sortColumn = ref<SortColumn>(
  'season_code'
)

const sortDirection = ref<'asc'|'desc'>(
  'desc'
)

async function fetchData(){

  loading.value = true

  try{

    const {data} = await api.get('/settings/seasons')

    seasons.value = data.seasons ?? []

  }
  catch(error){

    console.error(error)

  }
  finally{

    loading.value = false

  }

}

watch(
  [search,perPage],
  ()=>{
    page.value = 1
  }
)

watch(
  ()=>route.query.search,
  value=>{

    search.value =
      typeof value === 'string'
        ? value
        : ''

  },
  {
    immediate:true
  }
)

const filtered = computed(()=>{

  let rows = [...seasons.value]

  if(search.value){

    const q = search.value.toLowerCase()

    rows = rows.filter(season=>

      season.season_code
        .toLowerCase()
        .includes(q)

      ||

      (season.start_date ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (season.end_date ?? '')
        .toLowerCase()
        .includes(q)

      ||

      season.status
        .toLowerCase()
        .includes(q)

    )

  }

  rows.sort((a,b)=>{

    let x = ''
    let y = ''

    switch(sortColumn.value){

      case 'season_code':
        x = a.season_code
        y = b.season_code
        break

      case 'start_date':
        x = a.start_date ?? ''
        y = b.start_date ?? ''
        break

      case 'end_date':
        x = a.end_date ?? ''
        y = b.end_date ?? ''
        break

      case 'status':
        x = a.status
        y = b.status
        break

    }

    const result = x.localeCompare(y)

    return sortDirection.value==='asc'
      ? result
      : -result

  })

  return rows

})

const pages = computed(()=>

  Math.max(
    1,
    Math.ceil(
      filtered.value.length /
      perPage.value
    )
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

const start = computed(()=>

  (page.value-1) *
  perPage.value

)

const paginatedSeasons = computed(()=>

  filtered.value.slice(
    start.value,
    start.value + perPage.value
  )

)

function sortBy(
  column:SortColumn
){

  if(sortColumn.value===column){

    sortDirection.value =
      sortDirection.value==='asc'
        ? 'desc'
        : 'asc'

  }
  else{

    sortColumn.value = column
    sortDirection.value = 'asc'

  }

}

function sortIcon(
  column:SortColumn
){

  if(sortColumn.value!==column){

    return ''

  }

  return sortDirection.value==='asc'
    ? '▲'
    : '▼'

}

function formatDate(date:string|null){
  if(!date){
    return ''
  }
  return new Date(date).toLocaleDateString('en-GB',
    {
      day:'numeric',
      month:'short',
      year:'numeric'
    }
  )
}

fetchData()
</script>