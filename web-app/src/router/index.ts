import { useAuthStore } from '@/stores/auth';
import { createRouter, createWebHistory } from 'vue-router'

function auth(to: any, from: any) {
  const auth = useAuthStore();
  if (!auth.user) {
    return { name: 'LoginPage' }
  }
}

 async function guest(to: any, from: any) {
  const auth = await useAuthStore();
  if (auth.user) {
    return { name: 'ProductList' }
  }
}

const routes = [
    {
        path: '/',
        component: () => import('@/views/layout/Default.vue'),
        beforeEnter: auth,
        children: [
            {
                path: '/dashboard',
                name: 'ProductList',
                component: () => import('@/views/pages/products/Dashboard.vue')
            },
            {
                path: '/products/create',
                name: 'ProductCreate',
                component: () => import('@/views/pages/products/ProductCreate.vue')
            },
            {
              path: '/products/:id',
              name: 'ProductDetail',
              component: () => import('@/views/pages/products/ProductDetail.vue')
            },
            {
              path: '/products/:id/edit',
              name: 'ProductEdit',
              component: () => import('@/views/pages/products/ProductEdit.vue')
            },
        ]
    },
    {
      path: '/',
      component: () => import('@/views/layout/Auth.vue'),
      beforeEnter: guest,
      children: [
        {
            path: '/login',
            name: 'LoginPage',
            component: () => import('@/views/pages/auth/Login.vue'),
        },
        {
            path: '/register',
            name: 'RegisterPage',
            component: () => import('@/views/pages/auth/Register.vue'),
        },
      ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(async (to, from) => {
  // if (useMainStore().selected.length) {
  //   useMainStore().toggleSelectAll([]);
  // }
  await useAuthStore().verifySession();
});

export default router