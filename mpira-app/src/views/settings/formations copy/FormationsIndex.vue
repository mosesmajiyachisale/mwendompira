<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="dark">
        <ion-title>Formation</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">

      <div class="formation-wrapper" :style="{ '--size-x': sizeX,'--size-y': sizeY }">

        <!-- FORMATION SELECT -->
        <div class="py-1 px-2">
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


        <!-- X AXIS -->
        <div class="x-axis-wrapper">

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

        </div>


        <!-- Y AXIS + GRID -->
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


          <!-- GRID -->
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

                  <!-- SLOT -->
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

    </ion-content>
  </ion-page>
</template>


<script setup lang="ts">

import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonGrid,
  IonRow,
  IonCol,
  IonSelect,
  IonSelectOption,
  onIonViewWillEnter,
} from '@ionic/vue'

import {
  ref,
  computed, watch
} from 'vue'

import api from '@/api'


/*
|--------------------------------------------------------------------------
| Grid dimensions
|--------------------------------------------------------------------------
*/

const sizeX = ref(15)
const sizeY = ref(15)

const loading = ref(false)


/*
|--------------------------------------------------------------------------
| Interfaces
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
| State
|--------------------------------------------------------------------------
*/

const formations = ref<Formation[]>([])
const slots = ref<Slot[]>([])

const formation_id = ref<number | null>(null)


/*
|--------------------------------------------------------------------------
| Currently selected formation
|--------------------------------------------------------------------------
*/

const selectedFormation = computed<Formation | undefined>(() => {
  return formations.value.find(formation =>formation.id === formation_id.value)
})


/*
|--------------------------------------------------------------------------
| Currently selected formation slots
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Fast slot lookup
|--------------------------------------------------------------------------
*/

