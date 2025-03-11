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
        <div class="flex justify-between items-center">
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
    </nav>
</template>

<style scoped>
</style>