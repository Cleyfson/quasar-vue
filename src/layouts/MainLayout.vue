<template>
  <q-layout class="">
    <q-banner class="q-mb-xl bg-primary text-white">
      <template v-slot:action>
        <q-btn flat color="white" label="Novo Usuario" @click="criarUsuario()" />
      </template>
    </q-banner>
    <q-dialog v-model="opened">
      <form-user :showModal="showModal" :id="id" :nome="nome"></form-user>
    </q-dialog>
    <user-card :usuarios="usuarios" :showModal="showModal" :deletar="deletar" @data="getData"></user-card>
    <div class="flex flex-center q-mt-xl q-gutter-xl">
      <q-btn @click="voltar(this.page)" color="primary" icon="navigate_before" />
      <q-btn @click="seguir(this.page, this.totalPages)" color="primary" icon="navigate_next" />
    </div>
  </q-layout>
</template>

<script>
import FormUser from 'src/components/FormUser.vue'
import UserCard from 'src/components/UserCard.vue'
import { mapActions } from 'vuex'
import { useQuasar } from 'quasar'

export default {
  name: 'MainLayout',

  setup () {
    const $q = useQuasar()

    $q.loading.show({
      delay: 400 // ms
    })

    $q.loading.hide()
  },

  data () {
    return {
      usuarios: null,
      usuariosPorPagina: null,
      pagina: null,
      totalPages: null,
      total: null,
      usuario: {
        id: null,
        nome: null
      },
      opened: null
    }
  },

  components: {
    UserCard,
    FormUser
  },

  methods: {
    ...mapActions('usuarios', ['carregaPagina', 'deletarUsuario']),

    voltar (pagina) {
      const previousPage = (pagina > 1) ? (pagina - 1) : pagina
      this.$router.push({ path: `/${previousPage}` })
      this.getUsuarios(previousPage)
    },
    seguir (pagina, total) {
      const nextPage = (pagina < total) ? (pagina + 1) : pagina
      this.$router.push({ path: `/${nextPage}` })
      this.getUsuarios(nextPage)
    },
    resetForm () {
      this.id = null
      this.nome = null
    },
    criarUsuario () {
      this.resetForm()
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
    },
    getUsuarios (pagina) {
      this.carregaPagina(pagina)
        .then((response) => {
          this.usuarios = response.data.data
          this.page = response.data.page
          this.perPage = response.data.per_page
          this.total = response.data.total
          this.totalPages = response.data.total_pages
        }).catch((error) => {
          console.log(error)
        })
    },
    deletar (id) {
      console.log('deletar')
      this.deletarUsuario(id)
        .then(
          this.usuarios = this.usuarios.filter((usuario) => usuario.id !== id)
        )
    }
  },

  mounted () {
    const pagina = this.$route.params.page
    this.getUsuarios(pagina)
  }

}
</script>

<style lang="sass" scoped>
</style>
