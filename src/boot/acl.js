
export default ({ router, store, Vue, app, VueAcl }) => {
  const storeVuex = store
  const acl = {
    redireciona () {
      return router.push({ name: 'Login' })
    }
  }

  router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched[0].meta.requiresAuth || false
    console.log(requiresAuth)
    const usuarioAuth = storeVuex._state.data.usuarios.token
    console.log(usuarioAuth)
    console.log(usuarioAuth === null)
    if (requiresAuth && usuarioAuth === null) {
      return next({ name: 'Login' })
    }
    return next()
  })
  app.acl = acl
  store.$acl = acl
}
