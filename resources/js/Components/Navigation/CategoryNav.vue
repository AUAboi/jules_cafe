<script setup>
import { Link } from "@inertiajs/inertia-vue3"

const props = defineProps({
  categories: Array
})


const isActive = (id) => { return route().current('menu', { category: id }); }

</script>
<template>
  <nav
    class="text-lg overflow-x-auto whitespace-no-wrap md:whitespace-normal flex bg-orange-500 gap-4 md:gap-2 md:justify-center">
    <Link :class="isActive(null) ? 'bg-yellow-300' : ''" as="button" :href="route('menu')"
      class="p-1 sm:p-3 md:p-4 hover:bg-orange-300 focus:outline-none">
    All
    </Link>
    <Link v-for="category in categories" :key="category.id" as="button" :href="route('menu', {
      category:
        category.id
    })" :class="isActive(category.id) ? 'bg-yellow-300' : ''"
      class="p-1 sm:p-3 md:p-4 hover:bg-orange-300 focus:outline-none">
    {{ category.name }}</Link>


  </nav>
</template>