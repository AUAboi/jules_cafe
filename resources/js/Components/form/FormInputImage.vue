<script setup>
const props = defineProps({
  id: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: false,
  }
});


</script>

<template>
  <div>
    <label v-if="label" class="form-label">{{ label }}:</label>
    <input type="file" :id="id" @change="$emit('selected', $event.target.files)" />
  </div>
</template>

