<script setup>
import CategoryNav from "@/Components/Navigation/CategoryNav.vue"
import CartButtons from "@/Components/Cart/CartButtons.vue";
import Paginator from "@/Components/Paginator.vue";
import { Head } from "@inertiajs/inertia-vue3";
import DishCard from "@/Components/Cards/DishCard.vue";

const props = defineProps({
  dishes: { required: true },
  categories: Array,
  cart: { default: {} }
})


</script>

<template>

  <Head title="Menu"></Head>
  <section class="bg-gray-100 ">
    <CategoryNav :categories="categories" />
    <div class="my-6">
      <h2 class="text-4xl text-center ">Menu</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4 pb-6">
      <DishCard v-for="dish in dishes.data" :key="dish.id" :dish="dish">
        <CartButtons :dish="dish" :cart="cart" />
      </DishCard>
    </div>
    <Paginator class="text-center" :links="dishes.links" />
  </section>


</template>