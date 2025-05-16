<template>
  <div class="min-h-screen flex flex-col bg-[#03262B]">
    <Header />
    <main class="flex-1">
      <!-- Page content goes here -->  
    </main>

    <Footer />
  </div>
</template>

<script>
import Footer from './landingPage-components/Footer.vue';
import Header from './landingPage-components/Header.vue'

export default {
  components: {
    Header,
    Footer
  }
}
</script>