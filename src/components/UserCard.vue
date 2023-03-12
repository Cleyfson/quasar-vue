<template>
  <div class="flex justify-around q-mx-md" style="min-height: 60vh; gap: 3rem;">
    <q-card class="my-card flex row justify-between" v-for="(user, index) in users" :key="user.id">
      <div class="flex row flex-center">
        <q-card-section>
          <q-avatar size="5rem" rounded>
            <img :src="user.avatar" />
          </q-avatar>
        </q-card-section>

        <q-card-section>
          <div class="text-h6">
            {{ `${user.first_name} ${user.last_name}` }}
          </div>
          <div class="text-subtitle2">{{ user.email }}</div>
        </q-card-section>
      </div>
      <q-card-section class="self-center q-gutter-md">
        <span class="material-icons md-24" @click="editar(user.id)"> edit </span>
        <span class="material-icons md-24" @click="deletar(user.id, index)"> delete </span>
        <span class="material-icons md-24" @click="detalhes(user.id)"> visibility </span>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'UserCard',

  props: {
    showModal: {
      type: Function
    },
    fillForm: {
      type: Function
    }
  },

  computed: {
    ...mapState('users', ['users'])
  },

  methods: {
    ...mapActions('users', ['carregaPagina']),
    async editar (id) {
      const data = await this.buscaUsuario(id)
      this.$emit('data', data.data)
    },
    detalhes (id) {
      this.$router.push({ path: `/detalhes-usuario/${id}` })
    },
    deletar (id, index) {
      this.deletarUsuario(id, index)
    }
  }
}
</script>

<style lang='sass' scoped>
.my-card
  width: 35em
  max-width: 35em
</style>
