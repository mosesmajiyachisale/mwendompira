```vue
<template>
  <div>

    <!-- Search + rows + add -->
    <div class="d-flex justify-content-between align-items-center mb-2">

      <ion-searchbar
        v-model="search"
        placeholder="Search field..."
        :debounce="300"
      />

      <ion-select
        v-model="perPage"
        interface="popover"
        class="ion-no-padding"
        style="width:120px"
      >
        <ion-select-option
          v-for="size in pages"
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
          :routerLink="{ name:'fields.create' }"
        >
          <ion-icon
            slot="start"
            :icon="add"
          />
          New Field
        </ion-button>
      </ion-buttons>

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
              @click="sortBy('field_name')"
            >
              Field
              {{ sortIcon('field_name') }}
            </th>

            <th
              role="button"
              @click="sortBy('field_code')"
            >
              Code
              {{ sortIcon('field_code') }}
            </th>

            <th
              role="button"
              @click="sortBy('field_desc')"
            >
              Description
              {{ sortIcon('field_desc') }}
            </th>

            <th></th>

          </tr>

        </thead>


        <tbody>

          <!-- Loading -->
          <tr v-if="loading">

            <td
              colspan="6"
              class="text-center"
            >
              Loading fields...
            </td>

          </tr>


          <!-- Empty -->
          <tr
            v-else-if="paginatedFields.length === 0"
          >

            <td
              colspan="6"
              class="text-center"
            >
              No fields found.
            </td>

          </tr>


          <!-- Data -->
          <tr
            v-for="(field,index) in paginatedFields"
            :key="field.id"
          >

            <td>
              {{ start + index + 1 }}
            </td>

            <td>
              {{ field.field_name }}
            </td>

            <td>
              {{ field.field_code }}
            </td>

            <td>
              {{ field.field_desc ?? '' }}
            </td>

            <td class="text-end">

              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'fields.edit',
                  params:{
                    id:field.id
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
  IonButtons,
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import {
  pencilSharp,add
} from 'ionicons/icons'

import api from '@/api'


interface Field {

  id:number

  field_name:string

  field_code:string

  field_desc:string|null

  is_active:boolean

}


type SortColumn =
  | 'field_name'
  | 'field_code'
  | 'field_desc'
  | 'is_active'


const route = useRoute()


const fields =
  ref<Field[]>([])


const loading =
  ref(false)


const search =
  ref(
    typeof route.query.search === 'string'
      ? route.query.search
      : ''
  )


const page =
  ref(1)


const perPage =
  ref(50)


const sortColumn =
  ref<SortColumn>('field_name')


const sortDirection =
  ref<'asc'|'desc'>('asc')


async function fetchData(){

  loading.value = true

  try{

    const {data} = await api.get('/settings/fields')
      fields.value = data.fields ?? []

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


const filtered =
  computed(()=>{

    let rows =
      [...fields.value]


    if(search.value){

      const q =
        search.value.toLowerCase()


      rows =
        rows.filter(field=>{

          return (

            field.field_name
              .toLowerCase()
              .includes(q)

            ||

            field.field_code
              .toLowerCase()
              .includes(q)

            ||

            (field.field_desc ?? '')
              .toLowerCase()
              .includes(q)

            ||

            (
              field.is_active
                ? 'yes'
                : 'no'
            ).includes(q)

          )

        })

    }


    rows.sort((a,b)=>{

      let x = ''
      let y = ''


      switch(sortColumn.value){

        case 'field_name':

          x = a.field_name
          y = b.field_name

          break


        case 'field_code':

          x = a.field_code
          y = b.field_code

          break


        case 'field_desc':

          x = a.field_desc ?? ''
          y = b.field_desc ?? ''

          break


        case 'is_active':

          x = a.is_active ? 'Yes' : 'No'
          y = b.is_active ? 'Yes' : 'No'

          break

      }


      const result =
        x.localeCompare(y)


      return sortDirection.value === 'asc'
        ? result
        : -result

    })


    return rows

  })


const pages =
  computed(()=>{

    return Math.max(

      1,

      Math.ceil(
        filtered.value.length /
        perPage.value
      )

    )

  })


watch(
  pages,
  value=>{

    if(page.value > value){

      page.value = value

    }

  }
)


const start =
  computed(()=>{

    return (
      (page.value - 1) *
      perPage.value
    )

  })


const paginatedFields =
  computed(()=>{

    return filtered.value.slice(

      start.value,

      start.value +
      perPage.value

    )

  })


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


function sortIcon(
  column:SortColumn
){

  if(
    sortColumn.value !== column
  ){

    return ''

  }


  return sortDirection.value === 'asc'
    ? '▲'
    : '▼'

}


fetchData()

</script>
```
