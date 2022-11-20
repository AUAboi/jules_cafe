<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import { reactive, watch } from 'vue';
import DropdownLink from '@/Components/DropdownLink.vue';




const props = defineProps({
  categories: {
    required: true,
  },
  filters: {
    default: { search: "" }
  }
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
    Inertia.get(route("admin.category"), pickBy(form), {
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
    Category
  </PageTitle>

  <div class="flex flex-col md:flex-row items-center justify-evenly my-8">
    <SearchBox class="w-full max-w-md my-4" v-model="form.search" filterable @reset="reset">
      <DropdownLink as="p" :href="route('admin.category')" class="cursor-pointer">All</DropdownLink>
      <DropdownLink as="p" :href="route('admin.category', { active: 1 })">Active</DropdownLink>
      <DropdownLink as="p" :href="route('admin.category', { acti  ve: 0 })" class="cursor-pointer">Inactive</DropdownLink>

    </SearchBox>
    <Link :href="route('admin.category.create')" as="button" class="primary-btn h-fit">
    Add new category
    </Link>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
    <div v-for="ca  tegory in categories" :key="category.id" class="bg-white rounded-b-xl w-fit "
      :class="category.active ? 'opacity-100' : 'opacity-60'">
      <img v-if="category.image" class="w-60 h-56" :src="category.image" :alt="category.name + ' image'">
      <img v-else class="w-60" src="/site_images/samplefood.jpg" :alt="category.name + ' image'">
      <div class="p-2 text-center text-xl">
        <h2 class="font-bold">{{ category.name }} </h2>
      </div>
      <div class="flex justify-between items-center p-2">
        <Link :href="route('admin.category.edit', category.id)" as="button" class="primary-btn">Edit</Link>
        <Link method="put" as="span" :href="route('admin.category.activate', category.id)" v-if="!category.active"
          class="underline text-gray-900 text-sm">
        Activate?</Link>
      </div>
    </div>
  </div>
</template>