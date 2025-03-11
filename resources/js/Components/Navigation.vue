<script setup>
import {Link} from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const isActiveRoute = (routeVal) => {
    return route().current(routeVal);
}

const navItems = ref([
    {
        route: route('auth.destroy'),
        isActive: isActiveRoute('auth.destroy'),
        name: 'Logout',
        method: 'post',
    }
]);
</script>
<template>
    <nav class="bg-black px-5">
        <div class="justify-between items-center hidden md:flex">
            <Link :href="'/'" class="text-white py-6">Movie Watchlist</Link>
            
            <div class="flex gap-2 justify-center items-start" v-if="page.props.auth.user">
                <Link 
                v-for="(item, index) in navItems" :key="index"
                :href="item.route" 
                :method="item.method"
                :class="[
                    'text-white h-16 border-t-4 border-black hover:border-white',
                    {
                        '!border-white': item.isActive,
                    }
                ]">
                    {{ item.name }}
                </Link>
            </div>
           
        </div>

        <div class="md:hidden">
            <div class="flex justify-between items-center">
                <Link :href="'/'" class="text-white py-6">Movie Watchlist</Link>

                <button class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            
            
            <ul class="" v-if="page.props.auth.user">
                <li v-for="(item, index) in navItems" :key="index">
                    <Link 
                    :href="item.route" 
                    :class="[
                        'text-white h-16 pt-5 border-t-4 border-black hover:border-white',
                        {
                            '!border-white': item.isActive,
                        }
                    ]">
                        {{ item.name }}
                    </Link>
                </li>
            </ul>
        </div>


                
    </nav>
</template>

<style scoped>
</style>