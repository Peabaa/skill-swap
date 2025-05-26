<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Black semi-transparent overlay -->
    <div class="fixed inset-0 w-full h-full bg-black opacity-60 z-40"></div>

    <!-- Modal -->
    <div class="relative z-50 w-[1350px] h-[800px] bg-[rgba(255,255,255,1.0)] rounded-3xl">
      <!-- Close button -->
      <button @click="$emit('close')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Profile Image -->
      <div class="flex flex-row h-full">
        <!-- Left: Profile Info -->
        <div class="flex flex-col items-center justify-start w-[400px] pt-20 pl-50">
          <img class="w-48 h-48 rounded-full" src="@/assets/images/Pdiddy.png" alt="Profile Image" />
          <div class="mt-4 text-5xl font-bold font-roboto leading-[75px] text-[#03262B]">
            {{ user.email || 'Loading...' }}
          </div>
          <div class="flex gap-4 mt-4">
            <div
              v-for="(skill, index) in mySkills.slice(0, 3)" 
              :key="skill.name"
              :class="[
                'flex items-center justify-center rounded-3xl',
                index === 0 ? 'w-28 h-10 bg-teal-950' : 'w-36 h-10 bg-[#6EA1AA]'
              ]"
            >
              <span class="text-white text-xl font-normal font-roboto">{{ skill.name }}</span>
            </div>
          </div>

          <div class="mt-5 w-100 h-0 outline outline-1 outline-offset-[-0.50px] outline-black"></div>

          <!-- Email -->
          <div class="flex items-center gap-4 mt-10 mr-30">
            <img src="@/assets/images/EnvelopeSimple.png" alt="Envelope" class="w-14 h-14" />
            <span class="text-[#03262B] text-2xl italic font-roboto font-medium">{{ user.email || 'Email not available' }}</span>
          </div>

        </div>

        <!-- Vertical Divider -->
        <div class="w-0.5 bg-black my-12 self-stretch ml-33"></div>

        <!-- Right Panel -->
        <div class="flex-1 p-12">
          <button
            class="w-[700px] h-44 bg-[#D9D9D9] rounded-[40px] flex items-center justify-center transition hover:bg-[#bcbcbc] focus:outline-none"
            type="button"
            @click="toggleAddSkillForm"
          >
            <span class="text-neutral-500 text-3xl font-normal font-roboto leading-9 tracking-wide">
              + Add New Skill
            </span>
          </button>
          <div class="w-[700px] h-0 outline outline-1 outline-offset-[-0.50px] outline-black mt-8"></div>

          <div class="mt-10 w-full">
            <div class="text-left text-teal-950 text-4xl font-bold font-roboto leading-[56.25px] mb-4">My Skills</div>
            <div class="relative w-[720px] mx-0 mb-8">
              <button @click="prevSkill" :disabled="currentIndex === 0" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">&#8249;</button>
              <div class="overflow-hidden">
                <div
                  class="flex transition-transform duration-300"
                  :style="{ transform: `translateX(-${currentIndex * 246}px)` }"
                >
                  <div
                  v-for="skill in mySkills"
                  :key="skill.name"
                  class="relative flex flex-col items-center justify-center min-w-[220px] max-w-[220px] h-[192px] rounded-2xl mb-2 bg-white border cursor-default"
                >
                  <span class="text-black text-3xl font-sofiacond italic font-bold">{{ skill.name }}</span>
                  <button
                    @click="deleteSkill(skill.name)"
                    class="absolute top-2 right-2 text-red-600 hover:text-red-800 text-xl font-bold"
                    title="Delete Skill"
                  >
                    ✕
                  </button>
                </div>
                </div>
              </div>
              <button @click="nextSkill" :disabled="currentIndex >= mySkills.length - visibleCount" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">&#8250;</button>
            </div>

            <!-- Swap History -->
            <div class="mt-1 text-left text-teal-950 text-4xl font-bold font-roboto leading-[56.25px] mb-2">Swap History</div>
            <div class="relative w-full mx-auto mb-8">
              <button @click="prevSwap" :disabled="currentSwapIndex === 0" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">&#8249;</button>
              <div class="overflow-hidden">
                <div
                  class="flex transition-transform duration-300 gap-4 items-center"
                  :style="{ transform: `translateX(-${currentSwapIndex * 246}px)` }"
                >
                  <div v-for="swap in swapHistory" :key="swap.name" class="flex flex-row items-center min-w-[220px] max-w-[220px] p-4 rounded-lg">
                    <img class="w-16 h-16 rounded-full" :src="swap.image" :alt="swap.name" />
                    <div class="ml-4 flex flex-col">
                      <div class="text-teal-950 text-lg font-bold font-roboto">{{ swap.name }}</div>
                      <div class="text-teal-950 text-sm font-bold italic font-roboto">Skill Swapped:</div>
                      <div class="text-teal-950 text-sm italic font-roboto">{{ swap.skill }}</div>
                      <div class="text-teal-950 text-sm font-bold italic font-roboto">
                        Role: <span class="font-normal">{{ swap.role }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button @click="nextSwap" :disabled="currentSwapIndex.value >= swapHistory.length - visibleSwapCount" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full shadow p-2 disabled:opacity-30">&#8250;</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Skill Modal -->
    <div v-if="showAddSkillForm" class="fixed inset-0 z-60 flex items-center justify-center">
      <div class="fixed inset-0 w-full h-full bg-black opacity-60 z-50"></div>
      <div class="relative z-60 w-full max-w-[650px] max-h-[960px] bg-[rgba(217,217,217,0.9)] rounded-3xl p-[40px_90px_40px_90px] border-8 border-neutral-500">
        <button @click="toggleAddSkillForm" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <div class="flex flex-col items-center">
          <div class="w-[500px] h-16 opacity-70 bg-white rounded-3xl border border-zinc-400 mb-4">
            <input 
              v-model="skillname"
              type="text"
              placeholder="Skill Name"
              class="font-roboto font-bold flex-1 bg-transparent outline-none text-gray-700 text-3xl mx-6 mt-3.5"
            />
          </div>
          <button class="w-40 h-12 bg-[#696D6E] rounded-3xl border border-slate-400 justify-center flex items-center"
                  @click="addSkill">
            <span class="text-white font-bold font-roboto text-lg">Confirm</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import rappingImg from '@/assets/images/rapping.png'
import taylorSwift from '@/assets/images/taylor swift.png'

defineEmits(['close'])

const user = ref({
  email: '',
  phone: '',
  skills: []
})

const mySkills = ref([]) // reactive array for skills

onMounted(async () => {
  try {
    const response = await fetch('http://localhost/skillSwapPHP/getUser.php', {
      credentials: 'include'
    });
    const rawText = await response.text();
    console.log('Raw response:', rawText);

    const data = JSON.parse(rawText);
    user.value.email = data.email || '';
    user.value.phone = data.phone || '';

    if (data.skills && typeof data.skills === 'string') {
      const skillNames = data.skills.split(',').map(s => s.trim()).filter(Boolean);
      mySkills.value = skillNames.map(name => ({
        name,
        image: rappingImg // placeholder logic
      }));
    } else {
      mySkills.value = [
        { name: 'Rapping', image: rappingImg },
        { name: 'Photography', image: rappingImg },
        { name: 'Music', image: rappingImg },
        { name: 'Cooking', image: rappingImg }
      ];
    }
  } catch (error) {
    console.error('Failed to load user:', error);
    mySkills.value = [
      { name: 'Rapping', image: rappingImg },
      { name: 'Photography', image: rappingImg },
      { name: 'Music', image: rappingImg },
      { name: 'Cooking', image: rappingImg }
    ];
  }
});

const currentIndex = ref(0)
const visibleCount = 3

const swapHistory = [
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Rapping',
    role: 'Student'
  },
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Singing',
    role: 'Mentor'
  },
  {
    name: 'Taylor Swift',
    image: taylorSwift,
    skill: 'Dancing',
    role: 'Mentor'
  },
]

