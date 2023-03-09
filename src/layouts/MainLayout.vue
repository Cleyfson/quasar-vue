<template>
  <q-layout class="flex column" view="lHh Lpr lFf">
    <q-banner class="q-mb-xl bg-primary text-white">
      <template v-slot:action>
        <q-btn flat color="white" label="Dismiss" />
        <q-btn flat color="white" label="Update Credit Card" />
      </template>
    </q-banner>
    <user-card-vue></user-card-vue>
  </q-layout>
</template>

<script>
import UserCardVue from 'src/components/UserCard.vue'
import { defineComponent } from 'vue'
import { mapActions, mapState } from 'vuex'

export default defineComponent({
  name: 'MainLayout',

  computed: {
    ...mapState('usuarios', ['usuarios'])
  },

  components: {
    UserCardVue
  },

  methods: {
    ...mapActions('usuarios', ['carregaUsuarios'])
  },

  mounted () {
    this.carregaUsuarios(1)
  }
})
</script>

<style lang="sass" scoped>

</style>
