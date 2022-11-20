<script setup>
import CategoryCard from '@/Components/Cards/CategoryCard.vue';
import PageTitle from '@/Components/UI/PageTitle.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';




const props = defineProps({
  categories: {
    required: true,
  },
})


</script>

<template >

  <Head title="Category" />


  <div class="max-w-4xl mx-auto">
    <h1 class="text-4xl mt-4 text-center">View Categories</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4 my-10">
      <Link as="div" :href="route('menu', { category: category.id })" v-for="category in categories" :key="category.id"
        class="bg-white rounded-b-xl w-fit cursor-pointer ">
      <CategoryCard :category="category" />
      </Link>
    </div>
  </div>

</template>
