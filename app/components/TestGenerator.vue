<script setup lang="ts">
import TestChar, {type TypeErrorEventPayload} from "~/components/TestChar.vue";

const props = defineProps<{
    text: string
    typeError?: (payload: TypeErrorEventPayload) => void
    complete?: (payload: {id: number}) => void
    start?: (payload: {id: number}) => void
  }>();

  const countSpaces = ref(0);
</script>

<template>
  <div class="flex-wrap space-x-0 space-y-0 m-0 p-0 ">
    <TestChar
        v-for="(char, index) in props.text"
        :key="index"
        :id="index"
        :char="char"
        @type-error="props.typeError"
        @complete="props.complete"
        @start="props.start"
        @on-key-press="payload => countSpaces += Number(payload.char === ' ')"
        class="space-y-20 space-x-0 margin: 0 p-0 m-0"
    />
  </div>
</template>

<style scoped>

</style>