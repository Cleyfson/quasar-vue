<template>
  <q-layout>
    <q-page-container>
      <q-page class="bg-light-green window-height window-width row justify-center items-center">
        <div class="column">
          <div class="row">
            <h5 class="text-h5 text-white q-my-md">Login</h5>
          </div>
          <div class="row">
            <q-card square
                    bordered
                    class="q-pa-lg shadow-1">
              <q-card-section>
                <q-form @submit.stop.prevent="login" class="q-gutter-md">
                  <q-input square
                           filled
                           clearable
                           v-model="email"
                           type="email"
                           label="email" />
                  <q-input square
                           filled
                           clearable
                           v-model="password"
                           type="password"
                           label="password" />
                  <q-btn unelevated
                        color="light-green-7"
                        size="lg"
                        class="full-width"
                        label="Login"
                        type="submit" />
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
export default {
  name: 'LoginPage',
  data () {
    return {
      email: '',
      password: ''
    }
  },
  methods: {

    login () {
      const payload = {
        email: this.email,
        password: this.password
      }

      fetch('http://localhost:8000/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json'
        },
        body: JSON.stringify(payload)
      }).then((response) => response.json())
        .then((response) => console.log(response))
    }
  }
}
</script>

<style>
.q-card {
  width: 360px;
}
</style>
