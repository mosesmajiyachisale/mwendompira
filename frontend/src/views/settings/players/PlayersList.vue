<template>
  <div>

    <div class="d-flex justify-content-between align-items-center mb-2">

      <ion-searchbar
        v-model="search"
        placeholder="Search player..."
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
          :routerLink="{name:'players.create'}"
        >

          <ion-icon
            slot="start"
            :icon="add"
          />

          New Player

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
              @click="sortBy('name')"
            >
              Player {{ sortIcon('name') }}
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
              @click="sortBy('preferred_foot')"
            >
              Preferred Foot {{ sortIcon('preferred_foot') }}
            </th>

            <th
              role="button"
              @click="sortBy('height_cm')"
            >
              Height {{ sortIcon('height_cm') }}
            </th>

            <th></th>

          </tr>

        </thead>


        <tbody>

          <tr v-if="loading">

            <td
              colspan="8"
              class="text-center"
            >
              Loading players...
            </td>

          </tr>


          <tr v-else-if="paginatedPlayers.length === 0">

            <td
              colspan="8"
              class="text-center"
            >
              No players found.
            </td>

          </tr>


          <tr
            v-for="(player,index) in paginatedPlayers"
            :key="player.id"
          >

            <td>
              {{ start + index + 1 }}
            </td>


            <td>
              {{ fullName(player) }}
            </td>


            <td>
              {{ player.person?.gender || '-' }}
            </td>


            <td>
              {{
                player.person?.dob
                  ? `${getAge(player.person.dob)} years`
                  : '-'
              }}
            </td>


            <td>
              {{ player.preferred_name || '-' }}
            </td>


            <td>
              {{ player.preferred_foot || '-' }}
            </td>


            <td>
              {{
                player.height_cm !== null &&
                player.height_cm !== undefined
                  ? `${player.height_cm} cm`
                  : '-'
              }}
            </td>


            <td class="text-end">

              <ion-button
                size="small"
                fill="clear"
                color="success"
                :routerLink="{
                  name:'players.edit',
                  params:{id:player.id}
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


interface Player {

  id: number

  person?: Person | null

  player_code?: number | null

  preferred_name?: string | null

  preferred_foot: 'Both' | 'Left' | 'Right'

  height_cm?: number | null

  updated_at?: string | null

}


type SortColumn =
  | 'updated_at'
  | 'name'
  | 'gender'
  | 'dob'
  | 'preferred_name'
  | 'preferred_foot'
  | 'height_cm'


const route = useRoute()

const router = useRouter()


const players = ref<Player[]>([])

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


/*
|--------------------------------------------------------------------------
| Default sorting
|--------------------------------------------------------------------------
|
| Newest/most recently updated players first.
|
*/

const sortColumn = ref<SortColumn>('updated_at')

const sortDirection = ref<'asc' | 'desc'>('desc')


/*
|--------------------------------------------------------------------------
| Fetch players
|--------------------------------------------------------------------------
*/

async function fetchData() {

  loading.value = true

  try {

    const { data } = await api.get(
      '/settings/players'
    )

    players.value = data.players ?? []

  }
  catch (error) {

    console.error(
      'PLAYER LIST ERROR:',
      error
    )

  }
  finally {

    loading.value = false

  }

}


fetchData()


/*
|--------------------------------------------------------------------------
| Age
|--------------------------------------------------------------------------
*/

function getAge(
  dob: string
): number {

  const birthDate = new Date(dob)

  const today = new Date()

  let age =
    today.getFullYear() -
    birthDate.getFullYear()

  const monthDiff =
    today.getMonth() -
    birthDate.getMonth()

  if (
    monthDiff < 0 ||
    (
      monthDiff === 0 &&
      today.getDate() < birthDate.getDate()
    )
  ) {

    age--

  }

  return age

}


/*
|--------------------------------------------------------------------------
| Reset page when search/per-page changes
|--------------------------------------------------------------------------
*/

watch(
  [search, perPage],
  () => {

    page.value = 1

  }
)


/*
|--------------------------------------------------------------------------
| Store pagination in URL
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Load search from URL
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Filter + Sort
|--------------------------------------------------------------------------
*/

