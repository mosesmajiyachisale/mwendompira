
<template>
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
       Y AXIS + PITCH
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


    <!-- PITCH -->
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
              :title="getSlot(x, y)?.slot_name"
            >
              {{ getSlot(x, y)?.slot_code }}
            </div>

          </ion-col>

        </ion-row>

      </ion-grid>

    </div>

  </div>
</template>

<script setup lang="ts">

import { ref, computed, onMounted } from 'vue'

import {
  IonSelect,
  IonSelectOption,
  IonGrid,
  IonRow,
  IonCol,
} from '@ionic/vue'

import api from '@/api'


/*
|--------------------------------------------------------------------------
| TYPES
|--------------------------------------------------------------------------
*/

interface Slot {
  id: number
  slot_code: string
  slot_name?: string
}

interface Formation {
  id: number
  formation_name: string
  formation_desc?: string
  slots?: Slot[]
}


/*
|--------------------------------------------------------------------------
| GRID SIZE
|--------------------------------------------------------------------------
*/

const sizeX = 15
const sizeY = 15


/*
|--------------------------------------------------------------------------
| FORMATIONS
|--------------------------------------------------------------------------
*/

const formations = ref<Formation[]>([])


/*
|--------------------------------------------------------------------------
| SELECTED FORMATION
|--------------------------------------------------------------------------
*/

const formation_id = ref<number | null>(null)


/*
|--------------------------------------------------------------------------
| FILTERED SLOTS
|--------------------------------------------------------------------------
*/

const filteredSlots = ref<Slot[]>([])


/*
|--------------------------------------------------------------------------
| FORMATION POSITIONS
|--------------------------------------------------------------------------
|
| The database only stores:
|
|   formation
|   slot
|
| The visual coordinates are handled here.
|
| The pitch is 15 x 15.
|
|--------------------------------------------------------------------------
*/


interface Position {
  x: number
  y: number
}


/*
|--------------------------------------------------------------------------
| X POSITION
|--------------------------------------------------------------------------
|
| Convert a slot's side into a horizontal position.
|
*/

const getXPosition = (
  slotCode: string,
  index: number,
  count: number
): number => {

  const code = slotCode.toUpperCase()

  /*
   * Explicit left/right positions.
   */

  if (
    code.startsWith('L')
  ) {
    return Math.max(2, Math.round(sizeX * 0.25))
  }

  if (
    code.startsWith('R')
  ) {
    return Math.min(
      sizeX - 1,
      Math.round(sizeX * 0.75)
    )
  }


  /*
   * Centre position.
   */

  if (
    code === 'GK' ||
    code === 'CB' ||
    code === 'SW' ||
    code === 'CM' ||
    code === 'CDM' ||
    code === 'CAM' ||
    code === 'CF' ||
    code === 'ST'
  ) {
    return Math.ceil(sizeX / 2)
  }


  /*
   * Multiple central players.
   *
   * Spread them across the pitch.
   */

  if (count > 1) {

    const spacing = (sizeX - 5) / (count - 1)

    return Math.round(
      3 + index * spacing
    )
  }


  return Math.ceil(sizeX / 2)
}


/*
|--------------------------------------------------------------------------
| FORMATION LINES
|--------------------------------------------------------------------------
|
| Convert:
|
| 4-3-3
|
| into:
|
| 4 defenders
| 3 midfielders
| 3 forwards
|
|--------------------------------------------------------------------------
*/

const getFormationLines = (
  formationName: string
): number[] => {

  const name = formationName
    .replace(' Diamond', '')
    .trim()

  return name
    .split('-')
    .map(Number)
    .filter(value => !Number.isNaN(value))
}


/*
|--------------------------------------------------------------------------
| CLASSIFY SLOT
|--------------------------------------------------------------------------
*/

