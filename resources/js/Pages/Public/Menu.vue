<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3"

const props = defineProps({
  dishes: { required: true },
  cart: { default: [] }
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
  {{ cart }}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
    <div class="" v-for="dish in dishes.data" :key="dish.id">
      <div class="bg-white rounded-b-xl w-fit ">
        <img v-if="dish.image" class="w-60 h-56" :src="dish.image" :alt="dish.name + ' image'">
        <img v-else class="w-60" src="/storage/site_images/samplefood.jpg" :alt="dish.name + ' image'">
        <div class="p-2 ">
          <h2 class="bold">{{ dish.name }} </h2>
          <h2>{{ dish.price }} </h2>
          <div class=" flex justify-between">
            <div>
              <button @click.prevent="addToCart(dish.id)" :disabled="form.processing"
                class="bg-yellow-500 px-2 py-1 rounded">Add to
                cart </button>
              <span class="mx-4">
                {{ cart[dish.id]?.quantity }}

              </span>
            </div>
            <button :disabled="form.processing" @click.prevent="removeFromCart(dish.id)"
              v-if="cart[dish.id]">Remove</button>
          </div>

        </div>
      </div>

    </div>
  </div>

</template>