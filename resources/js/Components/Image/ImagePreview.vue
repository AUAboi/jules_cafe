
<script setup>

const props = defineProps({
  image: {
    required: false,
  }
})

const generateImagePreview = () => {
  if (typeof props.image === 'string') {
    return props.image;
  }
  return URL.createObjectURL(props.image);
};
</script>
<template>
  <div class="flex flex-wrap mb-4">
    <div class="w-6/12 flex-grow relative">
      <img class="rounded-lg" :src="generateImagePreview()" />
    </div>
  </div>
</template>
