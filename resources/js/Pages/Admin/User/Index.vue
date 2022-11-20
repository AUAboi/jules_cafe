<script setup>
import DataTable from '@/Components/Table/DataTable.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';
import { reactive, watch } from 'vue';

const props = defineProps({
  filters: Object,
  users: {
    required: false
  }
});

const form = reactive({
  search: props.filters.search,
})

const reset = () => {
  form.search = null;
}


watch(
  form,
  throttle(() => {
    Inertia.get(route("admin.users"), pickBy(form), {
      preserveState: true,
      preserveScroll: true,
    });
  }, 200),
  { deep: true }
);

const labels = [
  {
    key: "id",
    value: "ID",
  },
  {
    key: "name",
    value: "Name"
  },
  {
    key: "phone",
    value: "Phone"
  },
  {
    key: "created_at",
    value: "Acccount created at"
  },
  {
    key: "last_order",
    value: "Last order"
  }

]

</script>



<template>
  {{ users }}

  <Head title="Users"></Head>
  <div class="container mx-auto my-6">
    <SearchBox class="w-full max-w-md my-4" v-model="form.search" @reset="reset" />

    <div class="bg-white rounded-md shadow overflow-x-auto max-w-5xl">
      <DataTable :table-data="users.data" :labels="labels" resource-route="admin.users.show" />
    </div>
  </div>

</template>