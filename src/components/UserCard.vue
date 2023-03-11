<template>
  <div class="flex column flex-center">
    <q-card class="q-mb-md my-card flex row justify-between" v-for="(user, index) in users" :key="user.id">
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
        <span class="material-icons md-24"> edit </span>
        <span class="material-icons md-24" @click="deletarUsuario(user.id, index)"> delete </span>
        <span class="material-icons md-24"> visibility </span>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { mapState, mapActions } from 'vuex'

export default defineComponent({
  name: 'UserCard',

  computed: {
    ...mapState('users', ['users'])
  },

  methods: {
    ...mapActions('users', ['deletarUsuario'])

  }
})
</script>

<style lang='sass' scoped>
.my-card
  width: 35em
  max-width: 35em
</style>
