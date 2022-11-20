<script setup>
import DataTable from '@/Components/Table/DataTable.vue';
import AppButton from '@/Components/UI/AppButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  user: {
    required: true,
  },
  orders: Object
})

const destroy = () => {
  if (confirm('Do you really want to delete')) {
    Inertia.delete(route('admin.users.destroy', props.user.id));

  }
}
const labels = [
  {
    key: "order_no",
    value: "Order No.",
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

  <div class="bg-white shadow mt-4 max-w-lg mx-auto rounded-md ">
    <p class="px-1 font-bold">
      Details
    </p>
    <div class="flex flex-col gap-4  py-4 px-2 border-t">

      <p>
        Name: {{ user.name }}
      </p>
      <p>
        Phone: {{ user.phone }}
      </p>
      <p>
        Email: {{ user.email }}
      </p>
      <p>
        Created since: {{ user.created_at }}
      </p>
      <div>
        <AppButton @click.prevent="destroy" class="primary-btn text-center">Delete</AppButton>
      </div>
    </div>

  </div>

  <div class="bg-white shadow mt-4 max-w-5xl mx-auto rounded-md overflow-x-auto">

    <DataTable :table-data="orders.data" :labels="labels" resource-route="admin.orders.show" />
  </div>
</template>