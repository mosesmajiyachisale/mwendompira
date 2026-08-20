<template>

  <div
    class="formation-body"
    :style="{
      '--size-x': sizeX,
      '--size-y': sizeY
    }"
  >

    <!-- =================================================
         PITCH MARKINGS
         ================================================= -->

    <div class="pitch-markings">

      <!-- FULL HALF-PITCH BORDER -->
      <div class="pitch-border"></div>


      <!-- =================================================
           HALF CENTRE CIRCLE
           ================================================= -->

      <div class="centre-circle"></div>

      <div class="centre-spot"></div>


      <!-- =================================================
           LEFT PENALTY AREA
           ================================================= -->

      <div class="penalty-area penalty-area-left"></div>

      <div class="goal-area goal-area-left"></div>

      <div class="penalty-spot penalty-spot-left"></div>

      <div class="penalty-arc penalty-arc-left"></div>


      <!-- =================================================
           ONE GOAL
           ================================================= -->

      <div class="goal goal-left"></div>


      <!-- =================================================
           CORNER ARCS
           ================================================= -->

      <div class="corner-arc corner-top-left"></div>

      <div class="corner-arc corner-bottom-left"></div>

    </div>


    <!-- =================================================
         FULL GRID
         ================================================= -->

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
            class="slot-content"
          >

            <ion-button
              :title="getSlot(x, y)?.slot_name"
              fill="clear"
              color="secondary"
              class="slot-button"
            >

              <ion-icon
                :icon="personSharp"
                class="slot-icon"
              />

            </ion-button>


            <span class="slot-name text-light">
              Majiya
            </span>

          </div>

        </ion-col>

      </ion-row>

    </ion-grid>

  </div>

</template>


<script setup lang="ts">

import {
  IonGrid,
  IonRow,
  IonCol,
  IonIcon,
  IonButton
} from '@ionic/vue'

import {
  ref,
  computed,
  watch
} from 'vue'

import {
  personSharp
} from 'ionicons/icons'

import api from '@/api'


/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

const props = defineProps<{
  formation_id: number | null
}>()


/*
|--------------------------------------------------------------------------
| GRID DIMENSIONS
|--------------------------------------------------------------------------
|
| Full visible half-pitch:
|
| 19 columns × 17 rows
|
*/

const sizeX = ref(19)

const sizeY = ref(17)


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
*/

