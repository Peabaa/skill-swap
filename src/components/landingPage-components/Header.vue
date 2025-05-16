<template>
  <!-- Header -->
  <header class="bg-[#6EA1AA] shadow-md px-7 py-2.5">
    <div class="flex justify-between items-center">
      <div class="flex items-center gap-6">
        <p class="font-sofia text-[48px] font-bold italic text-white text-shadow-lg/30">SkillSwap</p>
        <img 
          src="@/assets/images/skillSwapLogo.png"
          alt="Logo"
          class="w-18 -translate-x-4 object-contain"
        />
      </div>
      
      <!-- Search Bar -->
      <div class="w-[590px] h-[40px] -translate-x-32 flex items-center bg-white rounded-3xl relative"> 
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
          class="absolute top-[60px] left-[500px] bg-white border-2 border-[#03262B] shadow-lg p-4 z-50 w-[200px]"
        >
          <p class="font-roboto font-bold italic text-[#03262B] mb-2">Sort by:</p>
          <ul class="font-roboto font-semibold space-y-2">
            <li><input type="checkbox" id="opt1" /> <label for="opt1">Alphabetically</label></li>
            <li><input type="checkbox" id="opt2" /> <label for="opt2">Recently Added</label></li>
            <li><input type="checkbox" id="opt3" /> <label for="opt3">Popularity</label></li>
          </ul>
        </div>
      </div> 

      <!-- Login and Sign Up Buttons -->
      <div class="flex items-center gap-6">
        <button class="font-roboto text-[25px] text-white text-4xl font-bold">Login</button>
        <button class="font-roboto text-[25px] font-bold w-30 h-13 text-[#6EA1AA] flex items-center justify-center text-4xl bg-white rounded-2xl border border-slate-400">Sign Up</button> 
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { onClickOutside } from '@vueuse/core'

const searchBar = ref('')
const showFilters = ref(false)
const dropdownRef = ref(null)

onClickOutside(dropdownRef, () => {
  showFilters.value = false
})
</script>
