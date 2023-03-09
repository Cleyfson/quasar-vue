<template>
  <div class="flex column flex-center">
    <q-card class="q-mb-md my-card flex row" v-for="usuario in usuarios" :key="usuario.id">
      <q-card-section>
        <q-avatar rounded>
          <img size="5rem" :src="usuario.avatar">
        </q-avatar>
      </q-card-section>

      <q-card-section>
        <div class="text-h6">
          {{ `${usuario.first_name} ${usuario.last_name}` }}
        </div>
        <div class="text-subtitle2"> {{ usuario.email }}  </div>
      </q-card-section>
      <q-card-section>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { mapState } from 'vuex'

export default defineComponent({
  name: 'UserCard',

  computed: {
    ...mapState('usuarios', ['usuarios'])
  }
})
</script>

<style lang='sass' scoped>
  .my-card
    width: 35em

</style>
