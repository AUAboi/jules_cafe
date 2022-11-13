<script setup>
import { useForm } from "@inertiajs/inertia-vue3"

import CategoryNav from "@/Components/Navigation/CategoryNav.vue"

const props = defineProps({
  dishes: { required: true },
  categories: Array,
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
  <section class="bg-gray-100">
    <CategoryNav :categories="categories" />
    <h2 class="text-4xl text-center my-6">Menu</h2>
    {{ cart }}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
      <div v-for="dish in dishes.data" :key="dish.id">
        <div class="bg-white rounded-t-xl w-60">
          <img class="w-full h-56 rounded-t-xl" :src="dish.image ?? '/storage/site_images/samplefood.jpg'"
            :alt="dish.name + ' image'">
          <div class="p-2 ">
            <div class="flex justify-between py-2 font-bold">
              <h2 class="bold">{{ dish.name }} </h2>
              <h2>{{ dish.price }} </h2>
            </div>

            <div class=" flex justify-between">
              <div>
                <button @click.prevent="addToCart(dish.id)" :disabled="form.processing"
                  class="bg-yellow-500 px-2 py-1 rounded" :class="form.processing ? 'opacity-50' : ''">Add to
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
  </section>


</template>