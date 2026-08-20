<template>

    <div class="stages-list my-2">

        <div class="row justify-content-between">

            <template
                v-for="tournament_type in tournament_types"
                :key="tournament_type.id"
            >

                <ion-card
                    v-if="tournament_type.stages.length > 0"
                    class="stage-card ion-no-padding"
                    color="medium"
                >

                    <ion-card-header>

                        <ion-card-title>
                            {{ tournament_type.tournament_type_name }}
                        </ion-card-title>

                        <ion-card-subtitle>
                            {{ tournament_type.tournament_type_desc }}
                        </ion-card-subtitle>

                    </ion-card-header>


                    <ion-card-content>

                        <div class="table-responsive">

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Stage</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    <tr
                                        v-for="(stage, index) in tournament_type.stages"
                                        :key="stage.id"
                                    >
                                        <td>
                                            {{ index + 1 }}
                                        </td>

                                        <td>
                                            {{ stage.stage_name }}
                                        </td>

                                        <td>
                                            {{ stage.stage_code }}
                                        </td>

                                        <td>
                                            {{ stage.stage_desc }}
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


interface Stage {
    id: number
    stage_name: string | null
    stage_code: string | null
    stage_desc: string | null
    tournament_type_id: number | null
    created_at: string | null
    updated_at: string | null
}


interface TournamentType {
    id: number
    tournament_type_name: string | null
    tournament_type_desc: string | null
    stages: Stage[]
}


const tournament_types = ref<TournamentType[]>([])

const loading = ref(false)


const fetchData = async () => {

    loading.value = true

    try {

        const { data } = await api.get('/settings/stages')

        tournament_types.value = data?.tournament_types ?? []

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false

    }
}


fetchData()

</script>


<style scoped>

.stage-card {
    width: 100%;
    margin: 0 0 0.5rem 0 !important;
    box-sizing: border-box;
}


/* Tablet and larger */
@media (min-width: 768px) {

    .stage-card {
        width: 49.5% !important;
        margin: 0 0 0.5rem 0 !important;
    }

}

</style>