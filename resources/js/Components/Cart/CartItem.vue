<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3"
import { computed } from "@vue/reactivity";
const props = defineProps({
  cartDish: Object
})

const form = useForm({
  id: null
})

const ingredients = computed(() => {
  return props.cartDish.ingredients.split(",")
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

const removeItem = (id) => {
  form.id = id
  form.post(route('cart.removeitem'), {
    preserveScroll: true,
    preserveState: true
  })
}
</script>

<template>
  <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
    <div class="flex sm:w-2/5">
      <div>
        <img class="h-14 w-24 sm:w-36 sm:h-24" :src="cartDish.image ?? '/site_images/samplefood.jpg'">
      </div>
      <div class="flex flex-col justify-between ml-4 flex-grow">
        <span class="font-bold text-sm">{{ cartDish.name }}</span>
        <div class="flex flex-col" v-if="cartDish.ingredients">
          <span v-for="(ingredient, index) in ingredients" :key="index"
            class="tracking-widest text-xs font-medium text-gray-500 mb-1 mr-3">{{ ingredient }}</span>
        </div>
        <span @click="removeItem(cartDish.id)"
          class="font-semibold hover:text-red-500 text-gray-500 text-xs cursor-pointer">Remove</span>
      </div>
    </div>
    <div class="flex justify-center w-1/5 items-center">
      <div class="cursor-pointer" @click="removeFromCart(cartDish.id)">
        <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
          <path
            d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
        </svg>

      </div>

      <span class="mx-2 border text-center w-8">{{ cartDish.quantity }}</span>
      <div class="cursor-pointer" @click="addToCart(cartDish.id)">
        <svg class=" fill-current text-gray-600 w-3" viewBox="0 0 448 512">
          <path
            d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
        </svg>
      </div>


    </div>
    <span class="text-center w-1/5 font-semibold text-sm">{{ cartDish.price }}</span>
    <span class="text-center w-1/5 font-semibold text-sm">{{ cartDish.total_price }}</span>
  </div>
</template>