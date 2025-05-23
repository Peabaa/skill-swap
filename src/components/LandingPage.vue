<!-- Landing Page -->
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
    <main class="flex-1 pt-22">
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

        <!-- Skill Cards Grid -->
        <div class="relative flex items-center px-28 py-12">
        <!-- Left Button -->
        <button
          class="absolute left-27 z-10 transform -translate-x-full hover:scale-105 transition"
        >
          <img
            src="@/assets/images/Circle_Carret_Right.png"
            alt="Left"
            class="w-20 h-20 rotate-180"
          />
        </button>

        <!-- Skill Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
          <div class="relative flex flex-col items-center">
            <img 
              src="@/assets/images/languageSkill.png"
              alt="Language & Communication"
              class="w-90 h-90 rounded-2xl shadow-lg"
            />
            <div class="font-roboto text-xl absolute -bottom-5 bg-[#6EA1AA] text-white font-bold px-6 py-2 rounded-full shadow-md">
              Language & Communication
            </div>
          </div>

          <div class="relative flex flex-col items-center">
            <img 
              src="@/assets/images/musicSkill.png"
              alt="Music & Performance"
              class="w-90 h-90 rounded-2xl shadow-lg"
            />
            <div class="font-roboto text-xl absolute -bottom-5 bg-[#6EA1AA] text-white font-bold px-6 py-2 rounded-full shadow-md">
              Music & Performance
            </div>
          </div>

          <div class="relative flex flex-col items-center">
            <img 
              src="@/assets/images/cookingSkill.png"
              alt="Cooking & Pastry Arts"
              class="w-90 h-90 rounded-2xl shadow-lg"
            />
            <div class="font-roboto text-xl absolute -bottom-5 bg-[#6EA1AA] text-white font-bold px-6 py-2 rounded-full shadow-md">
              Cooking & Pastry Arts
            </div>
          </div>
        </div>

        <!-- Right Button -->
        <button
          class="absolute right-27 z-10 transform translate-x-full hover:scale-115 transition"
        >
          <img
            src="@/assets/images/Circle_Carret_Right.png"
            alt="Right"
            class="w-20 h-20"
          />
        </button>
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