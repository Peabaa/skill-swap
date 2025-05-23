<!-- Landing Page -->
<template>
  <div class="min-h-screen flex flex-col bg-[#03262B]">
    <LandingHeader 
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
            @click="shiftLeft"
            class="absolute left-27 z-10 transform -translate-x-full hover:scale-105 transition"
          >
            <img
              src="@/assets/images/Circle_Carret_Right.png"
              alt="Left"
              class="w-20 h-20 rotate-180"
            />
          </button>

          <!-- Skill Cards with animation -->
          <transition-group
            name="skill-shift"
            tag="div"
            class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full"
          >
            <div
              v-for="skill in skills"
              :key="skill.label"
              class="relative flex flex-col items-center"
            >
              <img 
                :src="skill.image"
                :alt="skill.label"
                class="w-90 h-90 rounded-2xl shadow-lg"
              />
              <div class="font-roboto text-xl absolute -bottom-5 bg-[#6EA1AA] text-white font-bold px-6 py-2 rounded-full shadow-md">
                {{ skill.label }}
              </div>
            </div>
          </transition-group>

          <!-- Right Button -->
          <button
            @click="shiftRight"
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

    <LandingFooter />
  </div>
</template>

<script setup>
import { ref } from 'vue'
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

const shiftLeft = () => {
  const first = skills.value.shift()
  skills.value.push(first)
}

const shiftRight = () => {
  const last = skills.value.pop()
  skills.value.unshift(last)
}

</script>

<style scoped>
.skill-shift-move {
  transition: transform 0.5s ease;
}
</style>