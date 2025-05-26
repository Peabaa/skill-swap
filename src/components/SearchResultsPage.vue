<template>
    <div class="min-h-screen flex flex-col"
        :style="selectedMode === 'barter' ? { backgroundColor: 'rgba(110, 161, 170, 0.66)' } : { backgroundColor: '#03262B' }">
        <HomeHeader v-model:selectedMode="selectedMode" />
        <main class="flex-1 pt-22">

            <!--Search Results Header-->
            <div class="container mx-auto px-4">
                <div :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'" class="text-left justify-center text-5xl font-bold italic font-sofiacond [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[50px]">
                    {{ skill }}
                </div>

                <!--Filter by-->
                <div class="flex items-center justify-between mt-[25px]">
                    <div class="flex items-center gap-4 filter-toggle">
                        <div :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'" class="text-3xl font-semibold font-roboto leading-10">
                            Filter by:
                        </div>
                        <template v-if="selectedMode === '1on1'">
                            <button
                              :class="[
                                'w-44 h-11 text-center justify-center text-2xl font-bold font-roboto leading-7 rounded-3xl',
                                selectedFilter === 'Mentors'
                                  ? selectedMode === 'barter' 
                                    ? 'bg-[#03262B] text-white border-none'
                                    : 'bg-[#6EA1AA] text-white border-none'
                                  : selectedMode === 'barter'
                                    ? 'bg-white text-[#03262B] border border-[#03262B]'
                                    : 'bg-white text-[#03262B] border border-[#6EA1AA]'
                              ]"
                              @click="selectedFilter = selectedFilter === 'Mentors' ? 'All' : 'Mentors'"
                            >
                              Mentors
                            </button>
                            <button
                              :class="[
                                'w-44 h-11 text-center justify-center text-2xl font-bold font-roboto leading-7 rounded-3xl',
                                selectedFilter === 'Students'
                                  ? selectedMode === 'barter' 
                                    ? 'bg-[#03262B] text-white border-none'
                                    : 'bg-[#6EA1AA] text-white border-none'
                                  : selectedMode === 'barter'
                                    ? 'bg-white text-[#03262B] border border-[#03262B]'
                                    : 'bg-white text-[#03262B] border border-[#6EA1AA]'
                              ]"
                              @click="selectedFilter = selectedFilter === 'Students' ? 'All' : 'Students'"
                            >
                              Students
                            </button>
                        </template>
                        <template v-else>
                            <button
                              :class="[
                                'w-44 h-11 text-center justify-center text-2xl font-bold font-roboto leading-7 rounded-3xl',
                                selectedFilter === 'Open Chains'
                                  ? selectedMode === 'barter' 
                                    ? 'bg-[#03262B] text-white border-none'
                                    : 'bg-[#6EA1AA] text-white border-none'
                                  : selectedMode === 'barter'
                                    ? 'bg-white text-[#03262B] border border-[#03262B]'
                                    : 'bg-white text-[#03262B] border border-[#6EA1AA]'
                              ]"
                              @click="selectedFilter = selectedFilter === 'Open Chains' ? 'All' : 'Open Chains'"
                            >
                              Open Chains
                            </button>
                            <button
                              :class="[
                                'w-44 h-11 text-center justify-center text-2xl font-bold font-roboto leading-7 rounded-3xl',
                                selectedFilter === 'In Progress'
                                  ? selectedMode === 'barter' 
                                    ? 'bg-[#03262B] text-white border-none'
                                    : 'bg-[#6EA1AA] text-white border-none'
                                  : selectedMode === 'barter'
                                    ? 'bg-white text-[#03262B] border border-[#03262B]'
                                    : 'bg-white text-[#03262B] border border-[#6EA1AA]'
                              ]"
                              @click="selectedFilter = selectedFilter === 'In Progress' ? 'All' : 'In Progress'"
                            >
                              In Progress
                            </button>
                        </template>
                    </div>
                    <div class="relative">
                        <img 
                            src="@/assets/images/searchFilters.png"
                            alt="Filter"
                            :class="[
                                'w-10 h-8 object-contain cursor-pointer',
                                selectedMode === 'barter' ? 'brightness-0' : 'brightness-0 invert'
                            ]"
                            @click.stop="showFilters = !showFilters"
                        />
                        
                        <!-- Filter Dropdown -->
                        <div
                            v-if="showFilters"
                            ref="dropdownRef"
                            class="absolute z-50 top-[60px] right-0 bg-white border-2 border-[#03262B] shadow-lg p-4 w-[200px]"
                            @click.stop
                        >
                            <p class="font-roboto font-bold italic text-[#03262B] mb-2">Sort by:</p>
                            <ul class="font-roboto font-semibold space-y-2">
                                <li><input type="checkbox" id="opt1" /> <label for="opt1">Alphabetically</label></li>
                                <li><input type="checkbox" id="opt2" /> <label for="opt2">Recently Added</label></li>
                                <li><input type="checkbox" id="opt3" /> <label for="opt3">Popularity</label></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div v-if="selectedFilter === 'All' || selectedFilter === 'Mentors'">
                    <div :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'" class="text-left justify-center text-5xl font-bold font-sofiacond leading-[76.80px] [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[20px]">
                        Mentors
                    </div>
                    <!-- Mentors Carousel -->
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
                            <Slide v-for="mentor in mentors" :key="mentor.id">
                                <div class="relative flex flex-col items-center bg-white border-[5px] rounded-2xl shadow-lg px-5 pt-5 pb-5 mx-2"
                                     :class="selectedMode === 'barter' ? 'border-[#03262B]' : 'border-[#6EA1AA]'">
                                    <div class="flex flex-row items-center w-full mb-4">
                                        <img 
                                            class="w-20 h-20 rounded-full object-cover mr-4"
                                            :src="mentor.image"
                                            :alt="mentor.name"
                                        />
                                        <div>
                                            <div class="text-2xl font-bold text-[#03262B] leading-tight">{{ mentor.name }}</div>
                                            <div class="text-lg text-[#4B6A6A]">{{ mentor.specialty }}</div>
                                        </div>
                                    </div>
                                    <div class="w-full text-left text-teal-950 text-2xl font-semibold italic font-roboto leading-7 mb-1">Skills Offered:</div>
                                    <div class="mb-4 w-full">
                                        <ul class="list-disc ml-6 text-teal-950 text-xl font-normal font-roboto leading-relaxed">
                                            <li v-for="skill in mentor.skills" :key="skill.name" class="text-left">
                                                {{ skill.name }} ({{ skill.requests }} Requests)
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="w-full text-left text-teal-950 text-2xl font-semibold italic font-roboto leading-7 mb-1">Exchange Offer:</div>
                                    <div class="mb-0 w-full">
                                        <ul class="list-disc ml-6 text-teal-950 text-xl font-normal font-roboto leading-relaxed">
                                            <li v-for="offer in mentor.exchangeOffer" :key="offer" class="text-left">
                                                {{ offer }}
                                            </li>
                                        </ul>
                                    </div>
                                    <button 
                                        :class="[
                                            'mt-[10px] w-32 h-9 rounded-3xl text-center justify-center text-base font-bold font-roboto leading-normal tracking-tight text-white',
                                            requestedMentors.has(mentor.id) ? 'bg-gray-500' : 'bg-teal-800'
                                        ]"
                                        @click="requestSwap(mentor.id)"
                                    >
                                        {{ requestedMentors.has(mentor.id) ? 'Swap Requested' : 'Request Swap' }}
                                    </button>
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
                </div>
                <div v-if="selectedFilter === 'All' || selectedFilter === 'Students'">
                    <div :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'" class="text-left justify-center text-5xl font-bold font-sofiacond leading-[76.80px] [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[20px]">
                        Students
                    </div>
                    <!-- Students Carousel -->
                    <div class="relative flex items-center px-28 py-12">
                        <button
                            @click="studentsCarouselRef?.prev()"
                            class="absolute left-27 z-10 transform -translate-x-full hover:scale-105 transition"
                        >
                            <img
                                src="@/assets/images/Circle_Carret_Right.png"
                                alt="Left"
                                class="w-20 h-20 rotate-180"
                            />
                        </button>
                        <Carousel 
                            v-bind="studentsCarouselConfig" 
                            class="w-full"
                            ref="studentsCarouselRef"
                        >
                            <Slide v-for="student in students" :key="student.id">
                                <div class="relative flex flex-col items-center bg-white border-[5px] rounded-2xl shadow-lg px-5 pt-5 pb-5 mx-2"
                                     :class="selectedMode === 'barter' ? 'border-[#03262B]' : 'border-[#6EA1AA]'">
                                    <div class="flex flex-row items-center w-full mb-4">
                                        <img 
                                            class="w-20 h-20 rounded-full object-cover mr-4"
                                            :src="student.image"
                                            :alt="student.name"
                                        />
                                        <div>
                                            <div class="text-2xl font-bold text-[#03262B] leading-tight">{{ student.name }}</div>
                                            <div class="text-lg text-[#4B6A6A]">{{ student.specialty }}</div>
                                        </div>
                                    </div>
                                    <div class="w-full text-left text-teal-950 text-2xl font-semibold italic font-roboto leading-7 mb-1">Skills Offered:</div>
                                    <div class="mb-4 w-full">
                                        <ul class="list-disc ml-6 text-teal-950 text-xl font-normal font-roboto leading-relaxed">
                                            <li v-for="skill in student.skills" :key="skill.name" class="text-left">
                                                {{ skill.name }} ({{ skill.requests }} Requests)
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="w-full text-left text-teal-950 text-2xl font-semibold italic font-roboto leading-7 mb-1">Exchange Offer:</div>
                                    <div class="mb-0 w-full">
                                        <ul class="list-disc ml-6 text-teal-950 text-xl font-normal font-roboto leading-relaxed">
                                            <li v-for="offer in student.exchangeOffer" :key="offer" class="text-left">
                                                {{ offer }}
                                            </li>
                                        </ul>
                                    </div>
                                    <button 
                                        :class="[
                                            'mt-[10px] w-32 h-9 rounded-3xl text-center justify-center text-base font-bold font-roboto leading-normal tracking-tight text-white',
                                            requestedStudents.has(student.id) ? 'bg-gray-500' : 'bg-teal-800'
                                        ]"
                                        @click="requestStudentSwap(student.id)"
                                    >
                                        {{ requestedStudents.has(student.id) ? 'Swap Requested' : 'Request Swap' }}
                                    </button>
                                </div>
                            </Slide>
                        </Carousel>
                        <button
                            @click="studentsCarouselRef?.next()"
                            class="absolute right-27 z-10 transform translate-x-full hover:scale-115 transition"
                        >
                            <img
                                src="@/assets/images/Circle_Carret_Right.png"
                                alt="Right"
                                class="w-20 h-20"
                            />
                        </button>
                    </div>
                </div>
            </div>
        </main>
        <HomeFooter :selectedMode="selectedMode" />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import HomeHeader from './homePage-components/HomeHeader.vue'
