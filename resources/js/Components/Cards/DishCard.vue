<script setup>
const props = defineProps({
  dish: Object
})
</script>

<template>
  <div class="bg-white rounded-t-xl w-60">
    <img class="w-full h-56 rounded-t-xl" :src="dish.image ?? '/site_images/samplefood.jpg'"
      :alt="dish.name + ' image'">
    <div class="p-2 ">
      <div class="flex justify-between py-2 font-bold">
        <h2 class="bold">{{ dish.name }} </h2>
        <h2 class="whitespace-nowrap">{{ dish.price }} </h2>
      </div>
      <slot />
    </div>
  </div>
</template>