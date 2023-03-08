<template>
  <q-layout class="flex flex-center" view="lHh Lpr lFf">
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
    <user-card-vue></user-card-vue>
  </q-layout>
</template>

<script>
import UserCardVue from 'src/components/UserCard.vue'
import { defineComponent, ref } from 'vue'
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
