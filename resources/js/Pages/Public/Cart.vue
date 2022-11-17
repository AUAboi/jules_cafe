<script setup>
import { Link, Head } from "@inertiajs/inertia-vue3"

import CartItem from '@/Components/Cart/CartItem.vue';
import { computed } from "@vue/reactivity";

const props = defineProps({
  cart: Object
})


const hasCartItems = computed(() => {
  return Object.keys(props.cart.content).length
});
</script>

<template>

  <Head title="View Cart"></Head>
  <div v-if="hasCartItems">
    <div class="flex justify-evenly flex-wrap  my-10">
      <div class=" bg-white px-10 py-10">
        <div class="flex justify-between border-b pb-8">
          <h1 class="font-semibold text-2xl">Cart</h1>
          <h2 class="font-semibold text-2xl">{{ cart.quantity }} Items</h2>
        </div>
        <div class="flex mt-10 mb-5">
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Dish</h3>
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Quantity</h3>
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Price</h3>
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
        </div>
        <CartItem v-for="item in cart.content" :cartDish="item" :key="item.id" />
        <Link :href="route('menu')" class="flex font-semibold text-yellow-600 text-sm mt-10">
        <svg class="fill-current mr-2 text-yellow-600 w-4" viewBox="0 0 448 512">
          <path
            d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
        </svg>
        Continue Shopping
        </Link>
      </div>

      <div id="summary" class=" px-8 py-10">
        <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
        <div class="flex justify-between mt-10 mb-5">
          <span class="font-semibold text-sm uppercase">{{ cart.quantity }} Items</span>
          <span class="font-semibold text-sm">{{ cart.total }}</span>
        </div>
        <div>
          <label class="font-medium inline-block mb-3 text-sm uppercase">Shipping</label>
          <select class="block p-2 text-gray-600 w-full text-sm">
            <option>Standard shipping - $10.00</option>
          </select>
        </div>
        <div class="my-4">
          <div>
            <input id="takeaway" name="type" type="radio">
            <label for="takeaway" class="font-medium inline-block mb-3 text-sm uppercase px-2">Take away</label>

          </div>
          <div>
            <input id="dinein" name="type" type="radio">
            <label for="dinein" class="font-medium inline-block mb-3 text-sm uppercase px-2">Dine-in</label>
          </div>

        </div>
        <div class="flex flex-col gap-1 py-10">
          <label for="note" class="font-semibold inline-block mb-3 text-sm uppercase">Special instructions</label>
          <textarea name="note" id="note" cols="20" rows="5" class="resize-none"></textarea>
        </div>
        <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
        <div class="border-t mt-8">
          <div class="flex font-semibold justify-between py-6 text-sm uppercase">
            <span>Total cost</span>
            <span>{{ cart.total }}</span>
          </div>
          <button
            class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-sm text-white uppercase w-full">Checkout</button>
        </div>
      </div>

    </div>
  </div>
  <div class="text-4xl py-16 text-center">
    <h1>Oops, it seems your cart is empty</h1>
  </div>


</template>

<style scoped>
#summary {
  background-color: #f6f6f6;
}
</style>