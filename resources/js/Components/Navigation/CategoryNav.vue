<script setup>
import { Link } from "@inertiajs/inertia-vue3"

const props = defineProps({
  categories: Array
})


const isActive = (id) => { return route().current('menu', { category: id }); }

</script>
<template>
  <nav
    class="text-lg overflow-x-auto whitespace-no-wrap md:whitespace-normal flex bg-gray-800 text-yellow-300 gap-4 md:gap-2 md:justify-center ">
    <Link :class="isActive(null) ? 'bg-yellow-300 text-gray-800 font-bold' : ''" as="button" :href="route('menu')"
      class="p-1 sm:p-3 md:p-4 hover:bg-yellow-300 hover:text-gray-800 focus:outline-none ">
    All
    </Link>
    <Link v-for="category in categories" :key="category.id" as="button" :href="route('menu', {
      category:
        category.id
    })" :class="isActive(category.id) ? 'bg-yellow-300 text-gray-800 font-bold' : ''"
      class="p-1 sm:p-3 md:p-4 hover:bg-yellow-300 hover:text-gray-800 focus:outline-none">
    {{ category.name }}</Link>


  </nav>
</template>
