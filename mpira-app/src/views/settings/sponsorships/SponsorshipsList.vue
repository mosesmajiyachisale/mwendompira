<template>
    <div>
      <div class="d-flex justify-content-between align-items-center mb-2">
  
        <ion-searchbar
          v-model="search"
          placeholder="Search sponsorship..."
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
            :routerLink="{name:'sponsorships.create'}"
          >
            <ion-icon
              slot="start"
              :icon="add"
            />
  
            New Sponsorship
          </ion-button>
        </ion-buttons>
  
      </div>
  
  
      <div class="table-responsive">
  
        <table class="table table-striped table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th role="button" @click="sortBy('season')">
                Season {{ sortIcon('season') }}
              </th>
              <th role="button" @click="sortBy('tournament')">
                Tournament {{ sortIcon('tournament') }}
              </th>
              <th role="button" @click="sortBy('sponsor')">
                Sponsor {{ sortIcon('sponsor') }}
              </th>
              <th>
                Amount
              </th>
              <th></th>
            </tr>
          </thead>
  
  
          <tbody>
  
            <tr v-if="loading">
              <td colspan="7" class="text-center">
                Loading sponsorships...
              </td>
            </tr>
  
  
            <tr v-else-if="paginatedSponsorships.length===0">
              <td colspan="7" class="text-center">
                No sponsorships found.
              </td>
            </tr>
  
  
            <tr
              v-for="(sponsorship,index) in paginatedSponsorships"
              :key="sponsorship.id"
            >
  
              <td>
                {{ start + index + 1 }}
              </td>
              <td>
                {{ sponsorship?.season?.season_code || '-' }}
              </td>
              <td>
                {{ sponsorship.tournament?.tournament_name || '-' }}
              </td>
              <td>
                {{ sponsorship.sponsor?.sponsor_name || '-' }}
              </td>
              <td>
                {{ formatAmount(sponsorship.amount) }}
              </td>
              <td class="text-end">
                <ion-button
                  size="small"
                  fill="clear"
                  color="success"
                  :routerLink="{
                    name:'sponsorships.edit',
                    params:{id:sponsorship.id}
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
  
  import {computed,ref,watch} from 'vue'
  import {useRoute,useRouter} from 'vue-router'
  
  import {
    IonButtons,
    IonButton,
    IonIcon,
    IonSearchbar,
    IonSelect,
    IonSelectOption
  } from '@ionic/vue'
  
  import {
    pencilSharp,
    add
  } from 'ionicons/icons'
  
  import api from '@/api'
  
  
  interface Sponsorship{
  
    id:number
  
    season?:{
      season_code:string
    }
  
    tournament?:{
      tournament_name:string
    }
  
    sponsor?:{
      sponsor_name:string
    }
  
    amount:string|null
  
    is_active:boolean
  
  }
  
  
  type SortColumn='season'|'tournament'|'sponsor'|'amount'
  
  
  const route=useRoute()
  const router=useRouter()
  
  const sponsorships=ref<Sponsorship[]>([])
  const loading=ref(false)
  
  const pageSizes=[5,10,25,50]
  
  const search=ref(
    typeof route.query.search==='string'
      ? route.query.search
      : ''
  )
  
  const page=ref(Number(route.query.page || 1))
  
  const perPage=ref(Number(route.query.perPage || 10))
  
  const sortColumn=ref<SortColumn>('season')
  
  const sortDirection=ref<'asc'|'desc'>('desc')
  
  
  async function fetchData(){
  
    loading.value=true
  
    try{
  
      const {data}=await api.get('/settings/sponsorships')
  
      sponsorships.value=data.sponsorships ?? []
  
    }
    catch(error){
  
      console.error(error)
  
    }
    finally{
  
      loading.value=false
  
    }
  
  }
  
  
  fetchData()
  
  function formatAmount(amount:string|null){
    if(!amount){
      return '-'
    }
    return Number(amount).toLocaleString()
  }

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
  
      search.value=typeof value==='string'
        ? value
        : ''
  
    },
    {
      immediate:true
    }
  )
  
  
  const filtered=computed(()=>{
  
    let rows=[...sponsorships.value]
  
    if(search.value){
      const q=search.value.toLowerCase()
  
      rows=rows.filter(item=>
        item.season?.season_code?.toLowerCase().includes(q)
  
        ||
        item.tournament?.tournament_name?.toLowerCase().includes(q)
  
        ||
        item.sponsor?.sponsor_name?.toLowerCase().includes(q)
  
        ||
        item.amount?.toLowerCase().includes(q)
  
      )
  
    }
  
  
    rows.sort((a,b)=>{
  
      const result=getSortValue(a).localeCompare(getSortValue(b))
  
      return sortDirection.value==='asc'
        ? result
        : -result
  
    })
  
  
    return rows
  
  })
  
  
  function getSortValue(sponsorship:Sponsorship){
  
    switch(sortColumn.value){
      case 'season':
        return sponsorship.season?.season_code ?? ''
      case 'tournament':
        return sponsorship.tournament?.tournament_name ?? ''
      case 'sponsor':
        return sponsorship.sponsor?.sponsor_name ?? ''
      case 'amount':
        return sponsorship.amount ?? ''
    }
  }
  
  
  const pages=computed(()=>
    Math.max(1,Math.ceil(filtered.value.length/perPage.value))
  )
  
  
  watch(
    pages,
    value=>{
  
      if(page.value>value){
  
        page.value=value
  
      }
  
    }
  )
  
  
  const start=computed(()=>(page.value-1)*perPage.value)
  
  
  const paginatedSponsorships=computed(()=>
    filtered.value.slice(start.value,start.value+perPage.value)
  )
  
  
  function sortBy(column:SortColumn){
  
    if(sortColumn.value===column){
  
      sortDirection.value=sortDirection.value==='asc'
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