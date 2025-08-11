<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    description: '',
    price: 0,
    stock_quantity: 0,
});

const submit = () => {
    form.post(route('products.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Add product" />
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    :href="route('products.index')"
                    class="inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Products list
                </Link>
            </nav>
        </header>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Name</Label>
                    <Input id="name" type="text" required autofocus v-model="form.name" placeholder="Name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="descriptioin" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Description</Label>
                    <Input id="description" type="text" required v-model="form.description" placeholder="Description" />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="flex gap-1">
                    <div class="w-1/2">
                        <Label for="price" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Price</Label>
                        <Input id="price" type="number" required v-model="form.price" min="0.01" placeholder="123.45" />
                        <InputError :message="form.errors.price" />
                    </div>
                    <div class="w-1/2">
                        <Label for="stock_quantity" class="text-[#1b1b18] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">Quantity</Label>
                        <Input id="stock_quantity" type="number" required v-model="form.stock_quantity" min="1" placeholder="123" />
                        <InputError :message="form.errors.stock_quantity" />
                    </div>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Add product
                </Button>
            </div>
        </form>
    </div>
</template>
