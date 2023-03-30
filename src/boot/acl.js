
export default ({ router, store, Vue, app, VueAcl }) => {
  const storeVuex = store
  const acl = {
    redireciona () {
      return router.push({ name: '/' })
    }
  }

  router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched[0].meta.requiresAuth || false
    const usuarioAuth = storeVuex._state.data.usuarios.token
    if (requiresAuth && usuarioAuth === null) {
      return next({ name: 'Login' })
    }
    return next()
  })
  app.acl = acl
  store.$acl = acl
}
