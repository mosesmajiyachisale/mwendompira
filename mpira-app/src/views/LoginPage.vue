<template>
  <ion-page>

    <ion-content color="light" class="ion-no-padding">
      <div class="app-page">

        <div class="page-content">

          <ion-card>

            <ion-card-header>
              <ion-card-subtitle>
                Sign in to start your session
              </ion-card-subtitle>
            </ion-card-header>

            <ion-card-content>
              <form @submit.prevent="login">
                <ion-list lines="none">

                  <!-- Email -->
                  <ion-item class="ion-no-padding input-item">
                    <ion-input
                      class="login-input"
                      v-model="email"
                      fill="outline"
                      type="email"
                      placeholder="email@domain.com"
                      required
                    >
                      <ion-icon
                        slot="start"
                        :icon="mailOutline"
                        color="primary"
                      />
                    </ion-input>
                  </ion-item>


                  <!-- Password -->
                  <ion-item class="ion-no-padding input-item">
                    <ion-input
                      class="login-input"
                      v-model="password"
                      fill="outline"
                      type="password"
                      placeholder="Password"
                    >
                      <ion-icon
                        slot="start"
                        :icon="lockClosedOutline"
                        color="primary"
                      />

                      <ion-input-password-toggle slot="end" />
                    </ion-input>
                  </ion-item>


                  <!-- Button -->
                  <ion-item class="ion-no-padding">
                    <ion-button
                      type="submit"
                      size="default"
                      shape="round"
                      :disabled="loading"
                    >
                    <ion-spinner v-if="loading" name="bubbles" size="large"></ion-spinner>
                      Sign In
                    </ion-button>

                    <ion-button 
                      @click="cancel"
                      color="warning" 
                      size="default" 
                      shape="round"
                    >
                      Cancel
                    </ion-button>
                  </ion-item>

                </ion-list>
              </form>

            </ion-card-content>

          </ion-card>

        </div>

      </div>
    </ion-content>

  </ion-page>
</template>


<script setup lang="ts">
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  IonPage,
  IonContent,
  IonCard,
  IonCardHeader,
  IonCardSubtitle,
  IonCardContent,
  IonList,
  IonInput,
  IonInputPasswordToggle,
  IonButton,
  IonItem,
  IonIcon,
  IonSpinner,
} from '@ionic/vue'

import {
  mailOutline,
  lockClosedOutline
} from 'ionicons/icons'
import api from '@/api'
const router = useRouter();
const loading = ref(false)
const email = ref('')
const password = ref('')


const login = async() => {
  // loading.value = true
  console.log(email.value, password.value)

  try{
    const { data } = await api.post('/login', {
      email: email.value,
      password: password.value
    })

  }
  catch (err) {
    console.error(err)
  } 
  finally {
    loading.value = false
  }


}

const cancel = () =>{
  loading.value=false
  router.replace({
    name: 'Home',
  });
}
</script>


<style scoped>

.page-content {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  min-height: 100%;
}


ion-card {
  width: 400px;
  max-width: 90%;
  margin-left: 16px;
}


.input-item {
  margin-bottom: 8px;
}


.login-input {
  --min-height: 42px;
  --padding-top: 0;
  --padding-bottom: 0;
  font-size: 14px;
}


ion-button {
  margin-left: 16px;
}

</style>