<!-- Home Footer -->
<template>
    <footer class="shadow-md px-7 py-2.5"
        :class="selectedMode === 'barter' ? 'bg-[#03262B]' : 'bg-[#6EA1AA]'">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-6">
                <p class="font-sofia text-[48px] font-bold italic text-shadow-lg/30"
                   :class="selectedMode === 'barter' ? 'text-white' : 'text-white'">SkillSwap</p>
                <img 
                src="@/assets/images/skillSwapLogo.png"
                alt="Logo"
                class="w-18 -translate-x-4 object-contain"
                :style="selectedMode === 'barter' ? 'filter: brightness(200%)' : ''"
                />

                <!-- <div class="flex flex-row gap-2">
                    <button class="font-roboto text-[25px] text-white text-4xl font-bold">About Us</button>
                    <p class="font-roboto text-[40px] text-white text-4xl font-bold translate-y-1">•</p>
                    <button class="font-roboto text-[25px] text-white text-4xl font-bold">Contact</button>
                    <p class="font-roboto text-[40px] text-white text-4xl font-bold translate-y-1">•</p>
                    <button class="font-roboto text-[25px] text-white text-4xl font-bold">FAQ</button>
                </div>                 -->
            </div>
            <p class="font-roboto text-[20px] text-4xl font-bold"
               :class="selectedMode === 'barter' ? 'text-white' : 'text-white'">© 2025 SkillSwap. All rights reserved.</p>
        </div>
    </footer>

</template>

<script setup>
// Accept selectedMode as a prop
const props = defineProps({
  selectedMode: {
    type: String,
    default: '1on1'
  }
})
</script>