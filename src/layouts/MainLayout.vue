<template>
  <q-layout class="">
    <q-banner class="q-mb-xl bg-primary text-white">
      <template v-slot:action>
        <q-btn flat color="white" label="Novo Usuario" @click="criar()" />
      </template>
    </q-banner>
    <q-dialog v-model="opened">
      <form-user :showModal="showModal" :id="id" :nome="nome"></form-user>
    </q-dialog>
    <user-card :showModal="showModal" @data="getData"></user-card>
    <div class="flex flex-center q-mt-xl q-gutter-xl">
      <q-btn @click="voltar(this.page)" color="primary" icon="navigate_before" />
      <q-btn @click="seguir(this.page, this.totalPages)" color="primary" icon="navigate_next" />
    </div>
  </q-layout>
</template>

<script>
import FormUser from 'src/components/FormUser.vue'
import UserCard from 'src/components/UserCard.vue'
import { mapActions, mapState } from 'vuex'

export default {
  name: 'MainLayout',

  data () {
    return {
      opened: false,
      id: null,
      nome: null
    }
  },

  components: {
    UserCard,
    FormUser
  },

  computed: {
    ...mapState('users', ['users', 'page', 'totalPages', 'user'])
  },

  watch: {
    '$route.params.page': {
      handler: function (page) {
        this.carregaPagina(page)
      },
      deep: true,
      immediate: true
    }
  },

  methods: {
    ...mapActions('users', ['carregaPagina', 'buscaUsuario', 'deletarUsuario']),

    voltar (page) {
      const previousPage = (page > 1) ? (page - 1) : page
      this.$router.push({ path: `/${previousPage}` })
    },
    seguir (page, total) {
      const nextPage = (page < total) ? (page + 1) : page
      this.$router.push({ path: `/${nextPage}` })
    },
    criar () {
      this.id = null
      this.nome = null
      this.showModal()
    },
    showModal: function () {
      if (this.opened === true) {
        (this.opened = false)
      } else {
        (this.opened = true)
      }
    },
    getData (data) {
      this.id = data.data.id
      this.nome = `${data.data.first_name} ${data.data.last_name}`
      this.showModal()
    }
  },

  mounted () {
    const page = this.$route.params.page
    this.carregaPagina(page)
  }

}
</script>

<style lang="sass" scoped>
</style>
