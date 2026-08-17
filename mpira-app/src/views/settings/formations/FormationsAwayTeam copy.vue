```vue
<template>

  <div
    class="formation-wrapper mb-0"
    :style="{
      '--size-x': sizeX,
      '--size-y': sizeY
    }"
  >

    <div class="formation-body">

      <!-- =================================================
           HALF PITCH CONTAINER
           DOES NOT ROTATE
           ================================================= -->

      <div class="away-side">


        <!-- =================================================
             ROTATING PITCH LAYER
             EVERYTHING INSIDE ROTATES TOGETHER
             ================================================= -->

        <div class="pitch-layer">


          <!-- =================================================
               PITCH MARKINGS
               ================================================= -->

          <div class="pitch-markings">


            <!-- FULL HALF-PITCH BORDER -->

            <div class="pitch-border"></div>


            <!-- =================================================
                 CENTRE LINE
                 RIGHT EDGE OF HALF PITCH
                 ================================================= -->

            <div class="centre-line"></div>


            <!-- =================================================
                 HALF CENTRE CIRCLE
                 ================================================= -->

            <div class="centre-circle"></div>


            <!-- CENTRE SPOT -->

            <div class="centre-spot"></div>


            <!-- =================================================
                 LEFT PENALTY AREA
                 ================================================= -->

            <div
              class="penalty-area penalty-area-left"
            ></div>


            <!-- =================================================
                 LEFT GOAL AREA
                 ================================================= -->

            <div
              class="goal-area goal-area-left"
            ></div>


            <!-- =================================================
                 LEFT PENALTY SPOT
                 ================================================= -->

            <div
              class="penalty-spot penalty-spot-left"
            ></div>


            <!-- =================================================
                 LEFT PENALTY ARC
                 ================================================= -->

            <div
              class="penalty-arc penalty-arc-left"
            ></div>


            <!-- =================================================
                 LEFT GOAL
                 ================================================= -->

            <div
              class="goal goal-left"
            ></div>


            <!-- =================================================
                 TOP LEFT CORNER ARC
                 ================================================= -->

            <div
              class="corner-arc corner-top-left"
            ></div>


            <!-- =================================================
                 BOTTOM LEFT CORNER ARC
                 ================================================= -->

            <div
              class="corner-arc corner-bottom-left"
            ></div>


          </div>


          <!-- =================================================
               FULL 16 × 15 GRID
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


                <!-- =================================================
                     PLAYER / SLOT
                     ================================================= -->

                <div
                  v-if="getSlot(x, y)"
                  class="slot"
                  :title="getSlot(x, y)?.slot_name"
                >
                  <span class="slot-text">
                    {{ getSlot(x, y)?.slot_code }}
                  </span>
                  </div>


              </ion-col>


            </ion-row>


          </ion-grid>


        </div>

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
  computed, watch
} from 'vue'

import api from '@/api'


/*
|--------------------------------------------------------------------------
| GRID DIMENSIONS
|--------------------------------------------------------------------------
|
| Full visible half-pitch:
|
| 16 columns × 15 rows
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

const formations =
  ref<Formation[]>([])

const slots =
  ref<Slot[]>([])

const formation_id =
  ref<number | null>(null)


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

    // formations.value = data?.formations ?? []
    slots.value = data?.slots ?? []


    /*
     * Automatically select first
     * formation if one exists.
     */

    if (
      formations.value.length > 0 &&
      formation_id.value === null
    ) {

      formation_id.value =
        formations.value[0].id

      slots.value = formations.value[0].slots ?? []

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

  const formation = formations.value.find(formation =>formation.id === props.formation_id)

  if (!formation) {
    return
  }

  slots.value = formation.slots ?? []

}


/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/

fetchData()

const props = defineProps<{
  formation_id: number | null
}>()

watch(
  () => props.formation_id,
  (newFormationId) => {
    filterSlots()
  },
  {
    immediate: true
  }
)

</script>



<style scoped>


/* ============================================================
   FORMATION WRAPPER
   ============================================================ */

.formation-wrapper {

  width: 100%;

  max-width: 100%;

  margin: 0;

  padding: 0;

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
   HALF PITCH
   ============================================================ */

.away-side {

  position: relative;

  flex: 1 1 auto;

  width: 100%;

  min-width: 0;

  /*
   * Half pitch ratio.
   */

  aspect-ratio: 50/54;

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
   ROTATING PITCH LAYER
   ============================================================ */

/*
 * IMPORTANT:
 *
 * This is the element that rotates.
 *
 * Both:
 *
 *   .pitch-markings
 *   .inner-grid
 *
 * are children of this element.
 *
 * Therefore they rotate together.
 */

.pitch-layer {

  position: absolute;

  inset: 0;

  width: 100%;

  height: 100%;

  transform:
    rotate(180deg);

  transform-origin:
    center center;

  box-sizing: border-box;

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

}


/* ============================================================
   HALF-PITCH BORDER
   ============================================================ */

.pitch-border {

  position: absolute;

  inset: 0;

  border:
    0px solid
    rgba(
      255,
      255,
      255,
      0.9
    );

  box-sizing: border-box;

}


/* ============================================================
   CENTRE LINE
   ============================================================ */

   
.centre-line {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  width: 1px;
  background:rgba(255,255,255,0.9);
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
   GOAL AREA
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

  /*
   * 16 COLUMNS
   */

  grid-template-columns:
    repeat(
      var(--size-x),
      minmax(0, 1fr)
    );

  /*
   * 15 ROWS
   */

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

  /*
   * Let the parent CSS grid
   * control the layout.
   */

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
}

.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(even),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(odd) {
  background:rgb(100,175,100);
}


/* ============================================================
   SLOT / PLAYER
   ============================================================ */

.slot {

  position: relative;

  z-index: 5;

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
      7px,
      1.8vw,
      10px
    );

  font-weight: 700;

  line-height: 1;

  text-align: center;

  cursor: pointer;

  user-select: none;

  flex-shrink: 0;

  box-sizing: border-box;

}

.slot-text {
  transform: rotate(180deg);
}

/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 576px) {

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

  .slot {

    width: 15px;

    height: 15px;

    font-size: 5px;

  }

}

</style>
```
