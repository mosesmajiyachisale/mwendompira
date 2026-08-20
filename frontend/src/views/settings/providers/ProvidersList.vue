<template>
  <div class="providers-list">

    <!-- =========================================================
         TOOLBAR
         ========================================================= -->
    <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">

      <div class="d-flex align-items-center gap-2">

        <ion-searchbar
          v-model="search"
          placeholder="Search providers..."
          :debounce="300"
          class="provider-search"
        />

        <ion-select
          v-model="perPage"
          interface="popover"
          aria-label="Items per page"
          class="per-page-select"
        >
          <ion-select-option :value="5">5</ion-select-option>
          <ion-select-option :value="10">10</ion-select-option>
          <ion-select-option :value="25">25</ion-select-option>
          <ion-select-option :value="50">50</ion-select-option>
        </ion-select>

      </div>

      <ion-button
        router-link="/settings/providers/create"
        size="small"
      >
        <ion-icon
          slot="start"
          :icon="add"
        />
        New Provider
      </ion-button>

    </div>


    <!-- =========================================================
         TABLE
         ========================================================= -->
    <div class="table-responsive">

      <table class="table table-striped table-bordered table-hover table-sm align-middle mb-0">

        <thead>
          <tr>

            <th
              class="text-center"
              style="width: 60px;"
            >
              #
            </th>

            <th
              class="sortable"
              @click="sortBy('person')"
            >
              Provider
              <span v-if="sortColumn === 'person'">
                {{ sortDirection === 'asc' ? '▲' : '▼' }}
              </span>
            </th>

            <th
              class="sortable"
              @click="sortBy('preferred_name')"
            >
              Preferred Name
              <span v-if="sortColumn === 'preferred_name'">
                {{ sortDirection === 'asc' ? '▲' : '▼' }}
              </span>
            </th>

            <th
              class="sortable"
              @click="sortBy('professional_qualification')"
            >
              Professional Qualification
              <span v-if="sortColumn === 'professional_qualification'">
                {{ sortDirection === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            
            <th
              class="sortable"
              @click="sortBy('provider_type')"
            >
              Provider Type
              <span v-if="sortColumn === 'provider_type'">
                {{ sortDirection === 'asc' ? '▲' : '▼' }}
              </span>
            </th>

            <th
              class="sortable"
              @click="sortBy('season_started')"
            >
              Season Started
              <span v-if="sortColumn === 'season_started'">
                {{ sortDirection === 'asc' ? '▲' : '▼' }}
              </span>
            </th>

            <th
              class="text-center"
              style="width: 100px;"
            >
              Actions
            </th>

          </tr>
        </thead>

        <tbody>

          <tr
            v-for="(provider, index) in paginatedProviders"
            :key="provider.id"
          >

            <td class="text-center">
              {{ startIndex + index + 1 }}
            </td>

            <td>
              {{ fullName(provider.person) }}
            </td>

            <td>
              {{ provider.preferred_name || '-' }}
            </td>

            <td>
              {{ provider.professional_qualification?.qualification_name ?? '-' }}
            </td>
            
            <td>
              {{ provider.provider_type?.provider_type_name ?? '-' }}
            </td>

            <td>
              {{ provider.season_started?.season_code ?? '-' }}
            </td>

            <td class="text-center">

              <ion-button
                fill="clear"
                size="small"
                :router-link="`/settings/providers/${provider.id}/edit`"
                title="Edit Provider"
              >
                <ion-icon
                  :icon="pencilSharp"
                />
              </ion-button>

            </td>

          </tr>

          <tr v-if="!loading && paginatedProviders.length === 0">
            <td
              colspan="7"
              class="text-center text-muted py-4"
            >
              No providers found.
            </td>
          </tr>

          <tr v-if="loading">
            <td
              colspan="7"
              class="text-center text-muted py-4"
            >
              Loading providers...
            </td>
          </tr>

        </tbody>

      </table>

    </div>


    <!-- =========================================================
         PAGINATION
         ========================================================= -->
    <div
      v-if="totalPages > 1"
      class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2"
    >

      <div class="text-muted">
        Showing
        {{ startIndex + 1 }}
        -
        {{ endIndex }}
        of
        {{ filteredProviders.length }}
        providers
      </div>

      <div class="d-flex align-items-center gap-1">

        <ion-button
          fill="clear"
          size="small"
          :disabled="page <= 1"
          @click="page--"
        >
          Previous
        </ion-button>

        <span class="px-2">
          Page {{ page }} of {{ totalPages }}
        </span>

        <ion-button
          fill="clear"
          size="small"
          :disabled="page >= totalPages"
          @click="page++"
        >
          Next
        </ion-button>

      </div>

    </div>

  </div>
</template>

<script setup lang="ts">
import {
  computed,
  ref,
  watch,
  onMounted,
} from 'vue'

import {
  IonButton,
  IonIcon,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
} from '@ionic/vue'

import {
  add,
  pencilSharp,
} from 'ionicons/icons'

import {
  useRoute,
  useRouter,
} from 'vue-router'

import { onIonViewWillEnter } from '@ionic/vue'

import api from '@/api'


// ================================================================
// TYPES
// ================================================================

interface Person {
  id: number
  first_name: string
  middle_name?: string | null
  last_name: string
}

interface ProviderType {
  id: number
  provider_type_name: string
}

interface Qualification {
  id: number
  qualification_name: string
}

interface Season {
  id: number
  season_code: string
}

interface Provider {
  id: number
  person_id: number
  provider_code?: number | null
  preferred_name?: string | null
  professional_qualification_id?: number | null
  provider_type_id: number
  is_active: boolean

  person?: Person
  provider_type?: ProviderType
  professional_qualification?: Qualification
  season_started?: Season
}



// ================================================================
// ROUTER
// ================================================================

const route = useRoute()
const router = useRouter()


// ================================================================
// STATE
// ================================================================

const providers = ref<Provider[]>([])

const loading = ref(false)

const search = ref(
  typeof route.query.search === 'string'
    ? route.query.search
    : ''
)

const page = ref(
  Number(route.query.page) || 1
)

const perPage = ref(
  Number(route.query.perPage) || 10
)

const sortColumn = ref(
  typeof route.query.sort === 'string'
    ? route.query.sort : 'person'
)

const sortDirection = ref<'asc' | 'desc'>(
  route.query.direction === 'desc'
    ? 'desc'
    : 'asc'
)


// ================================================================
// FETCH
// ================================================================

const fetchData = async () => {
  loading.value = true
  try {
    const { data } = await api.get('/settings/providers')

    providers.value = data.providers || []
  } catch (error) {
    console.error('Failed to fetch providers:', error)
  } finally {
    loading.value = false
  }
}


// ================================================================
// HELPERS
// ================================================================

const fullName = (person?: Person) => {
  if (!person) {
    return '-'
  }

  return [
    person.first_name,
    person.middle_name,
    person.last_name,
  ]
    .filter(Boolean)
    .join(' ')
}


// ================================================================
// FILTERING
// ================================================================

const filteredProviders = computed(() => {
  const term = search.value
    .trim()
    .toLowerCase()

  if (!term) {
    return [...providers.value]
  }

  return providers.value.filter((provider) => {

    const name = fullName(provider.person)

    const providerType =
      provider.provider_type?.provider_type_name ?? ''

    const preferredName =
      provider.preferred_name ?? ''

    const qualification =
      provider.professional_qualification?.qualification_name ?? ''

    const season =
      provider.season_started?.season_code ?? ''

    return [
      name,
      providerType,
      preferredName,
      qualification,
      season,
    ]
      .join(' ')
      .toLowerCase()
      .includes(term)
  })
})


// ================================================================
// SORTING
// ================================================================

const sortedProviders = computed(() => {

  const data = [...filteredProviders.value]

  data.sort((a, b) => {

    let valueA = ''
    let valueB = ''

    switch (sortColumn.value) {

      case 'provider_type':
        valueA =
          a.provider_type?.provider_type_name ?? ''
        valueB =
          b.provider_type?.provider_type_name ?? ''
        break

      case 'preferred_name':
        valueA = a.preferred_name ?? ''
        valueB = b.preferred_name ?? ''
        break

      case 'professional_qualification':
        valueA =
          a.professional_qualification?.qualification_name ?? ''
        valueB =
          b.professional_qualification?.qualification_name ?? ''
        break

      case 'season_started':
        valueA =
          a.season_started?.season_code ?? ''
        valueB =
          b.season_started?.season_code ?? ''
        break

      case 'person':
      default:
        valueA = fullName(a.person)
        valueB = fullName(b.person)
        break
    }

    const comparison = valueA
      .toLowerCase()
      .localeCompare(valueB.toLowerCase())

    return sortDirection.value === 'asc'
      ? comparison
      : -comparison
  })

  return data
})


// ================================================================
// SORT
// ================================================================

const sortBy = (column: string) => {

  if (sortColumn.value === column) {
    sortDirection.value =
      sortDirection.value === 'asc'
        ? 'desc'
        : 'asc'
  } else {
    sortColumn.value = column
    sortDirection.value = 'asc'
  }

  page.value = 1
}


// ================================================================
// PAGINATION
// ================================================================

const totalPages = computed(() =>
  Math.max(
    1,
    Math.ceil(
      sortedProviders.value.length /
      perPage.value
    )
  )
)

const startIndex = computed(() =>
  (page.value - 1) * perPage.value
)

const endIndex = computed(() =>
  Math.min(
    startIndex.value + perPage.value,
    sortedProviders.value.length
  )
)

const paginatedProviders = computed(() =>
  sortedProviders.value.slice(
    startIndex.value,
    endIndex.value
  )
)


// ================================================================
// QUERY SYNC
// ================================================================

watch(
  [
    search,
    page,
    perPage,
    sortColumn,
    sortDirection,
  ],
  () => {

    if (page.value > totalPages.value) {
      page.value = totalPages.value
    }

    router.replace({
      query: {
        ...route.query,

        search: search.value || undefined,
        page:
          page.value > 1
            ? String(page.value)
            : undefined,

        perPage:
          perPage.value !== 10
            ? String(perPage.value)
            : undefined,

        sort:
          sortColumn.value !== 'person'
            ? sortColumn.value
            : undefined,

        direction:
          sortDirection.value !== 'asc'
            ? sortDirection.value
            : undefined,
      },
    })
  }
)


// Reset pagination when search/page size changes
watch(
  [search, perPage],
  () => {
    page.value = 1
  }
)


// ================================================================
// INITIAL LOAD
// ================================================================

fetchData()

</script>

<style scoped>
.providers-list {
  width: 100%;
}

.provider-search {
  width: 300px;
  padding: 0;
}

.per-page-select {
  width: 90px;
}

.sortable {
  cursor: pointer;
  user-select: none;
  white-space: nowrap;
}

.sortable:hover {
  text-decoration: underline;
}

table {
  font-size: 0.875rem;
}

th {
  white-space: nowrap;
}

td {
  vertical-align: middle;
}
</style>