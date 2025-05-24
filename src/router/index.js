import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'LandingPage',
    component: () => import('@/components/LandingPage.vue') // Shows first
  },
  {
    path: '/home',
    name: 'HomePage',
    component: () => import('@/components/HomePage.vue') // display HomePage when visiting /
  },
  {
    path: '/search-results/:skill',
    name: 'SearchResultsPage',
    component: () => import('@/components/SearchResultsPage.vue') //display SearchResultsPage when visiting /search-results/:skill
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router