const slotMap = computed(() => {

  const map = new Map<string, Slot>()

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
| Get slot at grid position
|--------------------------------------------------------------------------
*/

const getSlot = (x: number,y: number): Slot | undefined => {
  return slotMap.value.get(`${x}-${y}`)

}


/*
|--------------------------------------------------------------------------
| Fetch formations
|--------------------------------------------------------------------------
*/

const fetchData = async () => {
  loading.value = true
  try {
    const { data } = await api.get('/settings/formations')
    formations.value =data?.formations ?? []
    slots.value =data?.slots ?? []

    console.log('Formations:',formations.value)

  } catch (error) {
    console.error(
      'Failed to load formations:',
      error
    )
  } finally {
    loading.value = false
  }

}


const filterSlots = async() => {
  const formation = formations.value.find(formation => formation.id === formation_id.value)
  if(formation){
    slots.value = formation?.slots || []
  }
}

/*
|--------------------------------------------------------------------------
| Load page
|--------------------------------------------------------------------------
*/

onIonViewWillEnter(() => {
  fetchData()
})

</script>

<style scoped>

/* =========================
   FORMATION
   ========================= */

.formation-wrapper {
  --axis-size: 30px;

  /*
   * Occupy the full available container width.
   * The Y-axis is included separately.
   */
  width: 100%;
  max-width: 100%;

  /*
   * Keep the formation centered when the
   * parent container is wider than the grid.
   */
  margin: 0 auto;

  /*
   * Prevent horizontal overflow.
   */
  overflow-x: hidden;
}


/* =========================
   X AXIS
   ========================= */

.x-axis-wrapper {
  display: flex;

  width: 100%;

  height: var(--axis-size);
}


.axis-corner {
  width: var(--axis-size);
  height: var(--axis-size);

  flex: 0 0 var(--axis-size);

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 9px;
  font-weight: 600;
}


.x-axis {
  /*
   * Remaining width after Y-axis.
   */
  width: calc(100% - var(--axis-size));
  height: var(--axis-size);

  display: grid;

  grid-template-columns:
    repeat(var(--size-x), minmax(0, 1fr));
}


.x-axis .axis-cell {
  min-width: 0;
  height: 100%;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 9px;
  line-height: 1;
}


/* =========================
   FORMATION BODY
   ========================= */

.formation-body {
  display: flex;

  width: 100%;
  max-width: 100%;

  /*
   * Formation maintains its width
   * inside the parent container.
   */
  overflow: hidden;
}


/* =========================
   Y AXIS
   ========================= */

.y-axis {
  width: var(--axis-size);

  /*
   * Grid height is based on the
   * available formation width.
   */
  height: var(--grid-height);

  flex: 0 0 var(--axis-size);

  display: grid;

  grid-template-rows:
    repeat(var(--size-y), minmax(0, 1fr));
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


/* =========================
   GRID AREA
   ========================= */

.home-side {
  /*
   * Use all remaining width after
   * the Y axis.
   */
  width: calc(100% - var(--axis-size));

  /*
   * Keep the formation proportional.
   */
  aspect-ratio: var(--size-x) / var(--size-y);

  height: auto;

  flex: 1 1 auto;

  min-width: 0;

  color: rgb(255, 255, 255);

  background: rgb(100, 165, 100);

  font-size: 8px;

  /*
   * Prevent the Ionic grid from
   * creating overflow.
   */
  overflow: hidden;
}


/* =========================
   INNER GRID
   ========================= */

.inner-grid {
  width: 100%;
  height: 100%;

  margin: 0;
  padding: 0;

  --ion-grid-padding: 0;
  --ion-grid-width: 100%;
}


/* =========================
   ROWS
   ========================= */

.inner-grid ion-row {
  width: 100%;

  height:
    calc(
      100% / var(--size-y)
    );

  min-height: 0;

  margin: 0;
  padding: 0;

  flex-wrap: nowrap;
}


/* =========================
   CELLS
   ========================= */

.inner-grid ion-col {
  width:
    calc(
      100% / var(--size-x)
    );

  max-width:
    calc(
      100% / var(--size-x)
    );

  height: 100%;

  min-width: 0;
  min-height: 0;

  margin: 0;
  padding: 0;

  flex:
    0 0 calc(
      100% / var(--size-x)
    );

  display: flex;

  align-items: center;
  justify-content: center;
}


/* =========================
   CHECKERBOARD
   ========================= */

.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(odd),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(even) {
  background: rgb(100, 175, 100);
}


.inner-grid ion-row:nth-child(odd)
ion-col:nth-child(even),

.inner-grid ion-row:nth-child(even)
ion-col:nth-child(odd) {
  background: rgb(75, 150, 75);
}


/* =========================
   SLOT
   ========================= */

.slot {
  /*
   * Responsive slot size.
   *
   * It scales with the formation
   * instead of remaining fixed at 22px.
   */
  width: clamp(16px, 5vw, 22px);
  height: clamp(16px, 5vw, 22px);

  max-width: 70%;
  max-height: 70%;

  display: flex;

  align-items: center;
  justify-content: center;

  border:
    1px solid
    rgba(255, 255, 255, 0.9);

  border-radius: 50%;

  background:
    rgba(100, 100, 100, 0.65);

  color: #fff;

  font-size: clamp(6px, 1.8vw, 7px);
  font-weight: 700;

  line-height: 1;
  text-align: center;

  cursor: pointer;

  user-select: none;

  flex-shrink: 0;
}


/* =========================
   MOBILE
   ========================= */

@media (max-width: 576px) {

  .formation-wrapper {
    --axis-size: 24px;

    width: 100%;
    max-width: 100%;
  }


  .x-axis-wrapper {
    height: var(--axis-size);
  }


  .axis-corner {
    width: var(--axis-size);
    height: var(--axis-size);

    flex-basis: var(--axis-size);

    font-size: 8px;
  }


  .x-axis .axis-cell,
  .y-axis .axis-cell {
    font-size: 8px;
  }


  .y-axis {
    width: var(--axis-size);

    flex-basis: var(--axis-size);
  }


  .home-side {
    width: calc(100% - var(--axis-size));
  }


  .slot {
    width: clamp(15px, 5vw, 20px);
    height: clamp(15px, 5vw, 20px);

    font-size: 6px;
  }
}


/* =========================
   VERY SMALL PHONES
   ========================= */

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