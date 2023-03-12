import MainLayout from '../layouts/MainLayout'

const routes = [
  {
    path: '/:page?',
    component: MainLayout,
    name: 'listagem-usuarios'
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
