import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'ProductList',
    component: () => import('@/views/index.vue'),
  },
  {
    path: '/products/:id',
    name: 'ProductDetail',
    component: () => import('@/views/products/ProductDetail.vue'),
  },
  {
    path: '/products/create',
    name: 'ProductCreate',
    component: () => import('@/views/products/ProductCreate.vue'),
  },
  {
    path: '/products/:id/edit',
    name: 'ProductEdit',
    component: () => import('@/views/products/ProductEdit.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
