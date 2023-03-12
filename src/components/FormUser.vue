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
    id: {
      type: Number
    },
    nome: {
      type: String
    },
    showModal: {
      type: Function
    }
  },

  methods: {
    ...mapActions('users', ['criarUsuario', 'alterarUsuario']),
    onSubmit () {
      console.log(this.form.id)
      if (this.form.id === null) {
        if (this.form.nome !== null && this.form.funcao !== null) {
          this.criarUsuario(this.form)
          alert('Usuário criado com sucesso \n(será trocado pelo sweet alert)')
          this.showModal()
        } else {
          alert('Nome e Função são campos obrigatórios \n(será trocado pelo sweet alert)')
        }
      } else {
        alert('Usuário alterado com sucesso \n(será trocado pelo sweet alert)')
        this.alterarUsuario(this.form)
        this.showModal()
      }
    },
    onReset () {
      this.form.id = null
      this.form.nome = null
      this.form.funcao = null
    }
  }

}
</script>
