<template>
    <form @submit.prevent="saveChanges" class="card p-3 mb-3 bg-light">
  
      <div class="row g-2 align-items-end">
  
  
        <div class="col-md-3 py-1 px-2">
          <div class="control-block">
  
            <label class="control-block-label">
              Season
            </label>
  
            <ion-select
              v-model="formData.season_id"
              interface="popover"
              placeholder="Select Season"
              :required="true"
              :disabled="true"
              >
              <ion-select-option
                v-for="season in seasons"
                :key="season.id"
                :value="season.id"
              >
                {{ season.season_code }}
              </ion-select-option>
  
            </ion-select>
  
          </div>
        </div>
  
  
  
        <div class="col-md-3 py-1 px-2">
          <div class="control-block">
  
            <label class="control-block-label">
              Tournament
            </label>
  
            <ion-select
              v-model="formData.tournament_id"
              interface="popover"
              placeholder="Select Tournament"
              :required="true"
              >
  
              <ion-select-option
                v-for="tournament in tournaments"
                :key="tournament.id"
                :value="tournament.id"
              >
                {{ tournament.tournament_name }}
              </ion-select-option>
  
            </ion-select>
  
          </div>
        </div>
  
  
  
        <div class="col-md-3 py-1 px-2">
          <div class="control-block">
  
            <label class="control-block-label">
              Sponsor
            </label>
  
            <ion-select
              v-model="formData.sponsor_id"
              interface="popover"
              placeholder="Select Sponsor"
              :required="true"
              >
  
              <ion-select-option
                v-for="sponsor in sponsors"
                :key="sponsor.id"
                :value="sponsor.id"
              >
                {{ sponsor.sponsor_name }}
              </ion-select-option>
  
            </ion-select>
  
          </div>
        </div>
  
  
  
        <div class="col-md-3 py-1 px-2">
          <div class="control-block">
  
            <label class="control-block-label">
              Amount
            </label>
            <ion-input
                :value="formatAmount(formData.amount)"
                placeholder="Enter Amount"
                class="compact-input"
                @ionInput="updateAmount"
            />
  
          </div>
        </div>
  
        <div class="col-md-5 d-flex gap-2">
  
  
          <ion-button
            type="submit"
            size="small"
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
            size="small"
            :router-link="{name:'sponsorships.index'}"
          >
  
            Cancel
  
          </ion-button>
  
  
        </div>
  
  
      </div>
  
    </form>
</template>

  <script setup lang="ts">
  
  import {reactive,ref} from 'vue'
  
  import {
    useRoute,
    useRouter
  } from 'vue-router'
  
  
  import {
    IonInput,
    IonSelect,
    IonSelectOption,
    IonButton,
    IonSpinner
  } from '@ionic/vue'
  
  
  import api from '@/api'
  
  
  
  const route=useRoute()
  
  const router=useRouter()
  
  
  
  interface Season{
    id:number
    season_code:string
  }
  
  
  interface Tournament{
    id:number
    tournament_name:string
  }
  
  
  interface Sponsor{
    id:number
    sponsor_name:string
  }
  
  
  
  const seasons=ref<Season[]>([])
  
  const tournaments=ref<Tournament[]>([])
  
  const sponsors=ref<Sponsor[]>([])
  
  
  const loading=ref(false)
  
  
  
  const formData=reactive({
  
    season_id:null as number|null,
  
    tournament_id:null as number|null,
  
    sponsor_id:null as number|null,
  
    amount:'',
  
    is_active:true
  
  })
  
  
  
  function formatAmount(amount:string|null){
  
    if(!amount){
      return ''
    }
  
    return Number(amount).toLocaleString()
  
  }
  
  
  
  function updateAmount(event:any){
  
    const value=event.detail.value
  
    formData.amount=value
      ? value.replace(/,/g,'')
      : ''
  
  }
  
  
  
  async function fetchData(){
  
    try{
  
      const id=route.params.id
  
  
      const {data}=await api.get(
        `/settings/sponsorships/${id}/edit`
      )
  
  
      const sponsorship=data.selectedSponsorship
  
  
      seasons.value=data.seasons ?? []
  
      tournaments.value=data.tournaments ?? []
  
      sponsors.value=data.sponsors ?? []
  
  
      formData.season_id=sponsorship?.season_id ?? null
  
      formData.tournament_id=sponsorship?.tournament_id ?? null
  
      formData.sponsor_id=sponsorship?.sponsor_id ?? null
  
      formData.amount=sponsorship?.amount ?? ''
  
      formData.is_active=sponsorship?.is_active ?? true
  
  
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
      const id=route.params.id
      const payload={
        season_id: formData.season_id,
        tournament_id: formData.tournament_id,
        sponsor_id: formData.sponsor_id,
        amount: formData.amount || null,
        is_active: formData.is_active
      }

      const {data}=await api.put(`/settings/sponsorships/${id}`,payload)
      if(data.success){
        router.replace({
          name:'sponsorships.index',
          query:{
            search: data?.selectedSponsorship?.season?.season_code || null
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