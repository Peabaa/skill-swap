<!-- Home Header -->
<template>
  <header class="fixed top-0 left-0 w-full z-50 shadow-md px-7 py-2.5"
    :class="selectedMode === 'barter' ? 'bg-[#03262B]' : 'bg-[#6EA1AA]'">
    <div class="flex justify-between items-center">
      <div class="flex items-center gap-6 cursor-pointer" @click="goToHome">
        <p class="font-sofia text-[48px] font-bold italic text-shadow-lg/30"
           :class="selectedMode === 'barter' ? 'text-white' : 'text-white'">SkillSwap</p>
        <img 
          src="@/assets/images/skillSwapLogo.png"
          alt="Logo"
          class="w-18 -translate-x-4 object-contain"
          :style="selectedMode === 'barter' ? 'filter: brightness(200%)' : ''"
        />
      </div>
      
      <!-- Search Bar -->
      <div class="w-[590px] h-[40px] -translate-x-10 flex items-center bg-white rounded-3xl relative"> 
        <img 
          src="@/assets/images/searchIcon.png"
          alt="Search"
          class="translate-x-3 object-contain"
        />
        <input 
          v-model="searchBar"
          type="text"
          placeholder="Search"
          class="font-roboto flex-1 bg-transparent outline-none text-gray-700 text-base mx-6"
          @keyup.enter="emitSearch"
        />

        <!-- Search Filter Button -->
        <img 
          src="@/assets/images/searchFilters.png"
          alt="Filter"
          class="w-8 -translate-x-3 object-contain cursor-pointer"
          @click="showFilters = !showFilters"
        />
        
        <!-- Filter Dropdown -->
        <div
          v-if="showFilters"
          ref="dropdownRef"
          class="absolute z-50 top-[60px] left-[500px] bg-white border-2 border-[#03262B] shadow-lg p-4 w-[200px]"
        >
          <p class="font-roboto font-bold italic text-[#03262B] mb-2">Sort by:</p>
          <ul class="font-roboto font-semibold space-y-2">
            <li><input type="checkbox" id="opt1" /> <label for="opt1">Alphabetically</label></li>
            <li><input type="checkbox" id="opt2" /> <label for="opt2">Recently Added</label></li>
            <li><input type="checkbox" id="opt3" /> <label for="opt3">Popularity</label></li>
          </ul>
        </div>
      </div> 

        <!--1 on 1/ Barter Chain Button-->
        <div class="relative w-40 h-12 ml-4 right-25">
          <!-- 1 On 1 Button (under) -->
          <button
            class="absolute top-0 left-5 w-35 h-12 rounded-3xl border text-center justify-center font-roboto text-2xl font-bold leading-7 transition-colors duration-200 focus:outline-none pr-5"
            :class="selectedMode === '1on1' ? 'bg-[#03262B] text-white border-[#6EA1AA] z-10' : 'bg-white text-[#6EA1AA] border-[#6EA1AA] z-10'"
            style="box-shadow: 0 1px 4px rgba(0,0,0,0.04);"
            @click="setMode('1on1')"
            type="button"
          >
            1 On 1
          </button>
          <!-- Barter Chains Button (on top) -->
          <button
            class="absolute top-0 left-30 w-40 h-12 rounded-3xl text-center justify-center font-roboto text-xl font-bold leading-7 transition-colors duration-200 focus:outline-none"
            :class="selectedMode === 'barter' ? 'bg-[#6EA1AA] text-white border-none z-20' : 'bg-white text-[#6EA1AA] border-[#6EA1AA] z-20'"
            style="box-shadow: 0 1px 4px rgba(0,0,0,0.04);"
            @click="setMode('barter')"
            type="button"
          >
            Barter Chains
          </button>
        </div>
        <!-- Dashboard Button with Dropdown -->
        <div class="relative" ref="dashboardMenuRef">
          <button
            class="flex items-center gap-x-2 font-roboto text-[25px] text-4xl font-bold"
            :class="selectedMode === 'barter' ? 'text-white' : 'text-white'"
            @click="showDashboardMenu = !showDashboardMenu"
          >
            Dashboard
            <img 
              src="@/assets/images/UserCircle.png" 
              alt="User Icon" 
              class="w-15 h-15"
              :style="selectedMode === 'barter' ? 'filter: brightness(200%)' : ''"
            />
          </button>

          <!-- Dropdown -->
          <div
            v-if="showDashboardMenu"
            class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
          >
            <ul class="py-2">
              <li>
                <button
                  class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 font-roboto font-semibold"
                  @click="viewProfile"
                >
                  View Profile
                </button>
              </li>
              <li>
                <button
                  class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 font-roboto font-semibold"
                  @click="handleLogout"
                >
                  Log Out
                </button>
              </li>
            </ul>
          </div>
        </div>
    </div>
    
    <!-- Add ProfileOverlay component -->
    <ProfileOverlay v-if="showProfile" @close="showProfile = false" />
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { useRouter } from 'vue-router'
import ProfileOverlay from './ProfileOverlay.vue'

const props = defineProps({
  selectedMode: {
    type: String,
    default: '1on1'
  }
})
const emit = defineEmits(['update:selectedMode'])

const router = useRouter()
const searchBar = ref('')
const showFilters = ref(false)
const dropdownRef = ref(null)
const showDashboardMenu = ref(false)
const dashboardMenuRef = ref(null)
const showProfile = ref(false)

const emitSearch = () => {
  const trimmedSearch = searchBar.value.trim()
  if (trimmedSearch !== '') {
    console.log('Search query sent to search.php:', trimmedSearch) // Console log added
    router.push({ name: 'SearchResultsPage', query: { q: trimmedSearch } })
    searchBar.value = '' // Clear field
  }
}

const handleLogout = () => {
  emit('logout')
  showDashboardMenu.value = false
}

const goToHome = () => {
  router.push({ name: 'HomePage' })
}

const setMode = (mode) => {
  emit('update:selectedMode', mode)
}

const viewProfile = () => {
  showProfile.value = true
  showDashboardMenu.value = false
}

onClickOutside(dropdownRef, () => {
  showFilters.value = false
})

onClickOutside(dashboardMenuRef, () => {
  showDashboardMenu.value = false
})
</script>
