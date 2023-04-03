<template>
  <q-card class="q-pa-md">
    <q-form @submit="submit" @reset="onReset" class="q-gutter-md">
      <q-card-section>
        <div class="text-h6">Crie um novo usuario</div>
        <div class="text-subtitle1">Preencha o seguinte formulário para criar um novo usuario.</div>
      </q-card-section>
      <div>Email </div>
      <q-input filled v-model="form.email" label="Email *" />
      <div>Nome </div>
      <q-input filled v-model="form.nome" label="Nome *" />
      <div>Password </div>
      <q-input filled v-model="form.password" label="Password *" />

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
      form: {
        id: this.newForm.id,
        nome: null,
        email: null,
        password: null
      }
    }
  },

  props: {
    newForm: Object,
    showModal: Function
  },

  methods: {
    ...mapActions('usuarios', ['criarUsuario', 'alterarUsuario']),
    submit () {
      try {
        this.onSubmit()
      } catch (error) {
        this.mensagemErro('Erro ao submeter dados do usuario', error)
      }
    },
    onSubmit () {
      if (this.form.nome !== null && this.form.funcao !== null) {
        if (this.form.id === null) {
          this.criarUsuario(this.form)
            .then((response) => {
              this.mensagemSucesso('Usuario criado com sucesso')
              this.showModal()
            }).catch((error) => {
              this.mensagemErro('Erro ao criar usuario', error)
            })
        } else {
          this.alterarUsuario(this.form)
            .then((response) => {
              this.$emit('altereUsuario', this.form)
              this.mensagemSucesso('Usuario alterado com sucesso')
              this.showModal()
            }
            ).catch((error) => {
              this.mensagemErro('Erro ao alterar usuario', error)
            })
        }
      } else {
        this.mensagemWarning('Nome e função são campos obrigatorios')
      }
    },
    onReset () {
      this.form.id = null
      this.form.nome = null
      this.form.email = null
      this.form.password = null
    }
  }
}
</script>
