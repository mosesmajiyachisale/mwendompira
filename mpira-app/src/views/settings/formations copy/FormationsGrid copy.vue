
<template>
  <div
    class="formation-wrapper"
    :style="{
      '--size-x': sizeX,
      '--size-y': sizeY
    }"
  >

    <!-- =========================================
         FORMATION SELECT
         ========================================= -->
    <div class="formation-control">

      <label class="control-block-label">
        Formation
      </label>

      <ion-select
        v-model="formation_id"
        interface="popover"
        placeholder="Select Formation"
        :required="true"
        @ionChange="filterSlots"
      >
        <ion-select-option
          v-for="formation in formations"
          :key="formation.id"
          :value="formation.id"
        >
          {{ formation.formation_name }}
        </ion-select-option>
      </ion-select>

    </div>


    <!-- =========================================
         X AXIS
         ========================================= -->
    <div class="x-axis-wrapper">

      <div class="axis-corner">
        #
      </div>

      <div class="x-axis">

        <div
          v-for="x in sizeX"
          :key="`x-${x}`"
          class="axis-cell"
        >
          {{ x }}
        </div>

      </div>

    </div>


    <!-- =========================================
         Y AXIS + FORMATION
         ========================================= -->
    <div class="formation-body">

      <!-- Y AXIS -->
      <div class="y-axis">

        <div
          v-for="y in sizeY"
          :key="`y-${y}`"
          class="axis-cell"
        >
          {{ y }}
        </div>

      </div>


      <!-- =========================================
           PITCH
           ========================================= -->
      <div class="home-side">

        <ion-grid class="inner-grid">

          <ion-row
            v-for="y in sizeY"
            :key="`row-${y}`"
          >

            <ion-col
              v-for="x in sizeX"
              :key="`cell-${x}-${y}`"
              class="grid-cell"
            >

              <div
                v-if="getSlot(x, y)"
                class="slot"
                :title="getSlot(x, y).slot_name"
              >
                {{ getSlot(x, y).slot_code }}
              </div>

            </ion-col>

          </ion-row>

        </ion-grid>

      </div>

    </div>

  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue'
import { 
  IonSelect, IonSelectOption,
  IonGrid, IonRow, IonCol

} from '@ionic/vue'
import api from '@/api'


/*
|--------------------------------------------------------------------------
| GRID SIZE
|--------------------------------------------------------------------------
|
| Keep these values here if every formation uses the same coordinate
| system. They can also be passed as props if required later.
|
*/

const sizeX = 15
const sizeY = 15


/*
|--------------------------------------------------------------------------
| FORMATIONS
|--------------------------------------------------------------------------
|
| Replace this with your API/composable data if formations are loaded
| elsewhere.
|
*/

const formations = ref([])

/*
|--------------------------------------------------------------------------
| SELECTED FORMATION
|--------------------------------------------------------------------------
*/

const formation_id = ref(null)


/*
|--------------------------------------------------------------------------
| FILTERED SLOTS
|--------------------------------------------------------------------------
|
| Contains the slots belonging to the selected formation.
|
*/

const filteredSlots = ref([])


/*
|--------------------------------------------------------------------------
| SLOT LOOKUP
|--------------------------------------------------------------------------
|
| Instead of searching the slots array for every grid cell, create
| a lookup using the coordinates.
|
| Expected slot structure:
|
| {
|   slot_code: 'GK',
|   slot_name: 'Goalkeeper',
|   x: 3,
|   y: 5
| }
|
*/

const slotMap = computed(() => {
  const map = new Map()

  for (const slot of filteredSlots.value) {
    if (
      slot.x === undefined ||
      slot.y === undefined
    ) {
      continue
    }

    map.set(
      `${slot.x}-${slot.y}`,
      slot
    )
  }

  return map
})


/*
|--------------------------------------------------------------------------
| GET SLOT
|--------------------------------------------------------------------------
*/

const getSlot = (x, y) => {
  return slotMap.value.get(`${x}-${y}`) ?? null
}


/*
|--------------------------------------------------------------------------
| FILTER FORMATION SLOTS
|--------------------------------------------------------------------------
*/

const filterSlots = () => {

  const formation = formations.value.find(
    formation => formation.id === formation_id.value
  )

  filteredSlots.value = formation?.slots ?? []

  console.log(
    'Selected formation:',
    formation?.formation_name
  )

  console.log(
    'Formation slots:',
    filteredSlots.value
  )
}


/*
|--------------------------------------------------------------------------
| LOAD FORMATIONS
|--------------------------------------------------------------------------
|
| Replace this section with your existing API request.
|
*/

