<script setup lang="ts">
import CarList from '@/Components/CarList.vue';
import PartList from '@/Components/PartList.vue';
import { ref } from 'vue';

const showCars = ref(true);

const toggleView = (view: 'cars' | 'parts') => {
    showCars.value = view === 'cars';
}

</script>
<template>
    <div class="container text-center">
        <h1>Inventory</h1>
    </div>

    <div class="container text-center">
        <div class="btn-group">
            <button class="btn btn-primary" :class="{ active: showCars }" @click="toggleView('cars')">Cars</button>
            <button class="btn btn-primary" :class="{ active: !showCars }" @click="toggleView('parts')">Parts</button>
        </div>
    </div>
    <!--v-if statement pre carList a partList-->
    <div class="container mt-4">
        <CarList v-if="showCars" />
        <PartList v-else />
    </div>

</template>