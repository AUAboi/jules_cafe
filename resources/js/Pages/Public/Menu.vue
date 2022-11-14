<script setup>
import CategoryNav from "@/Components/Navigation/CategoryNav.vue"
import CartButtons from "@/Components/Cart/CartButtons.vue";
import Paginator from "@/Components/Paginator.vue";

const props = defineProps({
  dishes: { required: true },
  categories: Array,
  cart: { default: {} }
})


</script>

<template>
  <section class="bg-gray-100 ">
    <CategoryNav :categories="categories" />
    <h2 class="text-4xl text-center my-6">Menu</h2>
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