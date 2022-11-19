<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import DataTable from '@/Components/Table/DataTable.vue';
import PageTitle from '@/Components/UI/PageTitle.vue';
import SearchBox from '@/Components/UI/SearchBox.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import throttle from 'lodash/throttle';
import { reactive, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import pickBy from 'lodash/pickBy';

const props = defineProps({
  orders: Object,
  filters: Object
})

const form = reactive({
  search: props.filters.search,
  status: props.filters.status
})

const reset = () => {
  form.search = null;
  form.status = null;
}

watch(
  form,
  throttle(() => {
    Inertia.get(route("admin.orders"), pickBy(form), {
      preserveState: true,
      preserveScroll: true,
    });
  }, 200),
  { deep: true }
);

const labels = [
  {
    key: "order_no",
    value: "Order No.",
  },
  {
    key: "user_name",
    value: "Customer Name",
  },
  {
    key: "phone",
    value: "Phone Number",
  },
  {
    key: "type",
    value: "Order Type"
  },
  {
    key: "total",
    value: "Total Bill",
  },
  {
    key: "created_at",
    value: "Placed"
  },
  {
    key: "status",
    value: "Status"
  }
];

</script>
<template>

  <Head title="Orders"></Head>
  <PageTitle>Orders</PageTitle>
  <div class="container mx-auto my-6">
    <SearchBox class="w-full max-w-md my-4" v-model="form.search" filterable @reset="reset">
      <div class="flex flex-col gap-4">
        <DropdownLink as="p" @click.prevent="form.status = null" class="cursor-pointer">All</DropdownLink>
        <DropdownLink as="p" @click.prevent="form.status = 'pending'" class="cursor-pointer">Pending</DropdownLink>
        <DropdownLink as="p" @click.prevent="form.status = 'preparing'" class="cursor-pointer">Pending</DropdownLink>
        <DropdownLink as="p" @click.prevent="form.status = 'cancelled'" class="cursor-pointer">Cancelled
        </DropdownLink>
        <DropdownLink as="p" @click.prevent="form.status = 'completed'" class="cursor-pointer">Completed
        </DropdownLink>
      </div>
    </SearchBox>

    <div class="bg-white rounded-md shadow overflow-x-auto">
      <DataTable :labels="labels" :table-data="orders.data" resource-route="admin.orders.show" />

    </div>

  </div>
</template>