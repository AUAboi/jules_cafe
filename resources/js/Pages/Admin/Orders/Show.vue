<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';
import { watch } from 'vue';

const props = defineProps({
  order: { type: Object, required: true },
  dishes: { type: Object, required: true },
  user: { type: Object, required: true }
})

const form = useForm({
  status: props.order.status
})


watch(
  form,
  throttle(() => {
    Inertia.put(route("admin.orders.update", props.order.order_no), pickBy(form), {
      preserveState: true,
      preserveScroll: true,
    });
  }, 200),
  { deep: true }
);
</script>

<template>
  <PageTitle>Order # {{ order.order_no }}</PageTitle>
  <div class="bg-white shadow mt-4 max-w-lg mx-auto rounded-md flex items-center px-2 py-2 gap-4">
    <p class="font-bold">Status</p>
    <select class="form-select px-6 pb-8 w-full lg:w-1/2" v-model="form.status">
      <option value="pending">Pending</option>
      <option value="preparing">Preparing</option>
      <option value="completed">Completed</option>
      <option value="cancelled">Cancelled</option>
    </select>
  </div>
  <div class="bg-white shadow mt-4 max-w-lg mx-auto rounded-md ">
    <p class="px-1 font-bold">
      Order
    </p>
    <div class="flex flex-col gap-4  py-4 px-2 border-t">
      <Link class="font-bold text-blue-500 underline">
      Profile
      </Link>
      <p>
        Order by: {{ user.name }}
      </p>
      <p>
        Phone: {{ user.phone }}
      </p>

      <p>
        Dated: {{ order.created_at }}
      </p>

    </div>
    <p class="text-end text-xs">
      {{ order.time }}

    </p>
  </div>
  <div class="bg-white shadow mt-4 max-w-lg mx-auto rounded-md">
    <h2 class="px-2 border-b font-bold">Items</h2>
    <div class="py-4 ">
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

  </div>
</template>

<style scoped>
.form-select {
  @apply p-2 pr-6 leading-normal block border text-gray-700 bg-white font-sans rounded text-left appearance-none relative;
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAQCAYAAAAMJL+VAAAABGdBTUEAALGPC/xhBQAAAQtJREFUOBG1lEEOgjAQRalbGj2OG9caOACn4ALGtfEuHACiazceR1PWOH/CNA3aMiTaBDpt/7zPdBKy7M/DCL9pGkvxxVp7KsvyJftL5rZt1865M+Ucq6pyyF3hNcI7Cuu+728QYn/JQA5yKaempxuZmQngOwEaYx55nu+1lQh8GIatMGi+01NwBcEmhxBqK4nAPZJ78K0KKFAJmR3oPp8+Iwgob0Oa6+TLoeCvRx+mTUYf/FVBGTPRwDkfLxnaSrRwcH0FWhNOmrkWYbE2XEicqgSa1J0LQ+aPCuQgZiLnwewbGuz5MGoAhcIkCQcjaTBjMgtXGURMVHC1wcQEy0J+Zlj8bKAnY1/UzDe2dbAVqfXn6wAAAABJRU5ErkJggg==");
  background-size: 0.7rem;
  background-repeat: no-repeat;
  background-position: right 0.7rem center;
}
</style>