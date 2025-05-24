import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'LandingPage',
    component: () => import('@/components/LandingPage.vue'), // Shows first
    meta: { title: 'SkillSwap' }
  },
  {
    path: '/home',
    name: 'HomePage',
    component: () => import('@/components/HomePage.vue'),
    meta: { title: 'SkillSwap - Home' }
  },
  {
    path: '/search-results/:skill',
    name: 'SearchResultsPage',
    component: () => import('@/components/SearchResultsPage.vue') 
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.afterEach((to) => {
  const defaultTitle = 'SkillSwap';
  document.title = to.meta.title || defaultTitle;
});

export default router