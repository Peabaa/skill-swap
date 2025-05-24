<template>
    <div class="min-h-screen flex flex-col bg-[#03262B]">
        <HomeHeader />
        <main class="flex-1 pt-22">

            <!--Search Results Header-->
            <div class="container mx-auto px-4">
                <div class="text-left justify-center text-white text-5xl font-bold italic font-sofiacond [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[50px]">
                    {{ skill }}
                </div>

                <!--Filter by-->
                <div class="flex items-center justify-between mt-[25px]">
                    <div class="flex items-center gap-4">
                        <div class="text-white text-3xl font-semibold font-roboto leading-10">
                            Filter by:
                        </div>
                        <button class="w-44 h-11 text-center justify-center text-teal-950 text-2xl font-bold font-roboto leading-7 bg-white rounded-3xl border border-white"
                            @click="$emit('trigger-login')">Mentors
                        </button>
                        <button class="w-44 h-11 text-center justify-center text-teal-950 text-2xl font-bold font-roboto leading-7 bg-white rounded-3xl border border-white"
                            @click="$emit('trigger-login')">Students
                        </button>
                    </div>
                    <div class="relative">
                        <img 
                            src="@/assets/images/searchFilters.png"
                            alt="Filter"
                            class="w-10 h-8 object-contain cursor-pointer brightness-0 invert"
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

                <div class="text-left justify-center text-white text-5xl font-bold font-sofiacond leading-[76.80px] [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[20px]">
                        Mentors
                </div>

                <!-- Mentors Grid -->
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

                    <!-- Mentor Cards with animation -->
                    <transition-group
                        name="skill-shift"
                        tag="div"
                        class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full"
                    >
                        <div
                            v-for="mentor in mentors"
                            :key="mentor.id"
                            class="relative flex flex-col items-center bg-white border-[5px] border-[#6EA1AA] rounded-2xl shadow-lg px-5 pt-5 pb-5"
                        >
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
                                class="mt-[10px] w-32 h-9 bg-teal-800 rounded-3xl text-center justify-center text-white text-base font-bold font-roboto leading-normal tracking-tight"
                                @click="requestSwap(mentor.id)"
                            >
                                Request Swap
                            </button>
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

                <div class="text-left justify-center text-white text-5xl font-bold font-sofiacond leading-[76.80px] [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)] mt-[20px]">
                        Students
                </div>

                <!-- Students Grid -->
                <div class="relative flex items-center px-28 py-12">
                    <!-- Left Button -->
                    <button
                        @click="shiftLeftStudents"
                        class="absolute left-27 z-10 transform -translate-x-full hover:scale-105 transition"
                    >
                        <img
                            src="@/assets/images/Circle_Carret_Right.png"
                            alt="Left"
                            class="w-20 h-20 rotate-180"
                        />
                    </button>

                    <!-- Student Cards with animation -->
                    <transition-group
                        name="skill-shift"
                        tag="div"
                        class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full"
                    >
                        <div
                            v-for="student in students"
                            :key="student.id"
                            class="relative flex flex-col items-center bg-white border-[5px] border-[#6EA1AA] rounded-2xl shadow-lg px-5 pt-5 pb-5"
                        >
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
                                class="mt-[10px] w-32 h-9 bg-teal-800 rounded-3xl text-center justify-center text-white text-base font-bold font-roboto leading-normal tracking-tight"
                                @click="requestStudentSwap(student.id)"
                            >
                                Request Swap
                            </button>
                        </div>
                    </transition-group>

                    <!-- Right Button -->
                    <button
                        @click="shiftRightStudents"
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
        </main>
        <HomeFooter />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import HomeHeader from './homePage-components/HomeHeader.vue'
import HomeFooter from './homePage-components/HomeFooter.vue'

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
    }
])

const shiftLeft = () => {
    const first = mentors.value.shift()
    mentors.value.push(first)
}

const shiftRight = () => {
    const last = mentors.value.pop()
    mentors.value.unshift(last)
}

const shiftLeftStudents = () => {
    const first = students.value.shift()
    students.value.push(first)
}

const shiftRightStudents = () => {
    const last = students.value.pop()
    students.value.unshift(last)
}

const requestSwap = (mentorId) => {
    // Handle swap request
    console.log(`Requesting swap with mentor ${mentorId}`)
}

const requestStudentSwap = (studentId) => {
    // Handle swap request for students
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
</style>