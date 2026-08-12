<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      
      <ion-searchbar
        v-model="search"
        placeholder="Search team..."
        :debounce="300"
      />

      <ion-select
        v-model="perPage"
        interface="popover"
        class="ion-no-padding"
        style="width:100px"
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
          :routerLink="{name:'teams.create'}"
        >
          <ion-icon
            slot="start"
            :icon="add"
          />
          New Team
        </ion-button>
      </ion-buttons>
    </div>

    <div class="table-responsive">
    
      <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
          <tr>
            <th>#</th>

            <th role="button" @click="sortBy('team_name')">
              Team Name {{ sortIcon('team_name') }}
            </th>

            <th role="button" @click="sortBy('team_code')">
              Code {{ sortIcon('team_code') }}
            </th>

            <th role="button" @click="sortBy('district')">
              District {{ sortIcon('district') }}
            </th>

            <th role="button" @click="sortBy('nickname')">
              Nickname {{ sortIcon('nickname') }}
            </th>

            <th role="button" @click="sortBy('est')">
              Established {{ sortIcon('est') }}
            </th>

            <th></th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="loading">
            <td colspan="7" class="text-center">
              Loading teams...
            </td>
          </tr>

          <tr v-else-if="paginatedTeams.length === 0">
            <td colspan="7" class="text-center">
              No teams found.
            </td>
          </tr>

          <tr
            v-for="(team,index) in paginatedTeams"
            :key="team.id"
          >
            <td>
              {{ start + index + 1 }}
            </td>

            <td>
              {{ team.team_name }}
            </td>

            <td>
              {{ team.team_code || '-' }}
            </td>

            <td>
              {{ team.district?.location_name || '-' }}
            </td>

            <td>
              {{ team.nickname || '-' }}
            </td>

            <td>
              {{ team.est || '-' }}
            </td>

            <td class="text-end">
              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'teams.edit',
                  params:{id:team.id}
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
import {computed,ref,watch} from 'vue'
import {onIonViewWillEnter} from '@ionic/vue'
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


interface Team{
  id:number
  team_name:string
  team_code:string|null
  nickname:string|null
  est:string|null
  district_id:number|null
  district?:{
    location_name:string
  }
}


type SortColumn =
  | 'team_name'
  | 'team_code'
  | 'district'
  | 'nickname'
  | 'est'


const route=useRoute()
const router=useRouter()


const teams=ref<Team[]>([])
const loading=ref(false)


const pageSizes=[5,10,25,50]


const search=ref(
  typeof route.query.search==='string'
    ? route.query.search
    : ''
)


const page=ref(
  Number(route.query.page || 1)
)


const perPage=ref(
  Number(route.query.perPage || 10)
)


const sortColumn=ref<SortColumn>('team_name')

const sortDirection=ref<'asc'|'desc'>('asc')


async function fetchData(){

  loading.value=true

  try{
    const {data}=await api.get('/settings/teams')
    teams.value=data.teams ?? []
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
  [search,page,perPage],
  ()=>{
    router.replace({
      query:{
        ...route.query,
        search:search.value || undefined,
        page:String(page.value),
        perPage:String(perPage.value)
      }
    })
  }
)


watch(
  ()=>route.query.search,
  value=>{
    search.value =
      typeof value==='string'
        ? value
        : ''
  },
  {
    immediate:true
  }
)


const filtered=computed(()=>{

  let rows=[...teams.value]

  if(search.value){

    const q=search.value.toLowerCase()

    rows=rows.filter(team=>

      team.team_name
        .toLowerCase()
        .includes(q)

      ||

      (team.team_code ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (team.nickname ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (team.est ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (team.district?.location_name ?? '')
        .toLowerCase()
        .includes(q)

    )

  }


  rows.sort((a,b)=>{

    const aValue=getSortValue(a)
    const bValue=getSortValue(b)

    const result=aValue.localeCompare(bValue)

    return sortDirection.value==='asc'
      ? result
      : -result

  })


  return rows

})


function getSortValue(team:Team){

  switch(sortColumn.value){

    case 'team_name':
      return team.team_name

    case 'team_code':
      return team.team_code ?? ''

    case 'district':
      return team.district?.location_name ?? ''

    case 'nickname':
      return team.nickname ?? ''

    case 'est':
      return team.est ?? ''

  }

}


const pages=computed(()=>
  Math.max(
    1,
    Math.ceil(
      filtered.value.length / perPage.value
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


const paginatedTeams=computed(()=>
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
    ? '▲'
    : '▼'

}
</script>