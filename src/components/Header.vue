<template>
  <header class="bg-[#6EA1AA] shadow-md px-7 py-5">
    <div class="flex justify-between items-center">
      <p class="font-sofia text-[48px] text-white text-shadow-lg/30">SkillSwap</p>
      <div class="w-[700px] h-[50px] flex  bg-white rounded-3xl"></div>
      <div class="font-roboto text-[30px]  text-white text-4xl font-bold">Login</div>
      <div class="flex items-center gap-6">
      <div class="w-40 h-16 text-[#6EA1AA] flex items-center justify-center text-4xl font-bold font-roboto bg-white rounded-3xl border border-slate-400">Sign Up</div> 
      </div>
      
    </div>
         
  </header>
</template>


<script>
export default {
  name: 'Header',
  data() {
    return {
      isMenuOpen: false
    }
  }
}
</script>