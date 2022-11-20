<script setup>
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
  order: Object,
  dishes: Array
})
</script>

<template>

  <Head :title="order.order_no"></Head>
  <div class="p-4 sm:p-6 max-w-2xl mx-auto">
    <div class="mt-6 flex justify-between items-center">
      <h4 class="text-xl sm:text-3xl">Order Number: #{{ order.order_no }}</h4>
      <p class="text-lg">Status: {{ order.status }}</p>

    </div>
    <h4 class="mt-4">{{ order.table_no ? `Dine-in, Table ${order.table_no}` : 'Take away' }}</h4>

    <div class="py-4 border-b">
      <div class="mt-2" v-for="(dish, index) in dishes" :key="index">
        <p class="px-2 flex">
          <span class="text-gray-500">
            x{{ dish.quantity }} &nbsp;
          </span>
          <span>
            {{ dish.name }}
          </span>
          <span class="flex-grow text-end">
            {{ dish.price }}
          </span>
        </p>
      </div>
    </div>
    <h3 class="font-bold">Total: {{ order.total }}</h3>
  </div>
</template>