const filtered = computed(() => {

  let rows = [
    ...players.value
  ]


  /*
  |--------------------------------------------------------------------------
  | Search
  |--------------------------------------------------------------------------
  */

  if (search.value) {

    const q =
      search.value
        .toLowerCase()


    rows = rows.filter(
      player => {

        const person =
          player.person


        return (

          /*
          |--------------------------------------------------------------------------
          | Full name
          |--------------------------------------------------------------------------
          */

          fullName(player)
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | First name
          |--------------------------------------------------------------------------
          */

          String(
            person?.first_name ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Middle name
          |--------------------------------------------------------------------------
          */

          String(
            person?.middle_name ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Last name
          |--------------------------------------------------------------------------
          */

          String(
            person?.last_name ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Gender
          |--------------------------------------------------------------------------
          */

          String(
            person?.gender ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Date of birth
          |--------------------------------------------------------------------------
          */

          String(
            person?.dob ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Preferred name
          |--------------------------------------------------------------------------
          */

          String(
            player.preferred_name ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Preferred foot
          |--------------------------------------------------------------------------
          */

          String(
            player.preferred_foot ?? ''
          )
            .toLowerCase()
            .includes(q)


          ||


          /*
          |--------------------------------------------------------------------------
          | Height
          |--------------------------------------------------------------------------
          |
          | height_cm is a number, therefore convert it
          | to a string before searching.
          |
          */

          String(
            player.height_cm ?? ''
          )
            .toLowerCase()
            .includes(q)

        )

      }
    )

  }


  /*
  |--------------------------------------------------------------------------
  | Sort
  |--------------------------------------------------------------------------
  */

  rows.sort(
    (a, b) => {

      const aValue =
        getSortValue(a)

      const bValue =
        getSortValue(b)


      let result: number


      /*
      |--------------------------------------------------------------------------
      | Numeric sorting
      |--------------------------------------------------------------------------
      */

      if (
        typeof aValue === 'number' &&
        typeof bValue === 'number'
      ) {

        result =
          aValue - bValue

      }


      /*
      |--------------------------------------------------------------------------
      | String sorting
      |--------------------------------------------------------------------------
      */

      else {

        result =
          String(aValue)
            .localeCompare(
              String(bValue)
            )

      }


      return sortDirection.value === 'asc'
        ? result
        : -result

    }
  )


  return rows

})


/*
|--------------------------------------------------------------------------
| Full name
|--------------------------------------------------------------------------
*/

function fullName(
  player: Player
): string {

  const person =
    player.person


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


/*
|--------------------------------------------------------------------------
| Sort value
|--------------------------------------------------------------------------
*/

function getSortValue(
  player: Player
): string | number {

  switch (sortColumn.value) {


    /*
    |--------------------------------------------------------------------------
    | Updated at
    |--------------------------------------------------------------------------
    */

    case 'updated_at':

      return player.updated_at
        ? new Date(
            player.updated_at
          ).getTime()
        : 0


    /*
    |--------------------------------------------------------------------------
    | Name
    |--------------------------------------------------------------------------
    */

    case 'name':

      return fullName(player)


    /*
    |--------------------------------------------------------------------------
    | Gender
    |--------------------------------------------------------------------------
    */

    case 'gender':

      return player.person?.gender ?? ''


    /*
    |--------------------------------------------------------------------------
    | Date of birth
    |--------------------------------------------------------------------------
    */

    case 'dob':

      return player.person?.dob ?? ''


    /*
    |--------------------------------------------------------------------------
    | Preferred name
    |--------------------------------------------------------------------------
    */

    case 'preferred_name':

      return player.preferred_name ?? ''


    /*
    |--------------------------------------------------------------------------
    | Preferred foot
    |--------------------------------------------------------------------------
    */

    case 'preferred_foot':

      return player.preferred_foot ?? ''


    /*
    |--------------------------------------------------------------------------
    | Height
    |--------------------------------------------------------------------------
    */

    case 'height_cm':

      return player.height_cm ?? 0

  }

}


/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

const pages = computed(() =>

  Math.max(

    1,

    Math.ceil(

      filtered.value.length /
      perPage.value

    )

  )

)


/*
|--------------------------------------------------------------------------
| Keep page within range
|--------------------------------------------------------------------------
*/

watch(
  pages,

  value => {

    if (page.value > value) {

      page.value = value

    }

  }
)


/*
|--------------------------------------------------------------------------
| Starting row
|--------------------------------------------------------------------------
*/

const start = computed(() =>

  (page.value - 1) *
  perPage.value

)


/*
|--------------------------------------------------------------------------
| Current page
|--------------------------------------------------------------------------
*/

const paginatedPlayers = computed(() =>

  filtered.value.slice(

    start.value,

    start.value +
    perPage.value

  )

)


/*
|--------------------------------------------------------------------------
| Sort column
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Sort icon
|--------------------------------------------------------------------------
*/

function sortIcon(
  column: SortColumn
) {

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