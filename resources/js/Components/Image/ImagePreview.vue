
<script setup>

const props = defineProps({
  image: {
    required: false,
  }
})

const generateImagePreview = (image) => {
  return URL.createObjectURL(image);
};
</script>
<template>
  <div class="flex flex-wrap mb-4">
    <div class="w-6/12 flex-grow relative">

      <img class="rounded-lg" :src="generateImagePreview(image)" />
    </div>
  </div>
</template>
