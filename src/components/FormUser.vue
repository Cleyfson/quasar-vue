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

import { mapActions } from 'vuex'

export default {
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
        id: this.id,
        nome: this.nome,
        funcao: ''
      }
    }
  },

  props: {
    id: Number,
    nome: String,
    showModal: Function
  },

  methods: {
    ...mapActions('usuarios', ['criarUsuario', 'alterarUsuario']),
    onSubmit () {
      if (this.form.id === null) {
        if (this.form.nome !== null && this.form.funcao !== null) {
          this.criarUsuario(this.form)
            .then(
              this.usuarioCriadoSucesso(),
              this.showModal()
            ).catch((error) => {
              this.showError(error)
            })
        } else {
          this.showError('Nome e Função são campos obrigatórios')
        }
      } else {
        try {
          this.alterarUsuario(this.form)
        } catch (error) {
          this.showError(error)
        } finally {
          this.showModal()
          this.usuarioAlteradoSucesso()
        }
      }
    },
    onReset () {
      this.form.id = null
      this.form.nome = null
      this.form.funcao = null
    },
    usuarioAlteradoSucesso () {
      this.$q.notify({
        message: 'Usuário alterado com sucesso',
        color: 'purple'
      })
    },
    usuarioCriadoSucesso () {
      this.$q.notify({
        message: 'Usuário criado com sucesso',
        color: 'purple'
      })
    },
    showError (error) {
      this.$q.notify({
        message: error,
        color: 'red'
      })
    }
  }

}
</script>
