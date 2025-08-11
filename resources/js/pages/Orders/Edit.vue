<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { defineProps, ref } from 'vue';

const props = defineProps({
    order: Object,
    products: Object,
});

const filteredProducts = ref({});

console.log('props', props.order);

const form = useForm({
    customer_name: props.order.customer_name || '',
    customer_email: props.order.customer_email || '',
    total_amount: props.order.total_amount || 0,
    products: Object.fromEntries(
        Object.values(props.order.products).map((p) => [
            p.id,
            {
                id: p.id,
                quantity: p.pivot.quantity,
            },
        ]),
    ),
});

const submit = () => {
    form.put(route('orders.update', { order: props.order.id }));
};

const removeProduct = (id) => {
    delete form.products[id];
};
</script>

<template>
    <Head :title="'Edit order #' + props.order.id" />
    <div class="flex flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    :href="route('orders.index')"
                    class="inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Orders list
                </Link>
            </nav>
        </header>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <Label for="customer_name" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Customer name</Label>
                        <Input id="customer_name" type="text" required autofocus v-model="form.customer_name" placeholder="Customer name" />
                        <InputError :message="form.errors.customer_name" />
                    </div>

                    <div class="w-1/2">
                        <Label for="customer_email" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Customer email</Label>
                        <Input id="customer_email" type="text" required v-model="form.customer_email" placeholder="Customer email" />
                        <InputError :message="form.errors.customer_email" />
                    </div>
                </div>

                <table class="w-full table-auto border-collapse rounded border border-gray-300 border-white">
                    <thead>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="w-50">Action</th>
                    </thead>
                    <tbody v-if="filteredProducts.length > 0">
                        <tr v-for="(product, index) in filteredProducts" :key="index" class="border-t">
                            <td class="p-1">{{ product.name }}</td>
                            <td class="text-center">{{ product.price }}</td>
                            <td class="text-center">{{ product.pivot.quantity }}</td>
                            <td class="flex justify-end">
                                <Input
                                    :id="'product' + product.id"
                                    type="number"
                                    :max="product.stock_quantity"
                                    :defaultValue="product.pivot.quantity"
                                    class="mr-2 w-25"
                                    @change="(e) => (form.products[product.id].quantity = e.target.value)"
                                />
                                <Button class="cursor-pointer" @click="removeProduct(product.id)">remove</Button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr class="border-t">
                            <td colspan="4">Empty!</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="bold pr-2 text-end">Sum:</td>
                            <td class="bold">{{ props.order.total_amount }}</td>
                        </tr>
                    </tfoot>
                </table>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Edit order
                </Button>
            </div>
        </form>
    </div>
</template>
