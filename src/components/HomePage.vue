<!-- Home Page -->
<template>
    <div class="min-h-screen flex flex-col bg-[#03262B]">
        <HomeHeader/>
        
        <main class="flex-1 pt-22">
            <div class="relative w-full">
                <p class=" font-sofia text-[53px] text-white text-4xl italic text-shadow-lg absolute top-18 left-28">
                    Trade What You Know <br>
                    Learn What You Don’t
                    </p>
                    <p class=" font-roboto text-[25px] text-white text-4xl text-shadow-lg absolute top-50 left-28">
                    Connect with your community to exchange skills. <br>
                    Teach what you’re good at, learn what you’ve <br>
                    always wanted!
                    </p>
                    <img 
                    src="@/assets/images/landingPagePic1.png"
                    alt="Logo"
                    class="object-contain"
                />
            </div>
        </main>

        <HomeFooter/>
    </div>

    
</template>

<script setup>
import { ref } from 'vue'
import HomeHeader from './homePage-components/HomeHeader.vue'
import HomeFooter from './homePage-components/HomeFooter.vue'

</script>