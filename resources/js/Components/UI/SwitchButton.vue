<script setup>
const props = defineProps({
  label: String,
  modelValue: {
    default: false
  }
})
</script>

<template>
  <div class="flex items-center justify-center w-full mb-12">

    <label for="toggle" class="flex items-center cursor-pointer">
      <div class="relative">
        <input :checked="modelValue" type="checkbox" id="toggle"
          @change="$emit('update:modelValue', $event.target.checked)" class="sr-only">
        <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
      </div>
      <div class="ml-3 text-gray-700 font-medium">
        {{ label }}

      </div>
    </label>
  </div>
</template>

<style scoped>
input:checked~.dot {
  transform: translateX(100%);
  background-color: #48bb78;
}
</style>