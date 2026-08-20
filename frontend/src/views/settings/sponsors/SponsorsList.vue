<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <ion-searchbar
        v-model="search"
        placeholder="Search sponsor..."
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
              :routerLink="{ name:'sponsors.create' }"
            >
              <ion-icon
                slot="start"
                :icon="add"
              />
              New Sponsor
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
              @click="sortBy('sponsor_name')"
            >
              Name {{ sortIcon('sponsor_name') }}
            </th>

            <th
              role="button"
              @click="sortBy('sponsor_code')"
            >
              Code {{ sortIcon('sponsor_code') }}
            </th>

            <th
              role="button"
              @click="sortBy('sponsor_desc')"
            >
              Description {{ sortIcon('sponsor_desc') }}
            </th>

            <th></th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="loading">
            <td
              colspan="5"
              class="text-center"
            >
              Loading sponsors...
            </td>
          </tr>

          <tr v-else-if="paginatedSponsors.length===0">
            <td
              colspan="5"
              class="text-center"
            >
              No sponsors found.
            </td>
          </tr>

          <tr
            v-for="(sponsor,index) in paginatedSponsors"
            :key="sponsor.id"
          >
            <td>
              {{ start + index + 1 }}
            </td>

            <td>
              {{ sponsor.sponsor_name }}
            </td>

            <td>
              {{ sponsor.sponsor_code || '-' }}
            </td>

            <td>
              {{ sponsor.sponsor_desc || '-' }}
            </td>

            <td class="text-end">
              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'sponsors.edit',
                  params:{id:sponsor.id}
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
import {
  computed,
  ref,
  watch
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
  useRoute,
  useRouter
} from 'vue-router'

import api from '@/api'

interface Sponsor{
  id:number
  sponsor_name:string
  sponsor_code:string|null
  sponsor_desc:string|null
}

type SortColumn=
  |'sponsor_name'
  |'sponsor_code'
  |'sponsor_desc'

const route=useRoute()
const router=useRouter()

const sponsors=ref<Sponsor[]>([])
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

const sortColumn=ref<SortColumn>('sponsor_name')

const sortDirection=ref<'asc'|'desc'>('asc')

async function fetchData(){

  loading.value=true

  try{

    const {data}=await api.get(
      '/settings/sponsors'
    )

    sponsors.value=data.sponsors ?? []

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

  let rows=[...sponsors.value]

  if(search.value){

    const q=search.value.toLowerCase()

    rows=rows.filter(sponsor=>

      sponsor.sponsor_name
        .toLowerCase()
        .includes(q)

      ||

      (sponsor.sponsor_code ?? '')
        .toLowerCase()
        .includes(q)

      ||

      (sponsor.sponsor_desc ?? '')
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

function getSortValue(
  sponsor:Sponsor
){

  switch(sortColumn.value){

    case 'sponsor_name':
      return sponsor.sponsor_name

    case 'sponsor_code':
      return sponsor.sponsor_code ?? ''

    case 'sponsor_desc':
      return sponsor.sponsor_desc ?? ''

  }

}

const pages=computed(()=>

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

const start=computed(()=>

  (page.value-1)
  *
  perPage.value

)

const paginatedSponsors=computed(()=>

  filtered.value.slice(
    start.value,
    start.value+perPage.value
  )

)

function sortBy(
  column:SortColumn
){

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

function sortIcon(
  column:SortColumn
){

  if(sortColumn.value!==column){

    return ''

  }

  return sortDirection.value==='asc'
    ?'▲'
    :'▼'

}
</script>