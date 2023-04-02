import axios from 'axios'
const LoginLog = function () {
  if (window.sessionStorage.getItem('vuex')) {
    const usuarioLog = JSON.parse(window.sessionStorage.getItem('vuex'))
    return usuarioLog?.storeUsuario?.usuario?.login
  }
  return '-'
}
const registraLogError = function (formLog) {
  if (formLog?.config?.url?.includes('logApi') || formLog?.config?.url?.includes('logError') || formLog?.config?.url?.includes('logWarn')) {
    console.log('Erro na api logError para registro de Log')
    return
  }
  axios({
    method: 'post',
    url: `${process.env.API}/logError`,
    data: { msg: formLog }
  }).then((response) => {
    console.log('Log registrado Error')
  }).catch((error) => {
    console.log(error)
  })
}
const registraLogWarn = function (formLog) {
  if (formLog?.config?.url?.includes('logApi') || formLog?.config?.url?.includes('logError') || formLog?.config?.url?.includes('logWarn')) {
    console.log('Erro na api logWarn para registro de Log')
    return
  }
  axios({
    method: 'post',
    url: `${process.env.API}/logWarn`,
    data: { msg: formLog }
  }).then((response) => {
    console.log('Log registrado Warn')
  }).catch((error) => {
    console.log(error)
  })
}
const registraLogApi = function (formLog) {
  if (formLog?.config?.url?.includes('logApi') || formLog?.config?.url?.includes('logError') || formLog?.config?.url?.includes('logWarn')) {
    console.log('Erro na api para registro de Log')
    return
  }
  const url = window.location.href
  axios({
    method: 'post',
    url: `${process.env.API}logApi`,
    data: { msg: { url, login: LoginLog(), error: formLog, response: formLog?.response } }
  }).then((response) => {
    console.log('Log registrado Api')
  }).catch((error) => {
    console.log(error)
  })
}
export default ({ store, router, app }) => {
  app.config.errorHandler = function (err, vm, info) {
    const url = window.location.href
    const msg = `ErrorLog ${LoginLog()}: ${err.toString()}\n\nInfo: ${info} ${err.stack}\n\nUrl: ${url}`
    console.error(err)
    registraLogError(msg)
  }
  app.config.warnHandler = function (msg, vm, trace) {
    const url = window.location.href
    const wmsg = `WarnLog ${LoginLog()}: ${msg}\n\nTrace: ${trace}\n\nUrl: ${url}`
    console.warn(wmsg)
    registraLogWarn(wmsg)
  }
}
axios.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    registraLogApi(error)
    return Promise.reject(error)
  })
