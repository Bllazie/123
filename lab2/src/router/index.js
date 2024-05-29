import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/earrings',
    name: 'Earrings',
    component: () => import('@/views/EarringsPage')
  },
  {
    path: '/material',
    name: 'Material',
    component: () => import('@/views/MaterialPage'),
  },
  {
    path: '/earrings-edit/:id?',
    name: 'EarringsEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/EarringsEdit'),
  },
  {
    path: '/material-edit/:id?',
    name: 'MaterialEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/MaterialEdit'),
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: () => import('@/views/EarringsPage'),
  },
  {
    path: '/earrings-material',
    name: 'EarringsMaterial',
    component: () => import('@/views/EarringsMaterialPage')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router