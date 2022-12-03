<script setup>
import { computed } from '@vue/reactivity';

const props = defineProps({
  dish: Object
})

const ingredients = computed(() => {
  return props.dish.ingredients.split(",")
})
</script>

<template>
  <div class="bg-white rounded-t-xl w-60">
    <img class="w-full h-56 rounded-t-xl" :src="dish.image ?? '/site_images/samplefood.jpg'"
      :alt="dish.name + ' image'">
    <div class="px-2 flex gap-4" v-if="dish.ingredients">
      <span v-for="(ingredient, index) in ingredients" :key="index"
        class="tracking-widest text-xs font-medium text-gray-500 mb-1 mr-3">{{ ingredient }}</span>
    </div>
    <div class="p-2">
      <div class="flex justify-between py-2 font-bold">
        <h2 class="bold">{{ dish.name }} </h2>
        <h2 class="whitespace-nowrap">{{ dish.price }} </h2>
      </div>
      <slot />
    </div>
  </div>
</template>