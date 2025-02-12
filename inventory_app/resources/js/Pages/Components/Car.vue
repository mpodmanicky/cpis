<template>
    <div class="container text-center mx-auto">
        <!--Car detail + functionality to add new parts to the car/remove them-->
        <div class="card">
            <div v-if="car">
                <div class="card-body">
                    <h5 class="card-title">{{ car.name }}</h5>
                    <h6 class="card-subtitle mb2 text-body-secondary">{{ car.registration_number }}</h6>
                    <p class="card-text">{{ car.is_registered ? 'Registered' : 'Not Registered' }}</p>
                    <h6 class="card-subtitle mb2 text-body-primary">Assigned Parts</h6>
                    <p v-for="part in carParts" class="card-text" :key="part.id">
                        {{ part.name }}
                        <button class="btn btn-danger" @click="removePart(part.id)">Remove</button>
                    </p>
                    <div v-if="!car.is_registered">
                        <h6 class="card-subtitle text-body-secondary">Register</h6>
                        <input type="number" placeholder="ex.9912839" v-model="registrationNumber" />
                        <button class="btn btn-success" @click="registerCar(car.id)">Register</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container text-center mx-auto" >
            <select class="form-select" v-model="selectedPart">
                <option disabled value="">Select a part to assign</option>
                <option v-for="part in parts" :key="part.id" :value="part.id">
                    {{ part.name }}
                </option>
            </select>
            <button class="btn btn-primary" @click="assignPart">Add part</button>
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
            carParts: [],
            registrationNumber: this.car.registration_number,
            selectedPart: ''
        }
    },
    created() {
        this.fetchParts();
        this.assignedParts(this.car.id);
    },
    methods: {
        fetchParts() {
            axios.get('http://127.0.0.1:8000/api/unassignedParts')
                .then(response => {
                    if (response.data) {
                        this.parts = response.data.data
                    }
                })
                .catch(err => {
                    console.error('Something wen t wrong while fetching....');
                });
        },
        assignPart() { 
            if (this.selectedPart) {
                axios.patch('http://127.0.0.1:8000/detail/assignPart', {
                    part: this.selectedPart,
                    car: this.car.id,
                })
                    .then(response => {
                        alert('Part added successfully...')
                        this.assignedParts(this.car.id);
                        this.fetchParts();
                    })
                    .catch(err => {
                        alert('Error while adding part...')
                        console.error('Error while adding part', err)
                    });
            } else {
                alert('Please select a part to add');
                return;
            }
        },
        removePart(id: number) { 
            axios.patch('http://127.0.0.1:8000/detail/removePart/' + id)
                .then(response => {
                    alert('Part has been removed successfully');
                    this.assignedParts(this.car.id);
                    this.fetchParts();
                })
                .catch(err => {
                    console.error('Error while removing parts', err);
                });
        },
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
        },
        assignedParts(id: number) {
            axios.get('http://127.0.0.1:8000/detail/assignedParts/' + id)
                .then(response => {
                    if (response.data) {
                        this.carParts = response.data.data
                    }
                })
                .catch(err => {
                    console.error('Something wen t wrong while fetching....');
                });
        },
    }
}
</script>