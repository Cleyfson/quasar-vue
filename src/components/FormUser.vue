<template>
  <q-card class="q-pa-md">
    <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
      <q-card-section>
        <div class="text-h6">Crie um novo usuario</div>
        <div class="text-subtitle1">Preencha o seguinte formulário para criar um novo usuario.</div>
      </q-card-section>
      <div>Nome do usuário </div>
      <q-input filled v-model="form.nome" label="Nome *" />

      <q-select v-model="form.funcao" :options="funcoes" label="funções" />

      <div>
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>
  </q-card>
</template>

<script>
import { defineComponent } from 'vue'
import { mapActions } from 'vuex'

export default defineComponent({
  name: 'FormUser',
  data () {
    return {
      funcoes: [
        'Desenvolvedor',
        'Gerente de Projetos',
        'Tech Lead',
        'UI/UX Designer'
      ],
      form: {
        id: null,
        nome: null,
        funcao: ''
      }
    }
  },
  methods: {
    ...mapActions('users', ['criarUsuario']),
    onSubmit () {
      if (this.form.nome !== null && this.form.funcao !== null) {
        this.criarUsuario(this.form)
        alert('Usuário criado com sucesso \n(será trocado pelo sweet alert)')
        this.$router.push({ name: 'listagem-usuarios' })
      } else {
        alert('Nome e Função são campos obrigatórios \n(será trocado pelo sweet alert)')
      }
    },

    onReset () {
      this.form.id = null
      this.form.nome = null
      this.form.funcao = null
    }
  }
})
</script>
