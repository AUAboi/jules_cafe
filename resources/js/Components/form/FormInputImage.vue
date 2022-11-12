<script setup>
const props = defineProps({
  label: {
    type: String,
    required: false,
  },
  error: String,

});


</script>

<template>
  <div>
    <label v-if="label" class="form-label block">{{ label }}:</label>
    <input v-bind="{ ...$attrs, class: null }" type="file" @change="$emit('selected', $event.target.files)"
      class="p-2 leading-normal block w-full border text-gray-700 bg-white font-sans rounded text-left appearance-none relative focus: border-gray-400 focus:ring"
      :class="{ 'focus:ring focus:ring-red-200': error }" />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>



<style  scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}


.form-input.error {
  @apply border-red-500;
}

.form-error {
  @apply text-red-700 mt-2 text-sm;
}
</style>