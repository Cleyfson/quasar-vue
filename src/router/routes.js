import MainLayout from '../layouts/MainLayout'
import UserPage from '../pages/UserPage'
import LoginPage from '../pages/LoginPage'

const routes = [
  {
    path: '/login',
    component: LoginPage,
    name: 'Login'
  },
  {
    path: '/:page?',
    component: MainLayout,
    name: 'listagem-usuarios'
  },
  {
    path: '/detalhes-usuario/:id',
    component: UserPage,
    name: 'detalhes-usuario'
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
