import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'ProductList',
    component: () => import('@/views/index.vue'),
  },
  // {
  //   path: '/products',
  //   name: 'ProductList',
  //   component: ProductListView,
  // },
  {
    path: '/products/:id',
    name: 'ProductDetail',
    component: () => import('@/views/products/ProductDetail.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
