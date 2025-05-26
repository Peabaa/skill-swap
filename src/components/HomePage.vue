<!-- Home Page -->
<template>
    <div class="min-h-screen flex flex-col"
         :style="selectedMode === 'barter' ? { backgroundColor: 'rgba(110, 161, 170, 0.44)' } : { backgroundColor: '#03262B' }">
        <HomeHeader 
          v-model:selectedMode="selectedMode"
          @logout="handleLogout"
        />
        
        <main class="flex-1 pt-22">
            <div class="relative w-full">
                <p class=" font-sofia text-[53px] text-white text-4xl italic text-shadow-lg absolute top-18 left-28">
                    Trade What You Know <br>
                    Learn What You Don't
                    </p>
                    <p class=" font-roboto text-[25px] text-white text-4xl text-shadow-lg absolute top-50 left-28">
                    Connect with your community to exchange skills. <br>
                    Teach what you're good at, learn what you've <br>
                    always wanted!
                    </p>
                    <img 
                    src="@/assets/images/landingPagePic1.png"
                    alt="Logo"
                    class="object-contain"
                />
            </div>
            <div v-if="selectedMode === 'barter'"
                 class="text-[#03262B]-950 text-[53px] text-4xl font-bold italic font-sofiacond [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] ml-[113px] mt-[25px]">
                Available Barter Chains
            </div>
            <p v-else
               class="font-sofiacond text-[53px] text-white text-4xl font- bold italic text-shadow-lg ml-[113px] mt-[25px]">
                Skill Categories
            </p>
                <!-- Skill Cards Carousel -->
                <div class="relative flex items-center px-28 py-12">
                    <button
                        @click="carouselRef?.prev()"
                        class="absolute left-27 z-10 transform -translate-x-full hover:scale-105 transition"
                    >
                        <img
                            src="@/assets/images/Circle_Carret_Right.png"
                            alt="Left"
                            class="w-20 h-20 rotate-180"
                        />
                    </button>
                    <Carousel 
                        v-bind="carouselConfig" 
                        class="w-full"
                        ref="carouselRef"
                    >
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
                                  class="font-roboto text-xl absolute -bottom-5 font-bold px-6 py-2 rounded-full shadow-md"
                                  :class="selectedMode === 'barter' ? 'bg-[#03262B] text-white' : 'bg-[#6EA1AA] text-white'"
                                >
                                    {{ skill.label }}
                                </div>
                            </div>
                        </Slide>
                    </Carousel>
                    <button
                        @click="carouselRef?.next()"
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

        <HomeFooter :selectedMode="selectedMode"/>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import HomeHeader from './homePage-components/HomeHeader.vue'
import HomeFooter from './homePage-components/HomeFooter.vue'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import 'vue3-carousel/carousel.css'

// Skills images
import languageSkill from '@/assets/images/languageSkill.png'
import musicSkill from '@/assets/images/musicSkill.png'
import cookingSkill from '@/assets/images/cookingSkill.png'

const router = useRouter()
const carouselRef = ref(null)
const selectedMode = ref('1on1')

const carouselConfig = {
    itemsToShow: 3,
    wrapAround: true,
    snapAlign: 'start',
    transition: 500,
    modelValue: 0,
    breakpoints: {
        700: {
            itemsToShow: 2,
        },
        1024: {
            itemsToShow: 3,
        }
    }
}

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

const handleSkillClick = (skillImage, skillLabel) => {
  router.push({ 
    name: 'SearchResultsPage', 
    params: { skill: skillLabel }
  })
}

const handleLogout = async () => {
  try {
    const response = await fetch('http://localhost/skillSwapPHP/logout.php', {
      method: 'POST',
      credentials: 'include', // Important: sends cookies/session ID
      headers: {
        'Content-Type': 'application/json'
      }
    })

    const result = await response.json()

    if (result.success) {
      router.push({ name: 'LandingPage' }) // Navigate to your landing route
    } else {
      console.error('Logout failed:', result.message)
    }
  } catch (error) {
    console.error('Error during logout:', error)
  }
}


</script>

<style scoped>
.skill-shift-move {
  transition: transform 0.5s ease;
}

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

:deep(.carousel__prev),
:deep(.carousel__next) {
    display: none;
}
</style>
