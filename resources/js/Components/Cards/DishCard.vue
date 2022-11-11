<script setup>
const props = defineProps({
  dish: Object
})
</script>

<template>
  <div class="bg-white rounded-b-xl w-fit">
    <img class="w-60" :src="`/storage/site_images/${dish.image}`" :alt="dish.name + ' image'">
    <div class="p-2 ">
      <h2>{{ dish.name }} </h2>
      <h2>{{ dish.price }}MYR </h2>
    </div>
  </div>
</template>