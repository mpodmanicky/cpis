<template>
    <div class="container">
        <input type="text" id="carName" placeholder="BMW M4"/>
        <label for="carName">Car's name</label>
        <input type="number" id="registrationNumber" placeholder="8801239902"/>
        <label for="registrationNumber">Registration Number</label>
        <!--Selection of cars input-->
    </div>
</template>
<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';

const name = ref('');
const registration_number = ref(null);
const is_registered = ref(null);

function addCar() {
    axios.post('/api/cars')
}
</script>