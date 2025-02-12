<template>
    <div class="container">
        <input type="text" id="partName" placeholder="Clutch"/>
        <label for="partName">Part's name</label>
        <input type="number" id="partSerial" placeholder="8801239902"/>
        <label for="partSerial">Part's serial number</label>
        <!--Selection of cars input-->
    </div>
</template>
<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';

const name = ref('');
const serial_number = ref(null);
const car = ref(null);

function addPart() {
    axios.post('/api/parts')
}
</script>