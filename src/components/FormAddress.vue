<template>
  <q-card class="q-pa-md">
    <q-form @reset="onReset"
            @submit="onSubmit"
            class="q-gutter-md">
      <q-card-section>
        <div class="text-h6">Adicione novo endereço</div>
        <div class="text-subtitle1">Preencha o seguinte formulário para adicionar um novo endereço</div>
      </q-card-section>
      <div>CEP </div>
      <q-input filled
               v-model="cep"
               label="CEP *" />
      <div>Logradouro </div>
      <q-input filled
               v-model="forms.logradouro"
               label="Logradouro *"
               :disable="true"
               :key="this.key" />
      <div>Cidade </div>
      <q-input filled
               v-model="forms.cidade"
               label="Cidade *"
               :disable="true"
               :key="this.key" />
      <div>Estado </div>
      <q-input filled
               v-model="forms.estado"
               label="Estado *"
               :disable="true"
               :key="this.key" />
      <div>Bairro </div>
      <q-input filled
               v-model="forms.bairro"
               label="Bairro *"
               :disable="true"
               :key="this.key" />
      <div>
        <q-btn label="buscar"
               @click="onBuscar"
               color="primary" />
        <q-btn label="Submit"
               type="submit"
               color="primary" />
        <q-btn label="Reset"
               type="reset"
               color="primary"
               flat
               class="q-ml-sm" />
      </div>
    </q-form>
  </q-card>
</template>

<script>

export default {
  name: 'FormAddress',

  data () {
    return {
      forms: {
        logradouro: this.form.rua,
        cidade: this.form.cidade,
        estado: this.form.estado,
        bairro: this.form.bairro
      },
      cep: null,
      key: 1
    }
  },

  props: {
    form: Object
  },

  watch: {
    form: {
      handler (val) {
        this.forms.logradouro = this.form.rua
        this.forms.cidade = this.form.cidade
        this.forms.estado = this.form.estado
        this.forms.bairro = this.form.bairro
      },
      deep: true
    }
  },

  methods: {
    onReset () {
      this.forms.logradouro = null
      this.forms.cidade = null
      this.forms.estado = null
      this.forms.bairro = null
    },
    onSubmit () {
      this.$emit('submit')
    },
    onBuscar () {
      this.$emit('getCep', this.cep)
    }
  }

}
</script>
