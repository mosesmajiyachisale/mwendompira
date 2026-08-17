<template>
  <div>

    <!-- =====================================================
         TOOLBAR
         ===================================================== -->
    <div class="d-flex justify-content-between align-items-center mb-2">

      <ion-searchbar
        v-model="search"
        placeholder="Search coach..."
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
          :routerLink="{ name: 'coaches.create' }"
        >
          <ion-icon
            slot="start"
            :icon="add"
          />

          New Coach
        </ion-button>

      </ion-buttons>

    </div>


    <!-- =====================================================
         TABLE
         ===================================================== -->
    <div class="table-responsive">

      <table
        class="table table-striped table-bordered table-hover table-sm"
      >

        <thead>

          <tr>

            <th>#</th>

            <th
              role="button"
              @click="sortBy('name')"
            >
              Coach {{ sortIcon('name') }}
            </th>

            <th
              role="button"
              @click="sortBy('gender')"
            >
              Gender {{ sortIcon('gender') }}
            </th>

            <th
              role="button"
              @click="sortBy('dob')"
            >
              Age {{ sortIcon('dob') }}
            </th>

            <th
              role="button"
              @click="sortBy('preferred_name')"
            >
              Preferred Name {{ sortIcon('preferred_name') }}
            </th>

            <th
              role="button"
              @click="sortBy('qualification')"
            >
              Professional Qualification
              {{ sortIcon('qualification') }}
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
              Loading providers...
            </td>

          </tr>


          <!-- Empty -->
          <tr v-else-if="paginatedproviders.length === 0">

            <td
              colspan="7"
              class="text-center"
            >
              No providers found.
            </td>

          </tr>


          <!-- providers -->
          <tr
            v-for="(coach, index) in paginatedproviders"
            :key="coach.id"
          >

            <td>
              {{ start + index + 1 }}
            </td>


            <!-- Coach -->
            <td>
              {{ fullName(coach) }}
            </td>


            <!-- Gender -->
            <td>
              {{ coach.person?.gender || '-' }}
            </td>


            <!-- Age -->
            <td>

              <template v-if="coach.person?.dob">

                {{ getAge(coach.person.dob) }} years

              </template>

              <template v-else>
                -
              </template>

            </td>


            <!-- Preferred Name -->
            <td>
              {{ coach.preferred_name || '-' }}
            </td>


            <!-- Professional Qualification -->
            <td>
              {{ coach?.professional_qualification?.qualification_name || '' }}
            </td>


            <!-- Actions -->
            <td class="text-end">

              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name: 'coaches.edit',
                  params: {
                    id: coach.id
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


    <!-- =====================================================
         PAGINATION
         ===================================================== -->
    <div
      class="d-flex justify-content-between align-items-center"
    >

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

import {
  computed,
  ref,
  watch
} from 'vue'

import {
  useRoute,
  useRouter
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
  pencilSharp,
  add
} from 'ionicons/icons'

import api from '@/api'


// ==========================================================
// TYPES
// ==========================================================

interface Person {

  id: number

  first_name: string

  middle_name?: string | null

  last_name: string

  gender?: 'Male' | 'Female' | null

  dob?: string | null

  location_id?: number | null

  updated_at?: string | null

}


interface Qualification {

  id: number

  qualification_name?: string | null

  name?: string | null

  qualification_code?: string | null

}


interface Coach {

  id: number

  person?: Person | null

  preferred_name?: string | null

  professional_qualification_id?: number | null

  professional_qualification?: Qualification | null

  updated_at?: string | null

}


type SortColumn =
  | 'updated_at'
  | 'name'
  | 'gender'
  | 'dob'
  | 'preferred_name'
  | 'qualification'


// ==========================================================
// ROUTER
// ==========================================================

const route = useRoute()

const router = useRouter()


// ==========================================================
// STATE
// ==========================================================

const providers = ref<Coach[]>([])

const loading = ref(false)


const pageSizes = [
  5,
  10,
  25,
  50
]


const search = ref(
  typeof route.query.search === 'string'
    ? route.query.search
    : ''
)


const page = ref(
  Number(route.query.page || 1)
)


const perPage = ref(
  Number(route.query.perPage || 20)
)


const sortColumn =
  ref<SortColumn>('updated_at')


const sortDirection =
  ref<'asc' | 'desc'>('desc')


// ==========================================================
// FETCH DATA
// ==========================================================

async function fetchData() {
  loading.value = true
  try {
    const { data } = await api.get('/settings/coaches')
    providers.value = data.providers ?? []
  }
  catch (error) {
    console.error('providers LOAD ERROR:',error)
  }
  finally {
    loading.value = false
  }
}


fetchData()


// ==========================================================
// AGE
// ==========================================================

function getAge(
  dob: string
): number {

  const birthDate =
    new Date(dob)

  const today =
    new Date()

  let age =
    today.getFullYear()
    -
    birthDate.getFullYear()

  const monthDiff =
    today.getMonth()
    -
    birthDate.getMonth()

  if (
    monthDiff < 0 ||
    (
      monthDiff === 0 &&
      today.getDate()
      < birthDate.getDate()
    )
  ) {

    age--

  }

  return age

}


// ==========================================================
// FULL NAME
// ==========================================================

function fullName(
  coach: Coach
): string {

  const person =
    coach.person

  if (!person) {

    return '-'

  }

  return [

    person.first_name,

    person.middle_name,

    person.last_name

  ]
    .filter(Boolean)
    .join(' ')

}


// ==========================================================
// WATCHERS
// ==========================================================

watch(
  [search, perPage],
  () => {

    page.value = 1

  }
)


watch(
  [search, page, perPage],
  () => {

    router.replace({

      query: {

        ...route.query,

        search:
          search.value || undefined,

        page:
          String(page.value),

        perPage:
          String(perPage.value)

      }

    })

  }
)


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


// ==========================================================
// FILTER
// ==========================================================

const filtered =
  computed(() => {

    let rows = [
      ...providers.value
    ]


    if (search.value) {

      const q =
        search.value
          .toLowerCase()


      rows = rows.filter(
        coach => {

          const person =
            coach.person

          return (

            // Full name
            fullName(coach)
              .toLowerCase()
              .includes(q)

            ||

            // First name
            String(
              person?.first_name ?? ''
            )
              .toLowerCase()
              .includes(q)

            ||

            // Middle name
            String(
              person?.middle_name ?? ''
            )
              .toLowerCase()
              .includes(q)

            ||

            // Last name
            String(
              person?.last_name ?? ''
            )
              .toLowerCase()
              .includes(q)

            ||

            // Gender
            String(
              person?.gender ?? ''
            )
              .toLowerCase()
              .includes(q)

            ||

            // DOB
            String(
              person?.dob ?? ''
            )
              .toLowerCase()
              .includes(q)

            ||

            // Preferred name
            String(
              coach.preferred_name ?? ''
            )
              .toLowerCase()
              .includes(q)

          )

        }
      )

    }


    // ======================================================
    // SORT
    // ======================================================

    rows.sort(
      (a, b) => {

        const aValue =
          getSortValue(a)

        const bValue =
          getSortValue(b)

        const result =
          aValue.localeCompare(
            bValue
          )

        return sortDirection.value === 'asc'
          ? result
          : -result

      }
    )


    return rows

  })


// ==========================================================
// SORT VALUE
// ==========================================================

// ==========================================================
// SORT VALUE
// ==========================================================

function getSortValue(
  coach: Coach
): string {

  switch (sortColumn.value) {

    case 'updated_at':

      return String(
        coach.updated_at ?? ''
      )


    case 'name':

      return fullName(coach)


    case 'gender':

      return String(
        coach.person?.gender ?? ''
      )


    case 'dob':

      return String(
        coach.person?.dob ?? ''
      )


    case 'preferred_name':

      return String(
        coach.preferred_name ?? ''
      )


    case 'qualification':

      return String(
        coach.professional_qualification
          ?.qualification_name ?? ''
      )


    default:

      return ''

  }

}

// ==========================================================
// PAGINATION
// ==========================================================

const pages =
  computed(() =>

    Math.max(

      1,

      Math.ceil(

        filtered.value.length
        /
        perPage.value

      )

    )

  )


watch(
  pages,
  value => {

    if (page.value > value) {

      page.value = value

    }

  }
)


const start =
  computed(() =>

    (page.value - 1)
    *
    perPage.value

  )


const paginatedproviders =
  computed(() =>

    filtered.value.slice(

      start.value,

      start.value
      +
      perPage.value

    )

  )


// ==========================================================
// SORT
// ==========================================================

function sortBy(
  column: SortColumn
) {

  if (
    sortColumn.value === column
  ) {

    sortDirection.value =
      sortDirection.value === 'asc'
        ? 'desc'
        : 'asc'

  }
  else {

    sortColumn.value =
      column

    sortDirection.value =
      'asc'

  }

}


function sortIcon(
  column: SortColumn
): string {

  if (
    sortColumn.value !== column
  ) {

    return ''

  }

  return sortDirection.value === 'asc'
    ? '▲'
    : '▼'

}

</script>