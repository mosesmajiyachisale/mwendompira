<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <ion-searchbar
        v-model="search"
        placeholder="Search tournament..."
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
              :routerLink="{name:'tournaments.create'}"
            >
              <ion-icon
                slot="start"
                :icon="add"
              />
              New Tournament
            </ion-button>
          </ion-buttons>

    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
          <tr>
            <th>#</th>

            <th
              role="button"
              @click="sortBy('tournament_name')"
            >
              Name {{ sortIcon('tournament_name') }}
            </th>

            <th
              role="button"
              @click="sortBy('tournament_type')"
            >
              Type {{ sortIcon('tournament_type') }}
            </th>

            <th></th>
          </tr>
        </thead>

        <tbody>

          <tr v-if="loading">
            <td
              colspan="4"
              class="text-center"
            >
              Loading tournaments...
            </td>
          </tr>

          <tr v-else-if="paginatedTournaments.length===0">
            <td
              colspan="5"
              class="text-center"
            >
              No tournaments found.
            </td>
          </tr>

          <tr
            v-for="(tournament,index) in paginatedTournaments"
            :key="tournament.id"
          >
            <td>
              {{ start + index + 1 }}
            </td>

            <td>
              {{ tournament.tournament_name }}
            </td>

            <td>
              {{ tournament.tournament_type?.tournament_type_name || '-' }}
            </td>

            <td class="text-end">
              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'tournaments.edit',
                  params:{id:tournament.id}
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
          :disabled="page<=1"
          @click="page--"
        >
          Previous
        </ion-button>

        <span class="mx-2">
          {{ page }} / {{ pages }}
        </span>

        <ion-button
          size="small"
          :disabled="page>=pages"
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
import {computed,ref,watch
  
} from 'vue'


import {
  IonButtons,
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import {pencilSharp, add} from 'ionicons/icons'

import {
  useRoute
} from 'vue-router'

import api from '@/api'

interface Tournament{
  id:number
  tournament_name:string
  tournament_code:string|null
  tournament_type_id:number|null
  tournament_type?:{
    tournament_type_name:string
  }
}

type SortColumn =
  |'tournament_name'
  |'tournament_code'
  |'tournament_type'

const route=useRoute()

const tournaments=ref<Tournament[]>([])
const loading=ref(false)

const pageSizes=[5,10,25,50]

const search=ref(
  typeof route.query.search==='string'
    ? route.query.search
    : ''
)

const page=ref(1)

const perPage=ref(10)

const sortColumn=ref<SortColumn>('tournament_name')

const sortDirection=ref<'asc'|'desc'>('asc')

async function fetchData(){

  loading.value=true

  try{

    const {data}=await api.get(
      '/settings/tournaments'
    )

    tournaments.value=data.tournaments ?? []

  }
  catch(error){

    console.error(error)

  }
  finally{

    loading.value=false

  }

}

fetchData()

watch(
  [search,perPage],
  ()=>{
    page.value=1
  }
)

watch(
  ()=>route.query.search,
  value=>{
    search.value=
      typeof value==='string'
        ? value
        : ''
  },
  {
    immediate:true
  }
)

const filtered=computed(()=>{

  let rows=[...tournaments.value]

  if(search.value){

    const q=search.value.toLowerCase()

    rows=rows.filter(tournament=>

      tournament.tournament_name
        .toLowerCase()
        .includes(q)

      ||

      (tournament.tournament_code ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (tournament.tournament_type?.tournament_type_name ?? '')
        .toLowerCase()
        .includes(q)

    )

  }

  rows.sort((a,b)=>{

    let aValue=''
    let bValue=''

    switch(sortColumn.value){

      case 'tournament_name':

        aValue=a.tournament_name
        bValue=b.tournament_name

        break

      case 'tournament_code':

        aValue=a.tournament_code ?? ''
        bValue=b.tournament_code ?? ''

        break

      case 'tournament_type':

        aValue=
          a.tournament_type?.tournament_type_name ?? ''

        bValue=
          b.tournament_type?.tournament_type_name ?? ''

        break

    }

    const result=aValue.localeCompare(bValue)

    return sortDirection.value==='asc'
      ? result
      : -result

  })

  return rows

})

const pages=computed(()=>

  Math.max(
    1,
    Math.ceil(
      filtered.value.length/perPage.value
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

const start=computed(()=>

  (page.value-1)*perPage.value

)

const paginatedTournaments=computed(()=>

  filtered.value.slice(
    start.value,
    start.value+perPage.value
  )

)

function sortBy(column:SortColumn){

  if(sortColumn.value===column){

    sortDirection.value=
      sortDirection.value==='asc'
        ?'desc'
        :'asc'

  }
  else{

    sortColumn.value=column
    sortDirection.value='asc'

  }

}

function sortIcon(column:SortColumn){

  if(sortColumn.value!==column){

    return ''

  }

  return sortDirection.value==='asc'
    ?'▲'
    :'▼'

}
</script>