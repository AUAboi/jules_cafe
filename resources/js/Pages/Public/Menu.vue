<script setup>
import CategoryNav from "@/Components/Navigation/CategoryNav.vue"
import CartButtons from "@/Components/Cart/CartButtons.vue";
import Paginator from "@/Components/Paginator.vue";
import { Head } from "@inertiajs/inertia-vue3";

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
      <div v-for="dish in dishes.data" :key="dish.id">
        <div class="bg-white rounded-t-xl w-60">
          <img class="w-full h-56 rounded-t-xl" :src="dish.image ?? '/storage/site_images/samplefood.jpg'"
            :alt="dish.name + ' image'">
          <div class="p-2 ">
            <div class="flex justify-between py-2 font-bold">
              <h2 class="bold">{{ dish.name }} </h2>
              <h2>{{ dish.price }} </h2>
            </div>

            <CartButtons :dish="dish" :cart="cart" />
          </div>
        </div>
      </div>
    </div>
    <Paginator class="text-center" :links="dishes.links" />
  </section>


</template>