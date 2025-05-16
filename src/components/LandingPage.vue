<template>
  <div class="min-h-screen flex flex-col bg-[#03262B]">
    <Header 
      @trigger-login="showLogin = true"
      @trigger-signup="showSignUp = true"
    />
    <!--Login Form Overlay-->
    <div
      v-if="showLogin"
      class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.6)] flex items-center justify-center"
    >
      <LoginForm @close="showLogin = false" 
                @trigger-signup="showLogin = false; showSignUp = true"/>/>

    </div>

    <!--Sign Up Form Overlay-->
    <div
      v-if="showSignUp"
      class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.6)] flex items-center justify-center"
    >
      <SignUpForm @close="showSignUp = false" 
                  @trigger-login="showSignUp = false; showLogin = true"/>
    </div>
    <main class="flex-1">
      <!-- Page content goes here -->  
       <div class="relative w-full">
        <p class=" font-sofia text-[53px] text-white text-4xl italic text-shadow-lg absolute top-18 left-28">
          Trade What You Know <br>
          Learn What You Don’t
        </p>
        <p class=" font-roboto text-[25px] text-white text-4xl text-shadow-lg absolute top-50 left-28">
          Connect with your community to exchange skills. <br>
          Teach what you’re good at, learn what you’ve <br>
          always wanted!
        </p>
        <img 
          src="@/assets/images/landingPagePic1.png"
          alt="Logo"
          class="object-contain"
        />
       </div>
       <p class=" font-sofia text-[53px] text-white text-4xl italic text-shadow-lg ml-[113px] mt-[25px]">
          Skill Categories
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-28 py-12">
          <div class="relative flex flex-col items-center ">
            <img 
              src="@/assets/images/searchIcon.png"
              alt="Tech Skill"
              class="w-90 h-90 object-cover rounded-2xl shadow-lg"
            />
            <div class="absolute -bottom-5 bg-white text-[#03262B] font-bold px-6 py-2 rounded-full shadow-md">
              Technology
            </div>
          </div>

          

        </div>
    </main>

    <Footer />
  </div>
</template>


<script setup>
import { ref } from 'vue'
import Header from './landingPage-components/Header.vue'
import LoginForm from './landingPage-components/LoginForm.vue'
import SignUpForm from './landingPage-components/SignUpForm.vue'
import Footer from './landingPage-components/Footer.vue';

const showLogin = ref(false)
const showSignUp = ref(false)
</script>