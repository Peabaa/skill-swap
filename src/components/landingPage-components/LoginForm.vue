<!-- Login Modal/Overlay -->
<template>
  <!--Sign Up Form-->
  <div class="flex items-center justify-center">
    <div class="w-full max-w-[799px] max-h-[960px] bg-[rgba(255,255,255,0.9)] rounded-3xl p-[40px_90px_40px_90px]">

      <!-- Header -->
      <div class="text-center text-6xl font-bold font-sofiacond text-[#6EA1AA] leading-[119.99px] 
                  [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)]">
        Login Form
      </div> 

      <!-- Centered Overlapping Buttons -->
      <div class="relative w-[260px] h-10 mb-6 ml-8">
        <!-- Sign Up Button (under) -->
        <button class="absolute top-0 left-0 w-40 h-10 bg-white rounded-3xl border border-slate-400 z-0 flex items-center justify-center"
                @click="$emit('trigger-signup')">
          <span class=" pr-8 text-[#6EA1AA] font-bold font-roboto text-lg">Sign Up</span>
        </button>

        <!-- Login Button (on top) -->
        <button class="absolute top-0 left-[110px] w-[150px] h-10 bg-[#6EA1AA] rounded-3xl border border-slate-400 z-10"
                @click="$emit('handleLogin')">
          <span class="text-white font-bold font-roboto text-lg">Login</span>
        </button>
      </div>

      <!-- Email Box -->
      <div class="w-[330px] h-10 bg-[rgba(255,255,255,0.7)] rounded-3xl border border-zinc-400 mx-auto flex items-center">
        
        <input 
          v-model="email"
          type="text"
          placeholder="Email Address"
          class="font-roboto font-bold flex-1 bg-transparent outline-none text-gray-700 text-base mx-6"
        />
      </div>

      <!-- Password Box -->
      <div class="w-[330px] h-10 bg-[rgba(255,255,255,0.7)] rounded-3xl border border-zinc-400 mx-auto flex items-center mt-5">
        
        <input 
          v-model="password"
          type="text"
          placeholder="Password"
          class="font-roboto font-bold flex-1 bg-transparent outline-none text-gray-700 text-base mx-6"
        />
      </div>

      <!-- Feedback Message -->
      <div class="text-center mt-4">
        <p v-if="errorMessage" class="text-red-600 font-semibold">{{ errorMessage }}</p>
      </div>

      <!--Login Button-->
      <button class="w-40 h-10 bg-[#6EA1AA] rounded-3xl border border-slate-400 mt-5 justify-center flex items-center mx-auto"
                @click="handleLogin">
          <span class="  text-white font-bold font-roboto text-lg">Login</span>
      </button>

      <!--Cancel-->
      <button class="w-40 h-10 bg-white rounded-3xl border border-slate-400 mt-5 justify-center flex items-center mx-auto"
                @click="$emit('close')">
          <span class="text-[#6EA1AA] font-bold font-roboto text-lg">Cancel</span>
      </button>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const router = useRouter()

async function handleLogin() {
  errorMessage.value = ''

  if (!email.value || !password.value) {
    errorMessage.value = 'Please fill in both fields.'
    return
  }

  try {
    const response = await fetch('http://localhost/skillSwapPHP/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    const result = await response.json()

    if (response.ok && result.success) {
      router.push({ name: 'HomePage' }) // Navigate on success
    } else {
      errorMessage.value = result.message || 'Invalid email or password.'
    }
  } catch (error) {
    console.error(error)
    errorMessage.value = 'Something went wrong. Please try again.'
  }
}

</script>
