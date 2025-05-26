<!-- Profile Overlay -->
<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Black semi-transparent overlay -->
    <div class="fixed inset-0 w-full h-full bg-black opacity-60 z-40"></div>
    <!-- Modal -->
    <div class="relative z-50 w-[1350px] h-[800px] bg-[rgba(255,255,255,1.0)] rounded-3xl">
      <!-- Close button -->
      <button @click="$emit('close')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <!-- Profile Image -->
      <div class="flex flex-row h-full">
        <!-- Left: Profile Info -->
        <div class="flex flex-col items-center justify-start w-[400px] pt-20 pl-50">
          <img class="w-48 h-48 rounded-full" src="@/assets/images/Pdiddy.png" alt="P Diddy" />
          <div class="mt-4 text-5xl font-bold font-roboto leading-[75px] text-[#03262B]">P Diddy</div>
          <div class="flex gap-4 mt-4">
            <!-- Skill badge -->
            <div class="relative flex items-center">
              <div class="w-28 h-10 bg-teal-950 rounded-3xl flex items-center justify-center">
                <span class="text-white text-xl font-normal font-roboto">Rapper</span>
              </div>
            </div>
            <!-- Skill badge -->
            <div class="w-36 h-10 bg-[#6EA1AA] rounded-3xl flex items-center justify-center">
              <span class="text-white text-base font-normal font-roboto">Music Producer</span>
            </div>
            <!-- Skill Badge -->
            <div class="w-36 h-10 bg-[#6EA1AA] rounded-3xl flex items-center justify-center">
              <span class="text-white text-xl font-normal font-roboto">Mogger</span>
            </div>
          </div>
          <div class="mt-5 w-100 h-0 outline outline-1 outline-offset-[-0.50px] outline-black"></div>
          <!-- Envelope Icon -->
          <div class="flex items-center gap-4 mt-10 mr-30">
            <img src="@/assets/images/EnvelopeSimple.png" alt="Envelope" class="w-14 h-14" />
            <span class="text-[#03262B] text-2xl italic font-roboto font-medium">pdiddy@gmail.com</span>
          </div>
          <!-- Phone Icon -->
          <div class="flex items-center gap-4 mt-6 mr-20 w-64">
            <img src="@/assets/images/Phone.png" alt="Phone" class="w-14 h-14" />
            <span class="text-[#03262B] text-2xl italic font-roboto font-medium whitespace-nowrap">(+63) 912 123 4567</span>
          </div>
        </div>
        <!-- Vertical Divider -->
        <div class="w-0.5 bg-black my-12 self-stretch ml-33"></div>
        <!-- Right: Placeholder for other content -->
        <div class="flex-1 p-12">
          <button
            class="w-[700px] h-44 bg-[#D9D9D9] rounded-[40px] flex items-center justify-center transition hover:bg-[#bcbcbc] focus:outline-none"
            type="button"
          >
            <span class="text-neutral-500 text-3xl font-normal font-roboto leading-9 tracking-wide">
              + Add New Skill
            </span>
          </button>
          <div class="w-[700px] h-0 outline outline-1 outline-offset-[-0.50px] outline-black mt-8"></div>
          <div class="mt-10 w-full">
            <div class="text-left text-teal-950 text-4xl font-bold font-roboto leading-[56.25px] mb-4">My Skills</div>
            <div class="relative w-[720px] mx-0 mb-8">
              <button @click="prevSkill" :disabled="currentIndex === 0" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">
                &#8249;
              </button>
              <div class="overflow-hidden">
                <div
                  class="flex transition-transform duration-300"
                  :style="{ transform: `translateX(-${currentIndex * 246}px)` }"
                >
                  <div
                    v-for="skill in mySkills"
                    :key="skill.name"
                    class="flex flex-col items-center min-w-[220px] max-w-[220px]"
                  >
                    <img :src="skill.image" :alt="skill.name" class="w-48 h-48 rounded-2xl mb-2 object-cover" />
                    <div class="text-teal-950 text-2xl font-sofiacond italic font-bold mt-2">{{ skill.name }}</div>
                  </div>
                </div>
              </div>
              <button @click="nextSkill" :disabled="currentIndex >= mySkills.length - visibleCount" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">
                &#8250;
              </button>
            </div>
            <!-- Swap History  -->
            <div class="mt-1 text-left text-teal-950 text-4xl font-bold font-roboto leading-[56.25px] mb-2">Swap History</div>
            <div class="relative w-full mx-auto mb-8">
              <button @click="prevSwap" :disabled="currentSwapIndex === 0" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">
                &#8249;
              </button>
              <div class="overflow-hidden">
                <div
                  class="flex transition-transform duration-300 gap-4 items-center"
                  :style="{ transform: `translateX(-${currentSwapIndex * 246}px)` }"
                >
                  <div v-for="swap in swapHistory" :key="swap.name" class="flex flex-row items-center min-w-[220px] max-w-[220px] p-4  rounded-lg">
                    <img class="w-16 h-16 rounded-full" :src="swap.image" :alt="swap.name" />
                    <div class="ml-4 flex flex-col">
                      <div class="text-teal-950 text-lg font-bold font-roboto">{{ swap.name }}</div>
                      <div class="text-teal-950 text-sm font-bold italic font-roboto">Skill Swapped:</div>
                      <div class ="text-teal-950 text-sm italic font-roboto" >{{ swap.skill }}</div>
                      <div class="text-teal-950 text-sm font-bold italic font-roboto">
                        Role: <span class="font-normal">{{ swap.role }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button @click="nextSwap" :disabled="currentSwapIndex >= swapHistory.length - visibleSwapCount" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">
                &#8250;
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import rappingImg from '@/assets/images/rapping.png'
import taylorSwift from '@/assets/images/taylor swift.png'

defineEmits(['close'])

const mySkills = [
  { name: 'Rapping', image: rappingImg },
  { name: 'Photography', image: rappingImg },
  { name: 'Music', image: rappingImg },
  { name: 'Cooking', image: rappingImg },
]

const currentIndex = ref(0)
const visibleCount = 3

const swapHistory = [
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Rapping',
    role: 'Student'
  },
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Singing',
    role: 'Mentor'
  },
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Dancing',
    role: 'Mentor'
  },
  
]

const currentSwapIndex = ref(0)
const visibleSwapCount = 2

function prevSkill() {
  if (currentIndex.value > 0) currentIndex.value--
}
function nextSkill() {
  if (currentIndex.value < mySkills.length - visibleCount) currentIndex.value++
}

function prevSwap() {
  if (currentSwapIndex.value > 0) currentSwapIndex.value--
}
function nextSwap() {
  if (currentSwapIndex.value < swapHistory.length - visibleSwapCount) currentSwapIndex.value++
}
</script>

<style scoped>
/* Add any component-specific styles here */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
