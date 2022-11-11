<script setup>
import Paginator from '@/Components/Paginator.vue';
import PageTitle from '@/Components/UI/PageTitle.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import { reactive, watch } from 'vue';
import DishCard from '@/Components/Cards/DishCard.vue';




const props = defineProps({
  dishes: {
    required: true,
  },
  filters: {
    default: { search: "" }
  }
})

const form = reactive({
  search: props.filters.search
})

const reset = () => {
  form.search = null;
}

watch(
  form,
  throttle(() => {
    Inertia.get(route("admin.dish"), pickBy(form), {
      preserveState: true,
      preserveScroll: true,
    });
  }, 200),
  { deep: true }
);


</script>

<template>

  <Head title="Menu" />
  <PageTitle>
    Menu
  </PageTitle>
  <SearchBox class="w-full max-w-md mx-auto my-8" v-model="form.search" @reset="reset" />
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
    <DishCard v-for="dish in dishes.data" :key="dish.id" :dish="dish" />
  </div>
  <Paginator :links="dishes.links" />
</template>