const getSlotLine = (
  slotCode: string,
  formationName: string
): number => {

  const code = slotCode.toUpperCase()

  /*
   * Goalkeeper
   */

  if (code === 'GK') {
    return 0
  }


  /*
   * Defensive positions
   */

  if (
    [
      'LB',
      'LCB',
      'CB',
      'SW',
      'RCB',
      'RB',
      'LWB',
      'RWB',
    ].includes(code)
  ) {
    return 1
  }


  /*
   * Attacking positions that are always forward.
   */

  if (
    [
      'LW',
      'RW',
      'LCF',
      'CF',
      'RCF',
      'LST',
      'ST',
      'RST',
    ].includes(code)
  ) {

    /*
     * In formations such as 4-4-2,
     * LW/RW are midfielders.
     */

    const lines = getFormationLines(formationName)

    if (
      (code === 'LW' || code === 'RW') &&
      lines.length >= 3 &&
      lines[lines.length - 1] === 2 &&
      lines[lines.length - 2] >= 4
    ) {
      return lines.length - 1
    }

    return lines.length
  }


  /*
   * Attacking midfielders.
   */

  if (
    [
      'LAM',
      'CAM',
      'RAM',
    ].includes(code)
  ) {

    const lines = getFormationLines(formationName)

    return Math.max(
      2,
      lines.length - 1
    )
  }


  /*
   * Defensive / central midfielders.
   */

  if (
    [
      'LDM',
      'CDM',
      'RDM',
      'LM',
      'CM',
      'RCM',
      'LCM',
      'RM',
    ].includes(code)
  ) {
    return 2
  }


  /*
   * Default to midfield.
   */

  return 2
}


/*
|--------------------------------------------------------------------------
| CREATE POSITION MAP
|--------------------------------------------------------------------------
*/

const positionMap = computed<Map<string, Slot>>(() => {

  const map = new Map<string, Slot>()

  const formation = formations.value.find(
    formation => formation.id === formation_id.value
  )

  if (!formation) {
    return map
  }

  const slots = filteredSlots.value

  if (!slots.length) {
    return map
  }


  /*
   * Group slots by formation line.
   */

  const lines = new Map<number, Slot[]>()

  for (const slot of slots) {

    const line = getSlotLine(
      slot.slot_code,
      formation.formation_name
    )

    if (!lines.has(line)) {
      lines.set(line, [])
    }

    lines.get(line)!.push(slot)
  }


  /*
   * Calculate Y positions.
   *
   * GK is deepest.
   *
   * Other lines are distributed
   * towards the attacking end.
   */

  const formationLines = getFormationLines(
    formation.formation_name
  )

  const totalLines = formationLines.length + 1


  for (const [line, lineSlots] of lines) {

    let y: number

    /*
     * Goalkeeper
     */

    if (line === 0) {

      y = sizeY - 1

    } else {

      /*
       * Spread remaining lines over the pitch.
       */

      const usableHeight = sizeY - 4

      const step =
        usableHeight /
        Math.max(1, totalLines - 1)

      y = Math.round(
        sizeY - 1 - (line * step)
      )

      y = Math.max(
        1,
        Math.min(sizeY, y)
      )
    }


    /*
     * Place each slot horizontally.
     */

    lineSlots.forEach(
      (slot, index) => {

        const x = getXPosition(
          slot.slot_code,
          index,
          lineSlots.length
        )

        map.set(
          `${x}-${y}`,
          slot
        )
      }
    )
  }


  return map
})


/*
|--------------------------------------------------------------------------
| GET SLOT
|--------------------------------------------------------------------------
*/

const getSlot = (
  x: number,
  y: number
): Slot | null => {

  return (
    positionMap.value.get(`${x}-${y}`)
    ?? null
  )
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

  filteredSlots.value =
    formation?.slots ?? []

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
*/

const fetchData = async () => {

  try {

    const response =
      await api.get('/settings/formations')

    formations.value =
      response.data.data ?? []


    /*
     * Automatically select first formation.
     */

    if (formations.value.length > 0) {

      formation_id.value =
        formations.value[0].id

      filterSlots()
    }

  } catch (error) {

    console.error(
      'Failed to load formations:',
      error
    )
  }
}


/*
|--------------------------------------------------------------------------
| INITIALIZE
|--------------------------------------------------------------------------
*/

onMounted(() => {
  fetchData()
})

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
