<template>

    <div class="slots-list my-2">

        <div class="row justify-content-between">
            <template v-for="(position,counter) in positions" :key="position.id" >
                <ion-card
                    v-if="position.slots.length > 0"
                    class="slot-card ion-no-padding"
                    color="medium"
                >

                    <ion-card-header>

                        <ion-card-title>
                           {{ counter + 1 }}. {{ position.position_name }}
                        </ion-card-title>

                        <ion-card-subtitle>
                            {{ position.position_desc }}
                        </ion-card-subtitle>

                    </ion-card-header>


                    <ion-card-content>

                        <div class="table-responsive">

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Slot</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    <tr
                                        v-for="(slot, index) in position.slots"
                                        :key="slot.id"
                                    >
                                        <td>
                                           {{ counter + 1}}.{{ index + 1 }}
                                        </td>

                                        <td>
                                            {{ slot.slot_name }}
                                        </td>

                                        <td>
                                            {{ slot.slot_code }}
                                        </td>

                                        <td>
                                            {{ slot.slot_desc }}
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </ion-card-content>

                </ion-card>

            </template>
        </div>

    </div>

</template>

<script setup lang="ts">

import { ref } from 'vue'
import api from '@/api'

import {
    IonCard,
    IonCardHeader,
    IonCardContent,
    IonCardTitle,
    IonCardSubtitle
} from '@ionic/vue'
import FormationsHomeTeam from '../formations/FormationsHomeTeam.vue'
import PositionSlots from '../formations/PositionSlots.vue'


interface Slot {
    id: number
    slot_name: string | null
    slot_code: string | null
    slot_desc: string | null
    grid_x: number | null
    grid_y: number | null
    position_id: number | null
    created_at: string | null
    updated_at: string | null
}


interface Position {
    id: number
    position_name: string | null
    position_code: string | null
    position_desc: string | null
    slots: Slot[]
}
const formation_id = ref(null)
const positions = ref<Position[]>([])
const loading = ref(false)


const fetchData = async () => {
    loading.value = true
    try {
        const { data } = await api.get('/settings/positions')
        positions.value = data?.positions ?? []
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}


fetchData()

</script>


<style scoped>

.slot-card {
    width: 100%;
    margin: 0 0 0.5rem 0 !important;
    box-sizing: border-box;
}


/* Tablet and larger */
@media (min-width: 768px) {

    .slot-card {
        width: 49.5% !important;
        margin: 0 0 0.5rem 0 !important;
    }

}

</style>