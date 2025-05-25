<!-- Landing Page -->
<template>
  <div class="min-h-screen flex flex-col bg-[#03262B]">
    <LandingHeader 
      @trigger-login="showLogin = true"
      @trigger-signup="showSignUp = true"
      @search-login-required="showLogin = true; showLoginWarning = true; loginNotice = 'Please log in first to search.'"
    />

    <!-- Login Overlay -->
    <div v-if="showLogin" class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.6)] flex items-center justify-center">
      <LoginForm
      :showWarning="showLoginWarning"
      :loginNotice="loginNotice"
      @close="showLogin = false; showLoginWarning = false"
      @trigger-signup="showLogin = false; showSignUp = true; showLoginWarning = false"/>
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
        <button
          @click="carouselRef?.prev()"
          class="absolute left-30 z-10 transform -translate-x-full hover:scale-105 transition"
        >
          <img
            src="@/assets/images/Circle_Carret_Right.png"
            alt="Left"
            class="w-20 h-20 rotate-180"
          />
        </button>

        <!-- Carousel -->
        <Carousel v-bind="carouselConfig" class="w-full" ref="carouselRef">
          <Slide v-for="skill in skills" :key="skill.label">
            <div class="relative flex flex-col items-center">
              <button 
                type="button"
                class="group relative transition-transform hover:scale-105 focus:outline-none cursor-pointer"
                @click="handleSkillClick(skill.image, skill.label)"
              >
                <img 
                  :src="skill.image"
                  :alt="skill.label"
                  class="w-90 h-90 rounded-2xl shadow-lg"
                />
              </button>
              <div
                class="font-roboto text-xl absolute -bottom-5 font-bold px-6 py-2 rounded-full shadow-md bg-[#6EA1AA] text-white"
              >
                {{ skill.label }}
              </div>
            </div>
          </Slide>
        </Carousel>

        <!-- Right Arrow -->
        <button
          @click="carouselRef?.next()"
          class="absolute right-30 z-10 transform translate-x-full hover:scale-115 transition"
        >
          <img
            src="@/assets/images/Circle_Carret_Right.png"
            alt="Right"
            class="w-20 h-20"
          />
        </button>
      </section>
    </main>

    <LandingFooter />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Carousel, Slide } from 'vue3-carousel'
import { useRouter } from 'vue-router'
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
const showLoginWarning = ref(false)
const loginNotice = ref("Please log in first to explore skill categories.")

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

const router = useRouter()

const handleSkillClick = (skillImage, skillLabel) => {
  showLoginWarning.value = true
  showLogin.value = true
}
</script>

<style scoped>
:deep(.carousel__viewport) {
  perspective: 1000px;
}

:deep(.carousel__track) {
  padding: 20px 0;
  display: flex;
  align-items: stretch;
}

:deep(.carousel__slide) {
  padding: 0 10px;
  height: 100%;
  display: flex;
  align-items: stretch;
}

:deep(.carousel__slide > div) {
  height: 100%;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: stretch;
  margin: 0 auto;
}

</style>