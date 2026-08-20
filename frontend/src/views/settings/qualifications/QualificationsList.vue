<template>
  <div>

    <!-- Search + rows -->
    <div class="d-flex justify-content-between align-items-center mb-2">

      <ion-searchbar
        v-model="search"
        placeholder="Search qualification..."
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


    <!-- Table -->
    <div class="table-responsive">

      <table
        class="table table-striped table-bordered table-hover table-sm"
      >

        <thead>

          <tr>

            <th>
              #
            </th>

            <th
              role="button"
              @click="sortBy('qualification_name')"
            >
              Qualification
              {{ sortIcon('qualification_name') }}
            </th>

            <th
              role="button"
              @click="sortBy('qualification_code')"
            >
              Code
              {{ sortIcon('qualification_code') }}
            </th>
            <th
              role="button"
              @click="sortBy('qualification_desc')"
            >
              Description
              {{ sortIcon('qualification_desc') }}
            </th>

            <th
              role="button"
              @click="sortBy('qualification_type')"
            >
              Type
              {{ sortIcon('qualification_type') }}
            </th>

            <th></th>

          </tr>

        </thead>


        <tbody>

          <!-- Loading -->
          <tr v-if="loading">

            <td
              colspan="7"
              class="text-center"
            >
              Loading qualifications...
            </td>

          </tr>


          <!-- Empty -->
          <tr
            v-else-if="paginatedQualifications.length === 0"
          >

            <td
              colspan="7"
              class="text-center"
            >
              No qualifications found.
            </td>

          </tr>


          <!-- Data -->
          <tr
            v-for="(qualification,index) in paginatedQualifications"
            :key="qualification.id"
          >

            <td>
              {{ start + index + 1 }}
            </td>


            <td>
              {{ qualification.qualification_name }}
            </td>


            <td>
              {{ qualification.qualification_code ?? '' }}
            </td>


            <td>
              {{ qualification.qualification_desc ?? '' }}
            </td>

            <td>
              {{ qualification.qualification_type?.qualification_type_name ?? '' }}
            </td>


            <td class="text-end">

              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'qualifications.edit',
                  params:{
                    id:qualification.id
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


    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center">

      <div>

        <ion-button
          size="small"
          :disabled="page === 1"
          @click="page--"
        >
          Previous
        </ion-button>


        <span class="mx-2">
          {{ page }} / {{ pages }}
        </span>


        <ion-button
          size="small"
          :disabled="page === pages"
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

interface QualificationType {
  id:number
  qualification_type_name:string
}

interface Qualification {
  id:number
  qualification_name:string
  qualification_code:string|null
  qualification_desc:string|null
  qualification_type_id:number|null
  is_active:boolean
  qualification_type?:QualificationType|null
}


type SortColumn = | 'qualification_name' | 'qualification_code' | 'qualification_desc' | 'qualification_type'

const route = useRoute()

const qualifications = ref<Qualification[]>([])
const loading = ref(false)
const search = ref( typeof route.query.search === 'string' ? route.query.search : '')
const page = ref(1)
const perPage = ref(50)
const sortColumn =ref<SortColumn>( 'qualification_name')
const sortDirection = ref<'asc'|'desc'>('asc')

async function fetchData(){
  loading.value = true
  try{
    const {data} = await api.get('/settings/qualifications')
    qualifications.value = data.qualifications ?? []
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
    search.value = typeof value === 'string' ? value : ''
  },
  {
    immediate:true
  }
)


const filtered = computed(()=>{
    let rows = [...qualifications.value]
    if(search.value){
      const q = search.value.toLowerCase()
      rows = rows.filter(
          qualification=>{
            return (
              qualification.qualification_name.toLowerCase().includes(q) ||
              (qualification.qualification_code ?? '').toLowerCase().includes(q) ||
              (qualification.qualification_desc  ?? '').toLowerCase().includes(q)||
              (qualification.qualification_type?.qualification_type_name?? '')  .toLowerCase()  .includes(q)
            )
          }
        )
    }


    rows.sort((a, b) => {

      let x = ''
      let y = ''

      switch (sortColumn.value) {

        case 'qualification_name':
          x = a.qualification_name
          y = b.qualification_name
          break

        case 'qualification_code':
          x = a.qualification_code ?? ''
          y = b.qualification_code ?? ''
          break

        case 'qualification_type':
          x =
            a.qualification_type?.qualification_type_name ?? ''

          y =
            b.qualification_type?.qualification_type_name ?? ''

          break
      }

      const result = x.localeCompare(y)

      return sortDirection.value === 'asc'
        ? result
        : -result

    })


    return rows

  })


const pages =
  computed(()=>

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

    if(page.value > value){

      page.value = value

    }

  }
)


const start =
  computed(()=>

    (page.value - 1) *
    perPage.value

  )


const paginatedQualifications =
  computed(()=>

    filtered.value.slice(
      start.value,
      start.value + perPage.value
    )

  )


function sortBy(
  column:SortColumn
){

  if(
    sortColumn.value === column
  ){

    sortDirection.value =
      sortDirection.value === 'asc'
        ? 'desc'
        : 'asc'

  }
  else{

    sortColumn.value =
      column

    sortDirection.value =
      'asc'

  }

}

function sortIcon(column: SortColumn) {

if (sortColumn.value !== column) {
  return ''
}

return sortDirection.value === 'asc'
  ? '▲'
  : '▼'
}

fetchData()

</script>