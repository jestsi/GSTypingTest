<script setup lang="ts">
import {computed, ref} from 'vue';

const isOpen = ref<boolean>(false);
const text = ref<string>('Тестовый текст для проверки');
const userInput = ref<string>('');
const currentIndex = ref(0);

const words = computed(() => {
  return text.value.split(' ');
});

const handleInput = () => {
  const userChar = userInput.value.charAt(userInput.value.length - 1);
  const correctChar = words.value[currentIndex.value].charAt(userInput.value.length - 1);

  if (userChar === correctChar) {
    if (userInput.value.length === words.value[currentIndex.value].length) {
      userInput.value = '';
      currentIndex.value++;
    }
  } else {
    userInput.value = userInput.value.slice(0, -1);
  }
};

const highlightClass = (index: number) => {
  return {
    'text-green-500': index < currentIndex.value,
    'text-blue-500': index === currentIndex.value,
    'text-gray-500': index > currentIndex.value
  };
};

</script>

<template>
  <input ref="textInput" @input="handleInput" v-model="userInput" />
  <UTextarea readonly="readonly" rows="3" v-model="text" />
</template>

<style scoped>

</style>
