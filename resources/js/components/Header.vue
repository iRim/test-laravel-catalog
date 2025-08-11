<script setup>
import { useCartStore } from '@/stores/cart';
import { Link } from '@inertiajs/vue3';

const cart = useCartStore();
</script>

<template>
    <header class="mb-6 flex w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
        <nav class="flex w-1/2 items-center gap-4">
            <Link
                :href="route('products.index')"
                class="inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
            >
                Products
            </Link>

            <Link
                :href="route('orders.index')"
                class="inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
            >
                Orders
            </Link>

            <Link
                :href="route('cart.index')"
                class="relative inline-block cursor-pointer rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
            >
                Cart

                <span v-if="cart.count > 0" class="absolute -top-2 -right-2 rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">
                    {{ cart.count }}
                </span>
            </Link>
        </nav>
        <nav class="flex w-1/2 items-center justify-end gap-4">
            <slot />
        </nav>
    </header>
</template>
