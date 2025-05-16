<template>
  <!-- Header -->
  <header class="bg-[#6EA1AA] shadow-md px-7 py-5">
<div v-if="showFilters">
</div>
    
    <div class="flex justify-between items-center">
      <div class="flex items-center gap-6">
        <p class="font-sofia text-[48px] text-white text-shadow-lg/30">SkillSwap</p>
        <img 
          src="@/assets/images/skillSwapLogo.png"
          alt="Logo"
          class="w-18 -translate-x-4 object-contain "
        />
      </div>
      
      <!-- Search Bar -->
      <div class="w-[700px] h-[50px] flex items-center bg-white rounded-3xl"> 
        <img 
          src="@/assets/images/searchIcon.png"
          alt="Search"
          class="translate-x-3 object-contain "
        />
        <input 
          v-model="searchBar"
          type="searchBar"
          placeholder="Search"
          class="font-sofia flex-1 bg-transparent outline-none text-gray-700 text-base mx-6"
        />

        <!-- Search Filter Button -->
        <img 
          src="@/assets/images/searchFilters.png"
          alt="Filter"
          class="w-8 -translate-x-3 object-contain "
          @click="showFilters = !showFilters"
        />

        <div v-if="showFilters" class="absolute top-[100px] right-[300px] bg-white shadow-lg rounded-xl p-4 z-50 w-60">
          <p class="font-sofia text-gray-700 mb-2">Sort by</p>
          <ul class="space-y-2">
            <li><input type="checkbox" id="opt1" /> <label for="opt1">Option 1</label></li>
            <li><input type="checkbox" id="opt2" /> <label for="opt2">Option 2</label></li>
            <li><input type="checkbox" id="opt3" /> <label for="opt3">Option 3</label></li>
          </ul>
        </div>
      </div> 

      <!-- Login and Sign Up Buttons -->
      <div class="flex items-center gap-6">
        <button class="font-roboto text-[35px] text-white text-4xl font-bold">Login</button>
       <button class="w-40 h-16 text-[#6EA1AA] flex items-center justify-center text-4xl font-bold font-roboto text-[35px] bg-white rounded-3xl border border-slate-400">Sign Up</button> 
      </div>
      
    </div>
         
  </header>
</template>

<script setup>
import { ref } from 'vue'

const searchBar = ref('')
const showFilters = ref(false)

</script>