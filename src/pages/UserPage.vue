<template>
  <q-layout view="hHr LpR lFf"
            class="flex flex-center bg-cyan-7">
    <q-card v-if="user"
            class="my-card"
            style="border: 1px solid black; max-width: 25rem;">
      <q-img width="100%"
             :src="user.avatar"></q-img>
      <q-card-section>
        <div class="row no-wrap items-center">
          <div class="col text-h6 ellipsis">
            {{ user.first_name }} {{ user.last_name }}
          </div>
        </div>
        <div class="text-subtitle1">
          {{ user.email }}
        </div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        <div class="text-subtitle2">
          Link do avatar: <a :href="user.avatar">{{ user.avatar }}</a>
        </div>
      </q-card-section>

      <q-separator />

      <q-card-section class="flex flex-center">
        <q-btn @click="voltar"
               size="22px"
               class="q-px-xl q-py-xs"
               color="purple"
               label="voltar" />
      </q-card-section>
    </q-card>
    <div v-else>
      Carregando...
    </div>
  </q-layout>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'UserPage',
  data () {
    return {
      user: null
    }
  },
  methods: {
    ...mapActions('usuarios', ['buscaUsuario']),
    async editar (id) {
      const response = await this.buscaUsuario(id)
      this.user = await response.data
    },
    voltar () {
      this.$router.go(-1)
    }
  },

  mounted () {
    this.editar(this.$route.params.id)
  }

}
</script>
