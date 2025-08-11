<script setup lang="ts">
import Header from '@/components/Header.vue';
import { Link, router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    orders: Array,
});

const deleteOrder = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('products.destroy', id));
    }
};
</script>

<template>
    <Head title="Products list" />
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <Header />
        <h1 class="dark:bg-[#161615] dark:text-[#EDEDEC]">Orders list</h1>
        <div class="flex w-full justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-4xl flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                <div class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-6 text-[13px] leading-[20px] dark:bg-[#161615] dark:text-[#EDEDEC]">
                    <table class="w-full table-auto border-collapse border border-gray-300 border-white">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total amount</th>
                            <th>Action</th>
                        </thead>
                        <tbody v-if="orders?.length">
                            <tr v-for="(order, index) in props.orders" :key="index" class="border-t">
                                <td class="p-1">{{ order.customer_name }}</td>
                                <td class="text-center">{{ order.customer_email }}</td>
                                <td class="text-center">{{ order.total_amount }}</td>
                                <td class="w-30 text-center">
                                    <Link :href="route('orders.edit', { order: order.id })" class="mr-1"> Edit </Link>
                                    <Link href="#" @click="deleteOrder(order.id)">Delete</Link>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="border-t">
                                <td colspan="4">Empty!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
