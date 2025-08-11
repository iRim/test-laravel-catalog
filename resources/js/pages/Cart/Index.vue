<script setup lang="ts">
import Header from '@/components/Header.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useCartStore } from '@/stores/cart';
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';

const filteredProducts = ref([]);
const cart = useCartStore();

const props = defineProps({
    products: Array,
});

filteredProducts.value = props.products?.filter((p) => cart.ids.includes(p.id));

const form = useForm({
    name: '',
    email: '',
    products: Object.fromEntries(
        filteredProducts.value.map((p) => [
            p.id,
            {
                id: p.id,
                quantity: 1,
            },
        ]),
    ),
});

const submit = () => {
    form.post(route('cart.buy'), {
        onSuccess: () => cart.clear(),
    });
};

watch(
    () => cart.ids,
    (val) => {
        filteredProducts.value = props.products?.filter((p) => val.includes(p.id));
    },
);
</script>

<template>
    <Head title="Products list" />
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <Header />
        <h1 class="dark:bg-[#161615] dark:text-[#EDEDEC]">Cart list</h1>
        <div class="flex w-full justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-4xl flex-col overflow-hidden dark:bg-[#161615] dark:text-[#EDEDEC]">
                <form @submit.prevent="submit">
                    <div class="mb-5 flex gap-2">
                        <div class="w-1/2">
                            <Label for="name" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Name</Label>
                            <Input id="name" type="text" required autofocus v-model="form.name" placeholder="Name" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="w-1/2">
                            <Label for="email" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Email</Label>
                            <Input id="email" type="text" required v-model="form.email" placeholder="Email" />
                            <InputError :message="form.errors.email" />
                        </div>
                    </div>

                    <table class="w-full table-auto border-collapse rounded border border-gray-300 border-white">
                        <thead>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="w-50">Action</th>
                        </thead>
                        <tbody v-if="filteredProducts?.length">
                            <tr v-for="(product, index) in filteredProducts" :key="index" class="border-t">
                                <td class="p-1">
                                    <b class="inline-block w-full">{{ product.name }}</b>
                                    <small>{{ product.description }}</small>
                                </td>
                                <td class="text-center">{{ product.price }}</td>
                                <td class="text-center">{{ product.stock_quantity }}</td>
                                <td class="flex justify-end">
                                    <Input
                                        :id="'product' + product.id"
                                        type="number"
                                        :max="product.stock_quantity"
                                        defaultValue="1"
                                        class="mr-2 w-25"
                                        @change="(e) => (form.products[product.id].quantity = e.target.value)"
                                    />
                                    <Button @click="cart.remove(product.id)" class="cursor-pointer">remove</Button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="border-t">
                                <td colspan="4">Empty!</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-5 flex justify-end">
                        <Button type="submit" class="cursor-pointer">Create order</Button>
                    </div>
                </form>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
