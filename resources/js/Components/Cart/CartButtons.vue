<script setup>
import { useForm } from "@inertiajs/inertia-vue3"

const props = defineProps({
  dish: Object,
  cart: Object
})


const form = useForm({
  id: null
})

const addToCart = (id) => {
  form.id = id
  form.post(route('cart.add'), {
    preserveScroll: true,
    preserveState: true
  })
}

const removeFromCart = (id) => {
  form.id = id
  form.post(route('cart.remove'), {
    preserveScroll: true,
    preserveState: true
  })
}
</script>

<template>
  <div>
    <div class="flex justify-between items-center" v-if="cart[dish.id]">
      <button @click.prevent="addToCart(dish.id)" :disabled="form.processing"
        class="bg-yellow-500 text-white py-1 px-8 rounded" :class="form.processing ? 'opacity-50' : ''">+</button>

      <span class="text-xl">{{ cart[dish.id]?.quantity }}</span>
      <button :class="form.processing ? 'opacity-50' : ''" class="bg-red-500 text-white py-1 px-8 rounded"
        :disabled="form.processing" @click.prevent="removeFromCart(dish.id)">-</button>
    </div>
    <div class="text-center" v-else>
      <button @click.prevent="addToCart(dish.id)" :disabled="form.processing" class="bg-yellow-500 px-2 py-1 rounded "
        :class="form.processing ? 'opacity-50' : ''">Add to
        cart </button>

    </div>
  </div>
</template>