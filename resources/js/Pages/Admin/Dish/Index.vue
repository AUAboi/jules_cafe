<script setup>
import Paginator from '@/Components/Paginator.vue';
import PageTitle from '@/Components/UI/PageTitle.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import { reactive, watch } from 'vue';
import DishCard from '@/Components/Cards/DishCard.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
  dishes: {
    required: true,
  },
  filters: Object
})

const form = reactive({
  search: props.filters.search,
  active: props.filters.active
})

const reset = () => {
  form.search = null;
  form.active = null
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
  <div class="flex flex-col md:flex-row items-center justify-evenly my-8">
    <SearchBox class="w-full max-w-md my-4" v-model="form.search" filterable @reset="reset">
      <div class="flex flex-col gap-4">
        <DropdownLink as="p" class="cursor-pointer" :href="route('admin.dish')">All</DropdownLink>
        <DropdownLink as="p" class="cursor-pointer" :href="route('admin.dish', { active: 1 })">Active</DropdownLink>
        <DropdownLink as="p" class="cursor-pointer" :href="route('admin.dish', { active: 0 })">Inactive</DropdownLink>
      </div>

    </SearchBox>
    <Link :href="route('admin.dish.create')" as="button" class="primary-btn h-fit">
    Add new dish
    </Link>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
    <DishCard v-for="dish in dishes.data" :key="dish.id" :dish="dish"
      :class="dish.active ? 'opacity-100' : 'opacity-60'">
      <div class="flex justify-between items-center">
        <Link :href="route('admin.dish.edit', dish.id)" as="button" class="primary-btn">Edit</Link>
        <Link method="put" :href="route('admin.dish.activate', dish.id)" v-if="!dish.active"
          class="underline text-gray-900 text-sm">
        Activate?</Link>
      </div>
    </DishCard>
  </div>
  <Paginator :links="dishes.links" />
</template>