<template>
  <q-layout>
    <q-page-container>
      <q-page class="window-height window-width row justify-center items-center">
        <div class="column">
          <div class="row">
            <h5 class="text-h5 text-white q-my-md">Login</h5>
          </div>
          <div class="row">
            <q-card square bordered class="q-pa-lg shadow-1">
              <q-card-section>
                <q-form @submit.stop.prevent="userLogin" class="q-gutter-md">
                  <q-input square filled clearable v-model="form.email" type="email" label="email" />
                  <q-input square filled clearable v-model="form.password" type="password" label="password" />
                  <q-btn unelevated color="primary" size="lg" class="full-width" label="Login" type="submit" />
                </q-form>
              </q-card-section>
              <q-card-section class="text-center q-pa-none">
                <p class="text-grey-6">Not reigistered? Created an Account</p>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'LoginPage',
  data () {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    ...mapActions('usuarios', ['login']),
    userLogin () {
      this.login(this.form)
    }
  }
}
</script>

<style>
.q-card {
  width: 360px;
}
</style>
