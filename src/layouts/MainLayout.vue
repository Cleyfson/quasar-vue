<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

      </q-toolbar>
    </q-header>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { mapActions, mapState } from 'vuex'

export default defineComponent({
  name: 'MainLayout',

  computed: {
    ...mapState('usuarios', ['usuarios'])
  },

  components: {
  },

  methods: {
    ...mapActions('usuarios', ['carregaUsuarios'])
  },

  created () {
    this.carregaUsuarios(1)
    console.log(this.usuarios)
  },

  setup () {
    const leftDrawerOpen = ref(false)

    return {
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
})
</script>
