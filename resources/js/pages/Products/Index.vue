<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    products: Array,
});

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('products.destroy', id));
    }
};
</script>

<template>
    <Head title="Products list" />
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    :href="route('products.create')"
                    class="inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Add product
                </Link>
            </nav>
        </header>
        <div class="flex w-full justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-4xl flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                <div class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-6 text-[13px] leading-[20px] dark:bg-[#161615] dark:text-[#EDEDEC]">
                    <table class="w-full table-auto border-collapse border border-gray-300 border-white">
                        <thead>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </thead>
                        <tbody v-if="products?.length">
                            <tr v-for="(product, index) in props.products" :key="index" class="border-t">
                                <td class="p-1">
                                    <b class="inline-block w-full">{{ product.name }}</b>
                                    <small>{{ product.description }}</small>
                                </td>
                                <td class="text-center">{{ product.price }}</td>
                                <td class="text-center">{{ product.stock_quantity }}</td>
                                <td class="w-30 text-center">
                                    <Link :href="route('products.edit', { product: product.id })" class="mr-1"> Edit </Link>
                                    <Link href="#" @click="deleteProduct(product.id)">Delete</Link>
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
