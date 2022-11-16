<script setup>
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



  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4 my-10">
    <Link as="div" :href="route('menu', { category: category.id })" v-for="category in categories" :key="category.id"
      class="bg-white rounded-b-xl w-fit cursor-pointer ">
    <div class="card">
      <div
        :style="{ backgroundImage: `url(${category.image ? category.image : '/storage/site_images/samplefood.jpg'})` }"
        class="bg-image relative w-56 h-56 flex justify-center items-center bg-cover bg-center">
        <div class="overlay "></div>
        <h2 class="text-2xl text-white z-20 opacity-0">{{ category.name }}</h2>
      </div>
    </div>

    <div class="p-2 text-center text-xl">
      <h2 class="font-bold">{{ category.name }} </h2>
    </div>
    </Link>




  </div>
</template>

<style scoped>
.overlay {
  transition: all 500ms ease-in-out;
  background-color: rgba(0, 0, 0, 0.616);
  position: absolute;
  width: 14rem;
  height: 14rem;
  max-height: 0px;

}

.bg-image {
  transition: all 500ms ease-in-out;

}

.bg-image {
  overflow: hidden;

}

.card {
  overflow: hidden;
}

.card:hover .overlay {
  max-height: 1000px;
}

.card:hover .bg-image {
  transform: scale(1.2);
}

.card:hover .bg-image h2 {
  opacity: 1;
}
</style>