const currentSwapIndex = ref(0)
const visibleSwapCount = 2

function prevSkill() {
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}
function nextSkill() {
  if (currentIndex.value < mySkills.value.length - visibleCount) {
    currentIndex.value++
  }
}

function prevSwap() {
  if (currentSwapIndex.value > 0) {
    currentSwapIndex.value--
  }
}
function nextSwap() {
  if (currentSwapIndex.value < swapHistory.length - visibleSwapCount) {
    currentSwapIndex.value++
  }
}

const showAddSkillForm = ref(false)
const skillname = ref('')

function toggleAddSkillForm() {
  showAddSkillForm.value = !showAddSkillForm.value
}

async function addSkill() {
  const newSkill = skillname.value.trim();
  if (!newSkill) {
    alert('Please enter a skill name');
    return;
  }

  // Client-side duplicate check (case-insensitive)
  const exists = mySkills.value.some(skill => skill.name.toLowerCase() === newSkill.toLowerCase());
  if (exists) {
    alert('This skill already exists in your list.');
    return;
  }

  try {
    const response = await fetch('http://localhost/skillSwapPHP/addSkill.php', {
      method: 'POST',
      credentials: 'include',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ skill: newSkill })
    });

    const result = await response.json();

    if (response.ok) {
      if (result.message === "Skill already exists.") {
        alert('This skill already exists on the server.');
      } else {
        mySkills.value.push({
          name: newSkill,
          image: rappingImg
        });
        alert('Skill added successfully!');
        skillname.value = '';
        showAddSkillForm.value = false;
      }
    } else {
      alert(result.message || 'Failed to add skill.');
    }
  } catch (error) {
    console.error('Error adding skill:', error);
    alert('An error occurred while adding the skill.');
  }
}

async function deleteSkill(skillName) {
  if (!confirm(`Are you sure you want to delete "${skillName}"?`)) return;

  try {
    const response = await fetch('http://localhost/skillSwapPHP/deleteSkill.php', {
      method: 'POST',
      credentials: 'include',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ skill: skillName })
    });

    const result = await response.json();

    if (response.ok && result.success) {
      mySkills.value = mySkills.value.filter(skill => skill.name !== skillName);
      alert('Skill deleted successfully!');
    } else {
      alert(result.message || 'Failed to delete skill.');
    }
  } catch (error) {
    console.error('Error deleting skill:', error);
    alert('An error occurred while deleting the skill.');
  }
}
</script>



<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
