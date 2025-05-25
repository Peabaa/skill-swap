<!-- Landing Page -->
<template>
  <div class="min-h-screen flex flex-col bg-[#03262B]">
    <LandingHeader 
      @trigger-login="showLogin = true"
      @trigger-signup="showSignUp = true"
    />

    <!-- Login Overlay -->
    <div v-if="showLogin" class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.6)] flex items-center justify-center">
      <LoginForm @close="showLogin = false" @trigger-signup="showLogin = false; showSignUp = true"/>
    </div>

    <!-- Signup Overlay -->
    <div v-if="showSignUp" class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.6)] flex items-center justify-center">
      <SignUpForm @close="showSignUp = false" @trigger-login="showSignUp = false; showLogin = true"/>
    </div>

    <main class="flex-1 pt-22">
      <!-- Landing Banner -->
      <div class="relative w-full">
        <p class="font-sofia text-[53px] text-white text-4xl italic text-shadow-lg absolute top-18 left-28">
          Trade What You Know <br> Learn What You Don’t
        </p>
        <p class="font-roboto text-[25px] text-white text-4xl text-shadow-lg absolute top-50 left-28">
          Connect with your community to exchange skills. <br>
          Teach what you’re good at, learn what you’ve <br>
          always wanted!
        </p>
        <img src="@/assets/images/landingPagePic1.png" alt="Logo" class="object-contain" />
      </div>

      <!-- Skill Carousel Section -->
      <p class="font-sofia text-[53px] text-white text-4xl italic text-shadow-lg ml-[113px] mt-[25px]">
        Skill Categories
      </p>

      <section class="relative flex items-center px-28 py-12">
        <!-- Left Arrow -->
        <button @click="carouselRef?.prev()" class="absolute left-0 z-10 hover:scale-105 transition">
          <img src="@/assets/images/Circle_Carret_Right.png" alt="Left" class="w-20 h-20 rotate-180" />
        </button>

        <!-- Carousel -->
        <Carousel v-bind="carouselConfig" class="w-full" ref="carouselRef">
          <Slide v-for="skill in skills" :key="skill.label">
            <div class="relative flex flex-col items-center mx-4 h-[24rem]">
              <img 
                :src="skill.image"
                :alt="skill.label"
                class="w-90 h-90 rounded-2xl shadow-lg"
              />
              <div 
                class="absolute bottom-1 bg-[#6EA1AA] text-white text-center text-xl font-bold font-roboto px-5 py-2 rounded-full shadow-md"
              >
                {{ skill.label }}
              </div>
            </div>
          </Slide>
        </Carousel>

        <!-- Right Arrow -->
        <button @click="carouselRef?.next()" class="absolute right-0 z-10 hover:scale-105 transition">
          <img src="@/assets/images/Circle_Carret_Right.png" alt="Right" class="w-20 h-20" />
        </button>
      </section>
    </main>

    <LandingFooter />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/carousel.css'

import LandingHeader from './landingPage-components/LandingHeader.vue'
import LoginForm from './landingPage-components/LoginForm.vue'
import SignUpForm from './landingPage-components/SignUpForm.vue'
import LandingFooter from './landingPage-components/LandingFooter.vue'

// Skills images
import languageSkill from '@/assets/images/languageSkill.png'
import musicSkill from '@/assets/images/musicSkill.png'
import cookingSkill from '@/assets/images/cookingSkill.png'

const showLogin = ref(false)
const showSignUp = ref(false)

const skills = ref([
  {
    image: languageSkill,
    label: "Language & Communication"
  },
  {
    image: musicSkill,
    label: "Music & Performance"
  },
  {
    image: cookingSkill,
    label: "Cooking & Pastry Arts"
  }
])

const carouselRef = ref(null)

const carouselConfig = {
  itemsToShow: 3,
  wrapAround: true,
  snapAlign: 'start',
  transition: 500,
  mouseDrag: true,
  breakpoints: {
    700: {
      itemsToShow: 2,
    },
    1024: {
      itemsToShow: 3,
    }
  },
  transition: 500,
  settings: {
    autoplay: false,
    snapAlign: 'start',
    wrapAround: true,
    // disables scaling effect
    transition: 0,
  }
}
</script>