import HomeFooter from './homePage-components/HomeFooter.vue'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import 'vue3-carousel/carousel.css'

//Import mentor images
import taylorSwift from '@/assets/images/taylor swift.png'
import drake from '@/assets/images/drake.png'
import keanuReeves from '@/assets/images/keanu reeves.png'

//import student images


const route = useRoute()
const router = useRouter()
const skill = ref('')
const showFilters = ref(false)
const dropdownRef = ref(null)
const carouselRef = ref(null)
const studentsCarouselRef = ref(null)
const selectedFilter = ref('All')
const showAll = ref(false)
const requestedMentors = ref(new Set())
const requestedStudents = ref(new Set())
const selectedMode = ref('1on1')

// Handle click outside to close dropdown
const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        showFilters.value = false
    }
}

onMounted(() => {
    // Get the skill from route params and decode it
    const skillParam = route.params.skill
    if (skillParam) {
        skill.value = decodeURIComponent(skillParam)
    }
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

const getSkillImage = (skillName) => {
    switch(skillName) {
        case 'Language & Communication':
            return languageSkill
        case 'Music & Performance':
            return musicSkill
        case 'Cooking & Pastry Arts':
            return cookingSkill
        default:
            return ''
    }
}

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

// Add separate config for students to handle 4 items
const studentsCarouselConfig = {
    ...carouselConfig,
    itemsToShow: 3,
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

// Sample mentor data
const mentors = ref([
    {
        id: 1,
        name: "Taylor Swift",
        specialty: "Language & Cultural Exchange",
        image: taylorSwift,
        skills: [
            { name: "Casual Spanish", requests: 60 },
            { name: "TOEFL/IELTS Prep", requests: 40 },
        ],
        exchangeOffer: ["Graphic Design", "Cooking Lessons"]
    },
    {
        id: 2,
        name: "Drake",
        specialty: "Accent Coaching",
        image: drake,
        skills: [
            { name: "French Fluency", requests: 30 },
            { name: "Public Speaking", requests: 20 }
        ],
        exchangeOffer: ["Web Development", "Video Editing"]
    },
    {
        id: 3,
        name: "Keanu Reeves",
        specialty: "Japanese Pop Culture",
        image: keanuReeves,
        skills: [
            { name: "Anime Japanese", requests: 75 },
            { name: "Public Speaking", requests: 25 }
        ],
        exchangeOffer: ["Guitar Lessons", "Photography"]
    }
])

// Sample student data
const students = ref([
    {
        id: 4,
        name: "Taylor Swift",
        specialty: "Vlogger",
        image: taylorSwift,
        skills: [
            { name: "Web Design", requests: 15 },
            { name: "Video Editing", requests: 30 }
        ],
        exchangeOffer: ["Public Speaking", "Casual French"]
    },
    {
        id: 5,
        name: "Drake",
        specialty: "Musician",
        image: drake,
        skills: [
            { name: "Guitar Lessons", requests: 25 },
            { name: "Singing", requests: 40 }
        ],
        exchangeOffer: ["Anime Japanese", "Casual Spanish"]
    },
    {
        id: 6,
        name: "Keanu Reeves",
        specialty: "Comedian",
        image: keanuReeves,
        skills: [
            { name: "Improvisation", requests: 20 },
            { name: "Stage Presence", requests: 15 }
        ],
        exchangeOffer: ["French Fluency", "Casual English"]
    },
])

const requestSwap = (mentorId) => {
    alert('Swap Requested')
    console.log(`Requesting swap with mentor ${mentorId}`)
}

const requestStudentSwap = (studentId) => {
    alert('Swap Requested')
    console.log(`Requesting swap with student ${studentId}`)
}
</script>

<style scoped>
.skill-shift-move {
    transition: transform 0.5s ease;
}

.skill-shift-enter-active,
.skill-shift-leave-active {
    transition: all 0.5s ease;
}

.skill-shift-enter-from,
.skill-shift-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* Carousel Custom Styles */
:deep(.carousel__viewport) {
    perspective: 1000px;
}

:deep(.carousel__track) {
    padding: 20px 0;
    min-height: 440px; /* Ensures all slides align to the tallest card, adjust as needed */
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
    min-height: 420px; /* Ensures all cards have the same minimum height */
    height: 100%;
    width: 440px;      /* Set your desired fixed width */
    max-width: 100%;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: stretch;
    margin: 0 auto;    /* Center the card in the slide */
}

/* Hide default navigation */
:deep(.carousel__prev),
:deep(.carousel__next) {
    display: none;
}

.filter-toggle button {
  transition: background 0.2s, color 0.2s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
</style>