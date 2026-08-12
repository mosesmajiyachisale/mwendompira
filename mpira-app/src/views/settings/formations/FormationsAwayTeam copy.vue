```vue
<template>

  <div
    class="formation-wrapper"
    :style="{
      '--size-x': sizeX,
      '--size-y': sizeY
    }"
  >

    <!-- =====================================================
         FORMATION SELECT
         ===================================================== -->
    <div class="formation-select py-1 px-2">

      <div class="control-block">

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

    </div>


    <!-- =====================================================
         X AXIS
         ===================================================== -->
    <!-- <div class="x-axis-wrapper">

      <div class="axis-corner">
        axes
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

    </div> -->


    <!-- =====================================================
         FORMATION BODY
         ===================================================== -->
    <div class="formation-body">

      <!-- ===================================================
           Y AXIS
           =================================================== -->
      <!-- <div class="y-axis">

        <div
          v-for="y in sizeY"
          :key="`y-${y}`"
          class="axis-cell"
        >
          {{ y }}
        </div>

      </div> -->


      <!-- ===================================================
           AWAY TEAM GRID
           =================================================== -->
      <div class="away-side">

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
                :title="getSlot(x, y)?.slot_name"
              >
                {{ getSlot(x, y)?.slot_code }}
              </div>

            </ion-col>

          </ion-row>

        </ion-grid>

      </div>

    </div>

  </div>

</template>


<script setup lang="ts">

import {
  IonGrid,
  IonRow,
  IonCol,
  IonSelect,
  IonSelectOption
} from '@ionic/vue'

import {
  ref,
  computed
} from 'vue'

import api from '@/api'


/*
|--------------------------------------------------------------------------
| GRID DIMENSIONS
|--------------------------------------------------------------------------
*/

const sizeX = ref(16)

const sizeY = ref(15)


/*
|--------------------------------------------------------------------------
| LOADING
|--------------------------------------------------------------------------
*/

const loading = ref(false)


/*
|--------------------------------------------------------------------------
| TYPES
|--------------------------------------------------------------------------
*/

interface Slot {
  id: number
  slot_side: string
  slot_code: string
  slot_name: string
  grid_x: number
  grid_y: number
  slot_desc: string
  position_id: number
}

interface Formation {
  id: number
  formation_name: string
  formation_desc: string
  slots: Slot[]
}


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const formations = ref<Formation[]>([])
const slots = ref<Slot[]>([])
const formation_id = ref<number | null>(null)


/*
|--------------------------------------------------------------------------
| SELECTED FORMATION
|--------------------------------------------------------------------------
*/

const selectedFormation =
  computed<Formation | undefined>(() => {

    return formations.value.find(
      formation =>
        formation.id === formation_id.value
    )

  })


/*
|--------------------------------------------------------------------------
| SLOT MAP
|--------------------------------------------------------------------------
|
| Original database coordinates remain unchanged.
|
| Example:
|
| 1-1 => Slot
| 8-8 => Slot
| 15-15 => Slot
|
*/

const slotMap =
  computed(() => {

    const map =
      new Map<string, Slot>()

    for (const slot of slots.value) {

      map.set(
        `${slot.grid_x}-${slot.grid_y}`,
        slot
      )

    }

    return map

  })


/*
|--------------------------------------------------------------------------
| GET SLOT
|--------------------------------------------------------------------------
|
| AWAY TEAM = HOME TEAM ROTATED 180 DEGREES
|
| Original:
|
|       FRONT
|         ↑
|         |
| LEFT ←  +  → RIGHT
|         |
|         ↓
|        BACK
|
|
| Rotated 180°:
|
|        BACK
|         ↑
|         |
| RIGHT ← + → LEFT
|         |
|         ↓
|       FRONT
|
|
| Coordinate transformation:
|
| new X = sizeX - old X + 1
| new Y = sizeY - old Y + 1
|
| Since getSlot() receives the displayed
| coordinate, we reverse that transformation
| to find the original database coordinate.
|
*/

const getSlot = (
  x: number,
  y: number
): Slot | undefined => {

  const originalX =
    sizeX.value - x + 1

  const originalY =
    sizeY.value - y + 1

  return slotMap.value.get(
    `${originalX}-${originalY}`
  )

}


/*
|--------------------------------------------------------------------------
| FETCH FORMATIONS
|--------------------------------------------------------------------------
*/

const fetchData = async () => {

  loading.value = true

  try {

    const { data } =
      await api.get(
        '/settings/formations'
      )

    formations.value =
      data?.formations ?? []

    slots.value =
      data?.slots ?? []

    /*
     * Automatically select the first
     * formation if one exists.
     */
    if (
      formations.value.length > 0 &&
      formation_id.value === null
    ) {

      formation_id.value =
        formations.value[0].id

      slots.value =
        formations.value[0].slots ?? []

    }

  } catch (error) {

    console.error(
      'Failed to load formations:',
      error
    )

  } finally {

    loading.value = false

  }

}


/*
|--------------------------------------------------------------------------
| FILTER SLOTS
|--------------------------------------------------------------------------
*/

const filterSlots = () => {

  const formation =
    formations.value.find(
      formation =>
        formation.id === formation_id.value
    )

  if (!formation) {

    slots.value = []

    return

  }

  slots.value =
    formation.slots ?? []

}


/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/

fetchData()

</script>


<style scoped>

.formation-select ion-select {
  --highlight-height: 0px;
  --highlight-color-focused: transparent;
}

/* ============================================================
   FORMATION CARD
   ============================================================ */

.formation-card {

  width: 50%;

  max-width: 100%;

  height: auto;

  margin: 0;

  padding: 0;

  box-sizing: border-box;

}


/* ============================================================
   FORMATION WRAPPER
   ============================================================ */

.formation-wrapper {

  --axis-size: 30px;

  --size-x: 15;

  --size-y: 15;

  width: 100%;

  max-width: 100%;

  margin: 0;

  padding: 0;

  overflow: hidden;

  box-sizing: border-box;

}


/* ============================================================
   FORMATION SELECT
   ============================================================ */

.formation-select {

  width: 100%;

  box-sizing: border-box;

}


/* ============================================================
   X AXIS
   ============================================================ */

.x-axis-wrapper {

  display: flex;

  width: 100%;

  height: var(--axis-size);

  margin: 0;

  padding: 0;

  box-sizing: border-box;

}


/* ============================================================
   X AXIS CORNER
   ============================================================ */

.axis-corner {

  width: var(--axis-size);

  min-width: var(--axis-size);

  height: var(--axis-size);

  flex: 0 0 var(--axis-size);

  display: flex;

  align-items: center;

  justify-content: center;

  font-size: 9px;

  font-weight: 600;

  box-sizing: border-box;

}


/* ============================================================
   X AXIS
   ============================================================ */

.x-axis {

  flex: 1 1 auto;

  width: auto;

  min-width: 0;

  height: var(--axis-size);

  display: grid;

  grid-template-columns:
    repeat(
      var(--size-x),
      minmax(0, 1fr)
    );

  box-sizing: border-box;

}


/* ============================================================
   X AXIS CELLS
   ============================================================ */

.x-axis .axis-cell {

  width: 100%;

  min-width: 0;

  height: 100%;

  display: flex;

  align-items: center;

  justify-content: center;

  font-size: 9px;

  line-height: 1;

  box-sizing: border-box;

}


/* ============================================================
   FORMATION BODY
   ============================================================ */

.formation-body {

  display: flex;

  width: 100%;

  max-width: 100%;

  margin: 0;

  padding: 0;

  overflow: hidden;

  box-sizing: border-box;

}


/* ============================================================
   Y AXIS
   ============================================================ */

.y-axis {

  width: var(--axis-size);

  min-width: var(--axis-size);

  flex: 0 0 var(--axis-size);

  display: grid;

  grid-template-rows:
    repeat(
      var(--size-y),
      minmax(0, 1fr)
    );

  min-height: 0;

  margin: 0;

  padding: 0;

  box-sizing: border-box;

}


/* ============================================================
   Y AXIS CELLS
   ============================================================ */

.y-axis .axis-cell {

  width: 100%;

  min-height: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  font-size: 9px;

  line-height: 1;

  box-sizing: border-box;

}


/* ============================================================
   AWAY SIDE
   ============================================================ */

.away-side {

  flex: 1 1 auto;

  width: auto;

  min-width: 0;

  aspect-ratio: 1 / 1;

  height: auto;

  margin: 0;

  padding: 0;

  background:
    rgb(100, 165, 100);

  color:
    rgb(255, 255, 255);

  overflow: hidden;

  box-sizing: border-box;

}


/* ============================================================
   ION GRID
   ============================================================ */

.inner-grid {

  width: 100%;

  height: 100%;

  margin: 0 !important;

  padding: 0 !important;

  --ion-grid-padding: 0;

  --ion-grid-width: 100%;

  display: grid;

  grid-template-columns:
    repeat(
      var(--size-x),
      minmax(0, 1fr)
    );

  grid-template-rows:
    repeat(
      var(--size-y),
      minmax(0, 1fr)
    );

  min-width: 0;

  min-height: 0;

  box-sizing: border-box;

}


/* ============================================================
   ION ROW
   ============================================================ */

.inner-grid ion-row {

  display: contents;

}


/* ============================================================
   ION COLUMN
   ============================================================ */

.inner-grid ion-col {

  width: auto;

  max-width: none;

  height: auto;

  flex: none;

  min-width: 0;

  min-height: 0;

  margin: 0 !important;

  padding: 0 !important;

  display: flex;

  align-items: center;

  justify-content: center;

  box-sizing: border-box;

}


/* ============================================================
   GRID CELL
   ============================================================ */

.grid-cell {

  width: 100%;

  height: 100%;

  min-width: 0;

  min-height: 0;

  box-sizing: border-box;

}


/* ============================================================
   CHECKERBOARD
   ============================================================ */

.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(odd),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(even) {

  background:
    rgb(100, 175, 100);

}


.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(even),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(odd) {

  background:
    rgb(75, 150, 75);

}


/* ============================================================
   SLOT
   ============================================================ */

.slot {

  width:
    clamp(
      16px,
      5vw,
      22px
    );

  height:
    clamp(
      16px,
      5vw,
      22px
    );

  max-width: 70%;

  max-height: 70%;

  display: flex;

  align-items: center;

  justify-content: center;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  border-radius: 50%;

  background:
    rgba(
      100,
      100,
      100,
      0.65
    );

  color: #fff;

  font-size:
    clamp(
      6px,
      1.8vw,
      7px
    );

  font-weight: 700;

  line-height: 1;

  text-align: center;

  cursor: pointer;

  user-select: none;

  flex-shrink: 0;

  box-sizing: border-box;

}


/* ============================================================
   TABLET
   ============================================================ */

@media (max-width: 768px) {

  .formation-card {

    width: 100%;

  }

}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 576px) {

  .formation-wrapper {

    --axis-size: 24px;

  }

  .axis-corner {

    font-size: 8px;

  }

  .x-axis .axis-cell,
  .y-axis .axis-cell {

    font-size: 8px;

  }

  .slot {

    width:
      clamp(
        15px,
        5vw,
        20px
      );

    height:
      clamp(
        15px,
        5vw,
        20px
      );

    font-size: 6px;

  }

}


/* ============================================================
   VERY SMALL PHONES
   ============================================================ */

@media (max-width: 360px) {

  .formation-wrapper {

    --axis-size: 20px;

  }

  .axis-corner {

    font-size: 7px;

  }

  .x-axis .axis-cell,
  .y-axis .axis-cell {

    font-size: 7px;

  }

  .slot {

    width: 15px;

    height: 15px;

    font-size: 5px;

  }

}

</style>
```
