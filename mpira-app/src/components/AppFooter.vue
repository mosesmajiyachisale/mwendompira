<template>
  <ion-footer>
    <ion-toolbar color="dark">

      <div class="app-footer">

        <div class="footer-left">
          <strong>
            © 2014–{{ currentYear }}
            <a href="/" class="footer-link">
              Majiya Informatization Solutions
            </a>.
          </strong>
          <span>All rights reserved.</span>
        </div>

        <div class="footer-right">
          <em>Experts in digitalization</em>
        </div>

      </div>

    </ion-toolbar>
  </ion-footer>
</template>

<script setup lang="ts">
import {
  IonFooter,
  IonToolbar,
} from '@ionic/vue'

const currentYear = new Date().getFullYear()
</script>

<style scoped>
.app-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 16px;
  min-height: 44px;
  font-size: 0.9rem;
}

.footer-left {
  display: flex;
  gap: 0.35rem;
  flex-wrap: wrap;
  align-items: center;
}

.footer-right {
  font-style: italic;
}

.footer-link {
  color: var(--ion-color-primary);
  text-decoration: none;
}

.footer-link:hover {
  text-decoration: underline;
}

@media (max-width: 768px) {
  .app-footer {
    flex-direction: column;
    justify-content: center;
    text-align: center;
    gap: 4px;
    padding: 8px 16px;
  }

  .footer-right {
    order: -1;
  }
}
</style>