<template>
  <div class="flex justify-around q-mx-md" style="min-height: 60vh; gap: 3rem;">
    <q-card class="my-card flex row justify-between" style="max-height: 10em;" v-for="(usuario) in usuarios" :key="usuario.id">

      <div class="flex row flex-center">
        <q-card-section>
          <q-avatar size="5rem" rounded>
            <img :src="usuario.avatar" />
          </q-avatar>
        </q-card-section>

        <q-card-section>
          <div class="text-h6">
            {{ `${usuario.first_name} ${usuario.last_name}` }}
          </div>
          <div class="text-subtitle2">{{ usuario.email }}</div>
        </q-card-section>
      </div>

      <q-card-section class="self-center">
        <span class="material-icons md-24 q-px-xs" v-show="(user.id_hash === usuario.id_hash) && user.role === 2 || user.role === 3" @click="editar(usuario.id_hash)"> edit </span>
        <span class="material-icons md-24 q-px-xs" v-show="user.id_hash === usuario.id_hash && user.role === 2  || user.role === 3" @click="deletar(usuario.id_hash)"> delete </span>
        <span class="material-icons md-24 q-px-xs" v-show="user.role === 2 || user.role === 3" @click="detalhes(usuario.id_hash)"> visibility </span>
      </q-card-section>

    </q-card>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
  name: 'UserCard',

  props: {
    showModal: Function,
    deletar: Function,
    fillForm: Function,
    usuarios: Array
  },

  computed: {
    ...mapState('usuarios', { user: state => state.usuario })
  },

  methods: {
    ...mapActions('usuarios', ['carregaPagina', 'buscaUsuario', 'alterarUsuario']),
    async editar (id) {
      const data = await this.buscaUsuario(id)
      this.$emit('data', data.data)
    },
    detalhes (id) {
      this.$router.push({ path: `/detalhes-usuario/${id}` })
    }
  }
}
</script>

<style lang='sass' scoped>
.my-card
  width: 35em
  max-width: 35em
</style>
