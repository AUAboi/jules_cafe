<script setup>
const props = defineProps({
  dish: Object
})
</script>

<template>
  <div class="bg-white rounded-b-xl w-fit ">
    <img v-if="dish.image" class="w-60 h-56" :src="dish.image" :alt="dish.name + ' image'">
    <img v-else class="w-60" src="/storage/site_images/samplefood.jpg" :alt="dish.name + ' image'">
    <div class="p-2 ">
      <h2 class="bold">{{ dish.name }} </h2>
      <h2>{{ dish.price }} </h2>
    </div>
  </div>
</template>