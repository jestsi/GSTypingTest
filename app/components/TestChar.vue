<template>
  <div
      :id="`test-char-${id}`"
      ref="testChar"
      @keydown="handleKeyDown"
      tabindex="0"
      class="test-char shadow-lg inline-block text-center text-gray-500 font-bold focus:border-spacing-3"
      :class="{ active: isActive, hasDanger: hasDanger }"
  >
    <label >{{ char }}</label>
  </div>
</template>


<script setup lang="ts">
import {onMounted, ref} from 'vue';
import Stopwatch from "@tsdotnet/stopwatch";

const props = defineProps<{
  char: string
  id: number
}>();

const charProp = props.char;
const testChar = ref<HTMLElement | null>(null);
const isActive = ref(false);
const hasDanger = ref(false);
const timer = new Stopwatch();
export interface TypeErrorEventPayload {
  isErrorChar: boolean,
}

const emits = defineEmits<{
  (event: 'typeError', payload: TypeErrorEventPayload): void
  (event: 'complete', payload: {id: number}): void
  (event: 'start', payload: {id: number}): void
  (event: 'onKeyPress', payload: {id: number, char: string}): void
}>();

const handleKeyDown = (event: KeyboardEvent) => {
  emits('onKeyPress', {id: props.id, char: props.char});
  if (props.id === 0) emits('start', {id: props.id});
  if (event.key === 'CapsLock') return;
  if (event.key === 'Tab') behindCharFocus();
  isActive.value = event.key === charProp;
  hasDanger.value = !isActive.value;
  if (isActive.value && !hasDanger.value) nextCharFocus();
  if (hasDanger.value)
    emits('typeError', {isErrorChar: hasDanger.value});
};

const nextCharFocus = () => {
  const nextId = `test-char-${props.id + 1}`;
  const nextCharElement = document.getElementById(nextId);
  if (nextCharElement) {
    nextCharElement.focus();
  } else {
    emits('complete', {id: props.id});
  }
};

const behindCharFocus = () => {
  const nextId = `test-char-${props.id - 1}`;
  const nextCharElement = document.getElementById(nextId);
  if (nextCharElement) {
    nextCharElement.focus();
  } else {
    emits('typeError', {isErrorChar: hasDanger.value});
  }
};
onMounted(() => {
  const nextId = `test-char-${0}`;
  const nextCharElement = document.getElementById(nextId);
  if (nextCharElement)
    nextCharElement.focus();
})
</script>

<style lang="css" scoped>
.test-char {
  width: 10px;
  height: 24px;
}

.active {
  color: white;
}

.hasDanger {
  color: orangered;
}
</style>
