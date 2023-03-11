<template>
  <q-layout class="flex column" view="lHh Lpr lFf">
    <q-banner class="q-mb-xl bg-primary text-white">
      <template v-slot:action>
        <q-btn flat color="white" label="Dismiss" />
        <q-btn flat color="white" label="Novo Usuario" @click="showModal" />
      </template>
    </q-banner>
    <q-dialog v-model="opened">
      <form-user></form-user>
    </q-dialog>
    <user-card-vue>
    </user-card-vue>
    <div class="flex flex-center q-gutter-xl">
      <q-btn @click="voltar(this.page)" color="primary" icon="navigate_before" />
      <q-btn @click="seguir(this.page, this.totalPages)" color="primary" icon="navigate_next" />
    </div>
  </q-layout>
</template>

<script>
import UserCardVue from 'src/components/UserCard.vue'
import FormUser from 'src/components/FormUser.vue'
import { defineComponent } from 'vue'
import { mapActions, mapState } from 'vuex'

export default defineComponent({
  name: 'MainLayout',

  data () {
    return {
      opened: false
    }
  },

  computed: {
    ...mapState('users', ['users', 'page', 'totalPages'])
  },

  components: {
    UserCardVue,
    FormUser
  },

  methods: {
    ...mapActions('users', ['carregaPagina', 'buscaUsuario', 'deletarUsuario']),
    voltar (page) {
      const previousPage = (page > 1) ? (page - 1) : page
      this.$router.push({ path: `/${previousPage}` })
      // this.carregaPagina(previousPage)
    },
    seguir (page, total) {
      const nextPage = (page < total) ? (page + 1) : page
      this.$router.push({ path: `/${nextPage}` })
      // this.carregaPagina(nextPage)
    },
    showModal: function () {
      this.opened = true
    }
  },

  mounted () {
    const page = this.$route.params.page
    this.carregaPagina(page)
  }
})
</script>

<style lang="sass" scoped>
</style>
