<template>
  <div>

      <div class="table-responsive">

          <table class="table table-striped table-bordered table-hover table-sm">

              <thead>

                  <tr>

                      <th>#</th>

                      <th>
                          Phase
                      </th>

                      <th>
                          Code
                      </th>

                      <th>
                          From
                      </th>

                      <th>
                          To
                      </th>

                  </tr>

              </thead>


              <tbody>

                  <tr v-if="loading">

                      <td
                          colspan="6"
                          class="text-center"
                      >
                          Loading phases...
                      </td>

                  </tr>


                  <tr v-else-if="paginatedPhases.length === 0">

                      <td
                          colspan="6"
                          class="text-center"
                      >
                          No phases found.
                      </td>

                  </tr>


                  <tr
                      v-for="(phase, index) in paginatedPhases"
                      :key="phase.id"
                  >

                      <td>
                          {{ start + index + 1 }}
                      </td>

                      <td>
                          {{ phase.phase_name }}
                      </td>

                      <td>
                          {{ phase.phase_code }}
                      </td>

                      <td>
                          {{ phase.min_minute }} minutes
                      </td>

                      <td>
                          {{ phase.max_minute }} minutes
                      </td>

                  </tr>

              </tbody>

          </table>

      </div>


      <!-- =========================================================
           PAGINATION
           ========================================================= -->

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
  IonIcon
} from '@ionic/vue'

import {
  pencilSharp
} from 'ionicons/icons'

import api from '@/api'


interface Phase {

  id: number

  phase_name: string

  phase_code: string

  min_minute: number

  max_minute: number

  is_active: boolean

}


type SortColumn =
  | 'phase_name'
  | 'phase_code'
  | 'min_minute'
  | 'max_minute'


const route = useRoute()


const phases = ref<Phase[]>([])

const loading = ref(false)


const search = ref(
  typeof route.query.search === 'string'
      ? route.query.search
      : ''
)


const page = ref(1)

const perPage = ref(5)


const sortColumn = ref<SortColumn>('min_minute')

const sortDirection = ref<'asc' | 'desc'>('asc')


/* =========================================================
 FETCH
 ========================================================= */

async function fetchData() {

  loading.value = true

  try {

      const { data } = await api.get('/settings/phases')

      phases.value = data?.phases ?? []

  } catch (error) {

      console.error(error)

  } finally {

      loading.value = false

  }

}


/* =========================================================
 RESET PAGE
 ========================================================= */

watch(
  [search, perPage],
  () => {
      page.value = 1
  }
)


/* =========================================================
 ROUTE SEARCH
 ========================================================= */

watch(
  () => route.query.search,

  value => {

      search.value =
          typeof value === 'string'
              ? value
              : ''

  },

  {
      immediate: true
  }
)


/* =========================================================
 FILTER + SORT
 ========================================================= */

const filtered = computed(() => {

  let rows = [...phases.value]


  /*
   * SEARCH
   */

  if (search.value) {

      const q = search.value.toLowerCase()

      rows = rows.filter(phase =>

          phase.phase_name
              .toLowerCase()
              .includes(q)

          ||

          phase.phase_code
              .toLowerCase()
              .includes(q)

          ||

          String(phase.min_minute)
              .includes(q)

          ||

          String(phase.max_minute)
              .includes(q)

      )

  }


  /*
   * SORT
   */

  rows.sort((a, b) => {

      let result = 0


      switch (sortColumn.value) {

          case 'phase_name':

              result = a.phase_name.localeCompare(
                  b.phase_name
              )

              break


          case 'phase_code':

              result = a.phase_code.localeCompare(
                  b.phase_code
              )

              break


          case 'min_minute':

              result =
                  a.min_minute -
                  b.min_minute

              break


          case 'max_minute':

              result =
                  a.max_minute -
                  b.max_minute

              break

      }


      return sortDirection.value === 'asc'
          ? result
          : -result

  })


  return rows

})


/* =========================================================
 PAGES
 ========================================================= */

const pages = computed(() =>

  Math.max(
      1,
      Math.ceil(
          filtered.value.length /
          perPage.value
      )
  )

)


/* =========================================================
 KEEP PAGE VALID
 ========================================================= */

watch(
  pages,

  value => {

      if (page.value > value) {

          page.value = value

      }

  }
)


/* =========================================================
 PAGINATION
 ========================================================= */

const start = computed(() =>

  (page.value - 1) *
  perPage.value

)


const paginatedPhases = computed(() =>

  filtered.value.slice(
      start.value,
      start.value + perPage.value
  )

)


/* =========================================================
 SORT
 ========================================================= */

function sortBy(column: SortColumn) {

  if (sortColumn.value === column) {

      sortDirection.value =
          sortDirection.value === 'asc'
              ? 'desc'
              : 'asc'

  } else {

      sortColumn.value = column

      sortDirection.value = 'asc'

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


/* =========================================================
 EDIT
 ========================================================= */

function editPhase(phase: Phase) {

  console.log('Edit phase:', phase)

}


/* =========================================================
 INITIAL LOAD
 ========================================================= */

fetchData()

</script>