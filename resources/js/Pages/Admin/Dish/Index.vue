<script setup>
import PageTitle from '@/Components/PageTitle.vue';
import { Head } from '@inertiajs/inertia-vue3';


const props = defineProps({
  dishes: {
    required: true,
    type: Array
  }
})
</script>

<template>

  <Head title="Menu" />
  <PageTitle>
    Menu
  </PageTitle>
  <div class="grid grid-cols-3 justify-items-center gap-4">
    <div class="bg-white w-fit" v-for="dish in dishes" :key="dish.id">
      <img class="w-60" :src="`/storage/site_images/${dish.image}`" :alt="dish.name + ' image'">
      <div class="p-2 ">
        <h2>{{ dish.name }} </h2>
        <h2>{{ dish.price }}MYR </h2>
      </div>
    </div>
  </div>
</template>