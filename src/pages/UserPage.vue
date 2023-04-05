<template>
  <q-layout v-if="user" view="hHr LpR lFf" class="flex flex-center column q-gutter-md q-py-md">
    <q-card class="my-card" style="border: 1px solid black; max-width: 25rem;">
      <q-img width="100%" :src="user.avatar" />
      <q-card-section>
        <div class="row no-wrap items-center">
          <div class="col text-h6 ellipsis">
            {{ user.first_name }} {{ user.last_name }}
          </div>
        </div>
        <div class="text-subtitle1">
          {{ user.email }}
        </div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        <div class="text-subtitle2">
          Link do avatar: <a :href="user.avatar">{{ user.avatar }}</a>
        </div>
      </q-card-section>

      <q-separator />

      <q-card-section class="flex flex-center">
        <q-btn @click="voltar" size="22px" class="q-px-xl q-py-xs" color="primary" label="voltar" />
      </q-card-section>
    </q-card>
    <q-card v-for="endereco in enderecos" :key="endereco.id">
      <q-card-section>
        <div class="text-subtitle2">
          Logadrouro: {{ endereco.rua }}
        </div>
        <div class="text-subtitle2">
          Cidade: {{ endereco.cidade }}
        </div>
        <div class="text-subtitle2">
          Estado: {{ endereco.estado }}
        </div>
        <div class="text-subtitle2">
          Bairro: {{ endereco.cep }}
        </div>
      </q-card-section>
    </q-card>
    <q-btn @click="showModal" size="22px" class="q-px-xl q-py-xs" color="primary" label="Adicionar Endereco" />
  </q-layout>
  <q-dialog v-model="opened">
    <form-address :form="form" @getCep="getCep" @submit="submit"></form-address>
  </q-dialog>
</template>

<script>
import { mapActions } from 'vuex'
import FormAddress from 'src/components/FormAddress.vue'

export default {
  name: 'UserPage',
  data () {
    return {
      enderecos: null,
      user: null,
      form: {
        rua: null,
        cidade: null,
        estado: null,
        bairro: null,
        cep: null,
        user_id: this.$route.params.id
      },
      opened: null
    }
  },
  components: {
    FormAddress
  },
  methods: {
    ...mapActions('usuarios', ['buscaUsuario']),
    ...mapActions('enderecos', ['carregaEnderecos', 'criarEndereco']),
    async editar (id) {
      const response = await this.buscaUsuario(id)
      this.user = await response.data
    },
    async getUsuario (id) {
      const response = await this.buscaUsuario(id)
      this.user = response.data
    },
    async getEnderecos (idHash) {
      const response = await this.carregaEnderecos(idHash)
      this.enderecos = response.data.data
    },
    showModal: function () {
      if (this.opened === true) {
        (this.opened = false)
      } else {
        (this.opened = true)
      }
    },
    getCep (data) {
      this.buscaCep(data)
    },
    async submit () {
      this.criarEndereco(this.form)
      this.editar(this.$route.params.id)
      this.showModal()
    },
    voltar () {
      this.$router.go(-1)
    },
    async buscaCep (cep) {
      if (cep.length === 8) {
        const url = 'https://viacep.com.br/ws/' + cep + '/json/'
        try {
          const response = await this.$axios.get(`${url}`)
          const retorno = response.data
          if (!retorno.cep) {
            this.mensagemErro('Erro ao buscar cep')
            return
          }
          this.form.rua = retorno.logradouro
          this.form.cidade = retorno.localidade
          this.form.estado = retorno.uf
          this.form.bairro = retorno.bairro
          this.form.cep = cep
        } catch (error) {
          this.mensagemErro('Erro ao buscar endereço')
        }
      }
    }
  },

  mounted () {
    const id = this.$route.params.id
    this.getUsuario(id)
    this.getEnderecos(id)
  }

}
</script>
