<template>
  <div
    class="min-h-screen flex flex-col"
    :style="selectedMode === 'barter'
      ? { backgroundColor: 'rgba(110, 161, 170, 0.66)' }
      : { backgroundColor: '#03262B' }"
  >
    <HomeHeader v-model:selectedMode="selectedMode" />

    <!-- Success Message -->
    <div
      v-if="successMessageVisible"
      class="fixed w-[1000px] text-center bottom-8 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-lg px-6 py-2 rounded-lg shadow-lg transition-opacity duration-1000 ease-in-out z-50"
      :class="{ 'opacity-0': fadeOut }"
    >
      Request sent!
    </div>

    <main class="flex-1 pt-22">
      <div class="container mx-auto px-4">
        <div
          :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'"
          class="text-left text-5xl font-bold italic font-sofiacond mt-[50px] [text-shadow:_5px_4px_4px_rgb(0_0_0_/_0.25)]"
        >
          Search Results for "{{ query }}"
        </div>

        <!-- Loading -->
        <div v-if="loading" class="text-xl mt-10 text-center text-gray-200">Searching...</div>

        <!-- Results -->
        <div v-else-if="results.length" class="mt-10">
          <div class="text-left text-4xl font-bold font-sofiacond mt-[40px]"
               :class="selectedMode === 'barter' ? 'text-[#03262B]' : 'text-white'">
            Mentors
          </div>

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
              <Slide v-for="(result, index) in results" :key="index">
                <div
                  class="relative flex flex-col items-center bg-white border-[5px] rounded-2xl shadow-lg px-5 pt-5 pb-5 mx-2"
                  :class="selectedMode === 'barter' ? 'border-[#03262B]' : 'border-[#6EA1AA]'"
                >
                  <div class="text-left w-full">
                    <div class="text-2xl font-bold text-[#03262B]">
                        {{ result.email }}
                    </div>
                    <div class="text-lg text-[#4B6A6A] mt-1">
                        Skill Match: <strong>{{ result.skill_name }}</strong>
                    </div>
                    <button
                        class="mt-4 bg-[#03262B] text-white px-4 py-2 rounded-lg hover:bg-[#05404A] transition"
                        @click="requestSwap(result)"
                    >
                        Request Swap
                    </button>

                    <!-- Barter Info -->
                    <div v-if="selectedMode === 'barter'" class="mt-4 text-left">
                      <div class="text-lg font-semibold text-[#03262B]">Willing to Offer:</div>
                      <ul class="list-disc list-inside text-[#4B6A6A]">
                        <li v-for="(offer, idx) in result.willing_to_offer" :key="idx">{{ offer }}</li>
                      </ul>
                      <div class="mt-2 text-lg font-semibold text-[#03262B]">Needs Help With:</div>
                      <ul class="list-disc list-inside text-[#4B6A6A]">
                        <li v-for="(need, idx) in result.needs_help_with" :key="idx">{{ need }}</li>
                      </ul>
                    </div>

                  </div>
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

        <!-- No Results -->
        <div v-else class="text-xl mt-10 text-center text-gray-200">
          No results found.
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { Carousel, Slide } from 'vue3-carousel'
import HomeHeader from './homePage-components/HomeHeader.vue'

const route = useRoute()
const query = ref(route.query.q || '')
const results = ref([])
const loading = ref(false)
const selectedMode = ref('1on1')

const carouselRef = ref(null)
const carouselConfig = {
  itemsToShow: 3,
  wrapAround: false,
  snapAlign: 'center',
}

// Success message state
const successMessageVisible = ref(false)
const fadeOut = ref(false)

const showSuccessMessage = () => {
  successMessageVisible.value = true
  fadeOut.value = false

  setTimeout(() => {
    fadeOut.value = true
  }, 1500)

  setTimeout(() => {
    successMessageVisible.value = false
  }, 2500)
}

const requestSwap = (result) => {
  console.log(`Swap request sent to ${result.email}`)
  showSuccessMessage()
}

const fetchResults = async () => {
  if (!query.value) return

  loading.value = true
  results.value = []

  try {
    const response = await fetch('http://localhost/skillSwapPHP/search.php', {
      method: 'POST',
      credentials: 'include',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ query: query.value }),
    })

    const responseText = await response.text()
    console.log('Raw response:', responseText)
    const data = JSON.parse(responseText)

    const unique = new Map()
    for (const item of data.results || []) {
      if (!unique.has(item.email)) {
        unique.set(item.email, item)
      }
    }

    results.value = Array.from(unique.values())
  } catch (err) {
    console.error('Search error:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchResults)
watch(() => route.query.q, (newQuery) => {
  query.value = newQuery
  fetchResults()
})
</script>

<style scoped>
:deep(.carousel__viewport) {
  perspective: 1000px;
}

:deep(.carousel__track) {
  padding: 20px 0;
  min-height: 300px;
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
  min-height: 250px;
  width: 400px;
  display: flex;
  flex-direction: column;
  justify-content: stretch;
  margin: 0 auto;
}

:deep(.carousel__prev),
:deep(.carousel__next) {
  display: none;
}

.opacity-0 {
  opacity: 0;
}
</style>