const fetchData = async () => {

  
   const response = await api.get('/settings/formations')
   formations.value = response.data.data
   

}


/*
|--------------------------------------------------------------------------
| INITIALIZE
|--------------------------------------------------------------------------
*/
fetchData();
if (formation_id.value) {
    filterSlots()
}
</script>


<style scoped>

/* =========================================
   FORMATION WRAPPER
   ========================================= */

.formation-wrapper {
  width: 100%;
  max-width: 100%;
  margin: 0;
}


/* =========================================
   FORMATION CONTROL
   ========================================= */

.formation-control {
  width: 100%;
  padding: 4px 8px 8px;
}

.control-block-label {
  display: block;

  margin-bottom: 4px;

  font-size: 13px;
  font-weight: 600;
}


/* =========================================
   X AXIS
   ========================================= */

.x-axis-wrapper {
  display: flex;

  width: 100%;
  height: 30px;
}

.axis-corner {
  width: 30px;
  min-width: 30px;
  flex: 0 0 30px;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 9px;
  font-weight: 600;
}

.x-axis {
  flex: 1;

  display: grid;
  grid-template-columns: repeat(var(--size-x), 1fr);
}

.x-axis .axis-cell {
  min-width: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 9px;
  line-height: 1;
}


/* =========================================
   FORMATION BODY
   ========================================= */

.formation-body {
  display: flex;

  width: 100%;
  max-width: 100%;
}


/* =========================================
   Y AXIS
   ========================================= */

.y-axis {
  width: 30px;
  min-width: 30px;
  flex: 0 0 30px;

  display: grid;
  grid-template-rows: repeat(var(--size-y), 1fr);
}

.y-axis .axis-cell {
  width: 100%;
  min-height: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 9px;
  line-height: 1;
}


/* =========================================
   PITCH
   ========================================= */

.home-side {
  width: calc(100% - 30px);
  max-width: calc(100% - 30px);

  aspect-ratio: 1 / 0.95;

  overflow: hidden;

  color: #fff;

  background: rgb(100, 165, 100);
}


/* =========================================
   INNER ION GRID
   ========================================= */

.inner-grid {
  width: 100%;
  height: 100%;

  margin: 0;
  padding: 0;

  --ion-grid-padding: 0;
  --ion-grid-width: 100%;
}


/* =========================================
   GRID ROWS
   ========================================= */

.inner-grid ion-row {
  width: 100%;
  height: calc(100% / var(--size-y));

  margin: 0;
  padding: 0;
}


/* =========================================
   GRID CELLS
   ========================================= */

.inner-grid ion-col {
  width: calc(100% / var(--size-x));
  max-width: calc(100% / var(--size-x));

  height: 100%;

  flex: 0 0 calc(100% / var(--size-x));

  margin: 0;
  padding: 0;

  display: flex;

  align-items: center;
  justify-content: center;
}


/* =========================================
   PITCH CHECKERBOARD
   ========================================= */

.inner-grid ion-row:nth-child(odd) ion-col:nth-child(odd),
.inner-grid ion-row:nth-child(even) ion-col:nth-child(even) {
  background: rgb(100, 175, 100);
}

.inner-grid ion-row:nth-child(odd) ion-col:nth-child(even),
.inner-grid ion-row:nth-child(even) ion-col:nth-child(odd) {
  background: rgb(75, 150, 75);
}


/* =========================================
   SLOT
   ========================================= */

.slot {
  width: clamp(18px, 5vw, 24px);
  height: clamp(18px, 5vw, 24px);

  display: flex;
  align-items: center;
  justify-content: center;

  border: 1px solid rgba(255, 255, 255, 0.9);
  border-radius: 50%;

  background: rgba(80, 80, 80, 0.7);

  color: #fff;

  font-size: clamp(6px, 1.6vw, 8px);
  font-weight: 700;

  line-height: 1;
  text-align: center;

  user-select: none;
  cursor: pointer;
}


/* =========================================
   MOBILE
   ========================================= */

@media (max-width: 576px) {

  .formation-control {
    padding-left: 4px;
    padding-right: 4px;
  }

  .x-axis-wrapper {
    height: 24px;
  }

  .axis-corner,
  .y-axis {
    width: 24px;
    min-width: 24px;
    flex-basis: 24px;
  }

  .home-side {
    width: calc(100% - 24px);
    max-width: calc(100% - 24px);
  }

  .axis-corner,
  .x-axis .axis-cell,
  .y-axis .axis-cell {
    font-size: 8px;
  }

}

</style>
