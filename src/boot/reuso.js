import { Notify, Loading } from 'quasar'

export default function ({ app, store, router }) {
  const reuso = {
    msgErro: '',
    objErros: '',
    mensagemErro (msg, error = '') {
      this.objErros = ''
      this.msgErro = ''
      if (error !== '' && error.response.status !== 422) {
        this.msgErro = `<br/> ${error.response.data.message} <br/> Caso persista entre em contato com o suporte (suporte@dti.ufmg.br). <br/> Status ${error.response.status} ${error.response.statusText}`
      } else if (error !== '' && error.response.status === 422) {
        this.msgErro = `<br/> ${error.response.data.message}`
      }
      Notify.create({
        message: `${msg} ${this.msgErro}`,
        color: 'negative',
        textColor: 'white',
        position: 'center',
        icon: 'report_problem',
        timeout: 10000,
        html: true,
        closeBtn: 'X'
      })
      if (error !== '' && error.response.data.message === 'Token has expired') {
        router.push({ name: 'inicio' })
      }
    },
    mensagemSucesso (msg) {
      Notify.create({
        message: msg,
        color: 'green-4',
        textColor: 'white',
        position: 'center',
        icon: 'cloud_done',
        timeout: 5000,
        html: true
      })
    },
    mensagemWarning (msg) {
      Notify.create({
        message: msg,
        color: 'warning',
        textColor: 'white',
        position: 'top',
        icon: 'cloud_done',
        timeout: 10000,
        html: true,
        closeBtn: 'X'
      })
    },

    validaEmail: function (email) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(email)
    },
    showLoading: function () {
      return Loading.show({
        message: 'Aguarde...',
        backgroundColor: 'gray-1'
      })
    },
    hideLoading: function () {
      return Loading.hide()
    },
    emailExistente (email) {
      // TODO, pegar usuarios no sistema e comparar seus emails, com email recebido para checar existencia
      // de email já existentes
      return false
    }
  }
  app.reuso = reuso
  store.$reuso = reuso
}
