<template>
  <!-- Header -->
  <header class="bg-[#6EA1AA] shadow-md px-7 py-5">
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
          class="flex-1 bg-transparent outline-none text-gray-700 text-base mx-6"
        />
        <img 
          src="@/assets/images/searchFilters.png"
          alt="Filter"
          class="w-8 -translate-x-3 object-contain "
        />
      </div> 

      <!-- Login and Sign Up Buttons -->
      <div class="flex items-center gap-6">
        <button class="font-roboto text-[35px] text-white text-4xl font-bold">Login</button>
       <button class="w-40 h-16 text-[#6EA1AA] flex items-center justify-center text-4xl font-bold font-roboto text-[35px] bg-white rounded-3xl border border-slate-400">Sign Up</button> 
      </div>
      
    </div>
         
  </header>
</template>


<script>

</script>