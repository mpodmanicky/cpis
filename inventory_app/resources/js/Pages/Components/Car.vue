<template>
    <div class="container text-center">
        <!--Car detail + functionality to add new parts to the car/remove them-->
        <div class="card">
            <div v-if="car">
                <div class="card-body">
                    <h5 class="card-title">{{ car.name }}</h5>
                    <h6 class="card-subtitle mb2 text-body-secondary">{{ car.registration_number }}</h6>
                    <p class="card-text">{{ car.is_registered ? 'Registered' : 'Not Registered' }}</p>
                    <div v-if="!car.is_registered">
                        <h6 class="card-subtitle text-body-secondary">Register</h6>
                        <input type="number" placeholder="ex.9912839" v-model="registrationNumber" />
                        <button class="btn btn-secondary" @click="registerCar(car.id)">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import axios from 'axios';
export default {
    
    props: {
        car: Object,
    },
    data() {
        return {
            parts: [],
            registrationNumber: this.car.registration_number
        }
    },
    methods: {
        //fetchParts
        //addPartToCar
        //removeParts
        //registerCar
        registerCar(id: number) {
            if (!this.registrationNumber) {
                alert('Please provide registration number');
                return;
            }
            axios.patch('http://127.0.0.1:8000/detail/car/' + id, {
                registration_number: this.registrationNumber,
                is_registered: true
            })
                .then(response => {
                    alert('Car registered successfully');
                    this.car.registration_number = this.registrationNumber;
                    this.car.is_registered = true;
                })
                .catch(error => {
                    console.error('Error while registering');
                    alert('There was an error while registering the car...');
            })
        }
    }
}
</script>