const getSlot = (
  x: number,
  y: number
): Slot | undefined => {

  return slotMap.value.get(
    `${x}-${y}`
  )

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
        formation.id === props.formation_id
    )

  if (!formation) {

    slots.value = []

    return

  }

  formation_id.value =
    formation.id

  slots.value =
    formation.slots ?? []

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


    /*
     * If parent supplied a formation,
     * use that formation.
     */

    if (
      props.formation_id !== null
    ) {

      filterSlots()

    }

    /*
     * Otherwise automatically select
     * the first formation.
     */

    else if (
      formations.value.length > 0
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
| WATCH FORMATION
|--------------------------------------------------------------------------
*/

watch(
  () => props.formation_id,

  () => {

    if (
      props.formation_id !== null
    ) {

      filterSlots()

    }

  }
)


/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/

fetchData()

</script>


<style scoped>

/* ============================================================
   FORMATION BODY
   ============================================================ */

.formation-body {

  position: relative;

  display: flex;

  width: 100%;

  max-width: 100%;

  min-width: 0;

  min-height: 0;

  flex: 1 1 auto;

  margin: 0;

  padding: 0;

  overflow: hidden;

  box-sizing: border-box;

  /*
   * PITCH ASPECT RATIO
   */

  aspect-ratio: 50 / 54;

  background:
    rgb(100, 165, 100);

  color:
    rgb(255, 255, 255);

}


/* ============================================================
   PITCH MARKINGS
   ============================================================ */

.pitch-markings {

  position: absolute;

  inset: 0;

  width: 100%;

  height: 100%;

  z-index: 4;

  pointer-events: none;

  box-sizing: border-box;

  /*
   * ROTATE THE PITCH MARKINGS 180°
   */

  transform:
    rotate(180deg);

  transform-origin:
    center center;

}


/* ============================================================
   PITCH BORDER
   ============================================================ */

.pitch-border {

  position: absolute;

  inset: 0;

  border:
    0 solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  box-sizing: border-box;

}


/* ============================================================
   HALF CENTRE CIRCLE
   ============================================================ */

.centre-circle {

  position: absolute;

  width: 18%;

  aspect-ratio: 1 / 1;

  right: -9%;

  top: 50%;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  border-radius: 50%;

  transform:
    translateY(-50%);

  box-sizing: border-box;

}


/* ============================================================
   CENTRE SPOT
   ============================================================ */

.centre-spot {

  position: absolute;

  width: 1.4%;

  aspect-ratio: 1 / 1;

  right: 0;

  top: 50%;

  background:
    rgba(
      255,
      255,
      255,
      0.95
    );

  border-radius: 50%;

  transform:
    translate(
      50%,
      -50%
    );

}


/* ============================================================
   PENALTY AREA
   ============================================================ */

.penalty-area {

  position: absolute;

  top: 25%;

  width: 24%;

  height: 50%;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  box-sizing: border-box;

}


.penalty-area-left {

  left: 0;

  border-left: none;

}


/* ============================================================
   SIX-YARD BOX
   ============================================================ */

.goal-area {

  position: absolute;

  top: 37.5%;

  width: 13%;

  height: 25%;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  box-sizing: border-box;

}


.goal-area-left {

  left: 0;

  border-left: none;

}


/* ============================================================
   PENALTY SPOT
   ============================================================ */

.penalty-spot {

  position: absolute;

  width: 1.4%;

  aspect-ratio: 1 / 1;

  left: 16%;

  top: 50%;

  background:
    rgba(
      255,
      255,
      255,
      0.95
    );

  border-radius: 50%;

  transform:
    translate(
      -50%,
      -50%
    );

}


/* ============================================================
   PENALTY ARC
   ============================================================ */

.penalty-arc {

  position: absolute;

  width: 16%;

  aspect-ratio: 1 / 1;

  left: 24%;

  top: 50%;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  border-radius: 50%;

  transform:
    translate(
      -50%,
      -50%
    );

  clip-path:
    inset(
      0
      0
      0
      50%
    );

}


/* ============================================================
   GOAL
   ============================================================ */

.goal {

  position: absolute;

  top: 42.5%;

  width: 5%;

  height: 15%;

  border:
    2px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  box-sizing: border-box;

}


.goal-left {

  left: -3%;

}


/* ============================================================
   TOP LEFT CORNER ARC
   ============================================================ */

.corner-arc {

  position: absolute;

  width: 4%;

  height: 8%;

  border:
    1px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  border-radius: 50%;

}


.corner-top-left {

  top: -4%;

  left: -2%;

}


/* ============================================================
   BOTTOM LEFT CORNER ARC
   ============================================================ */

.corner-bottom-left {

  bottom: -4%;

  left: -2%;

}


/* ============================================================
   ION GRID
   ============================================================ */

.inner-grid {

  position: absolute;

  top: 0;

  right: 0;

  bottom: 0;

  left: 0;

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

  /*
   * ROTATE THE GRID 180°
   *
   * This rotates the player positions,
   * checkerboard and cells together.
   */

  transform:
    rotate(180deg);

  transform-origin:
    center center;

}


/* ============================================================
   ION ROW
   ============================================================ */

.inner-grid ion-row {

  display: contents;

  width: 100%;

  height: 100%;

  margin: 0 !important;

  padding: 0 !important;

}


/* ============================================================
   ION COLUMN
   ============================================================ */

.inner-grid ion-col {

  width: 100%;

  height: 100%;

  max-width: none;

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

  margin: 0;

  padding: 0;

  box-sizing: border-box;

}


/* ============================================================
   CHECKERBOARD
   ============================================================ */

.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(odd),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(even) {
  background:rgb(75,150,75);
  /* background:rgb(100,175,100); */
}


.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(even),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(odd) {
  background:rgb(75,150,75);
  /* background:rgb(100,175,100); */
}


/* ============================================================
   SLOT CONTENT
   ============================================================ */

.slot-content {

  position: relative;

  z-index: 10;

  display: flex;

  flex-direction: column;

  align-items: center;

  justify-content: center;

  width: 100%;

  height: 100%;

  color: #fff;

  overflow: visible;

  /*
   * IMPORTANT:
   *
   * The grid is rotated 180°.
   *
   * Rotate the player content another 180°
   * so that:
   *
   * 180° + 180° = 360°
   *
   * Therefore the player icon and text
   * remain upright/readable.
   */

  transform:
    rotate(180deg);

  transform-origin:
    center center;

}


/* ============================================================
   SLOT BUTTON
   ============================================================ */

.slot-button {

  --padding-start: 0;

  --padding-end: 0;

  --padding-top: 0;

  --padding-bottom: 0;

  --margin-start: 0;

  --margin-end: 0;

  --margin-top: 0;

  --margin-bottom: 0;

  margin: 0;

  min-width: 22px;

  min-height: 22px;

  height: 22px;

}


/* ============================================================
   SLOT ICON
   ============================================================ */

.slot-icon {

  font-size: 20px;

  margin: 0;

}


/* ============================================================
   SLOT NAME
   ============================================================ */

.slot-name {

  display: block;

  color: #fff;

  font-size: 9px;

  font-weight: 700;

  line-height: 1;

  white-space: nowrap;

  text-align: center;

  margin-top: -2px;

  overflow: visible;

}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 576px) {

  .slot-button {

    min-width: 20px;

    min-height: 20px;

    height: 20px;

  }


  .slot-icon {

    font-size: 18px;

  }


  .slot-name {

    font-size: 6px;

  }

}


/* ============================================================
   VERY SMALL PHONES
   ============================================================ */

@media (max-width: 360px) {

  .slot-button {

    min-width: 17px;

    min-height: 17px;

    height: 17px;

  }


  .slot-icon {

    font-size: 15px;

  }


  .slot-name {

    font-size: 5px;

  }

}

</style>