<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <!--Car detail + functionality to add new parts to the car/remove them-->
        <div class="card" style="width: 18rem;">
            <div v-if="car">
                <div class="card-body">
                    <h5 class="card-title">Car's detail</h5>
                    <label for="name">Cars' name</label>
                    <input type="text" :disabled="!editing" class="form-control" name="name" v-model="carName" />
                    <label for="registrationNumber">Registration number</label>
                    <input type="number" :disabled="!editing" class="form-control" v-model="registrationNumber"
                        name="registrationNumber" />
                    <p class="card-text">{{ car.is_registered ? 'Registered' : 'Not Registered' }}</p>
                    <div class="btn-group">
                        <button class="btn btn-primary"
                            @click="() => { if (!editing) { editing = true } else { editing = false } }">Edit</button>
                        <button class="btn btn-primary" @click="registerCar(car.id)">Save</button>
                    </div>
                    <h6>Assigned Parts</h6>
                    <div class=card>
                        <p v-for="part in carParts" class="card-text d-flex justify-content-between" :key="part.id">
                            {{ part.name }}
                            <button class="btn btn-danger" @click="removePart(part.id)">Remove</button>
                        </p>
                    </div>
                </div>
            </div>
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
            carName: this.car.name,
            registrationNumber: this.car.registration_number,
            selectedPart: '',
            editing: false,
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
                axios.patch('http://127.0.0.1:8000/detail/car/' + id, {
                    registration_number: this.registrationNumber,
                    name: this.carName,
                    is_registered: false
                })
                    .then(response => {
                        alert('Car registered successfully');
                        this.car.registration_number = this.registrationNumber;
                        this.car.is_registered = false;
                        this.car.name = this.carName;
                    })
                    .catch(error => {
                        console.error('Error while registering');
                        alert('There was an error while registering the car...');
                    })
            }
            else {
                axios.patch('http://127.0.0.1:8000/detail/car/' + id, {
                    registration_number: this.registrationNumber,
                    name: this.carName,
                    is_registered: true
                })
                    .then(response => {
                        alert('Car registered successfully');
                        this.car.registration_number = this.registrationNumber;
                        this.car.is_registered = true;
                        this.car.name = this.carName;
                    })
                    .catch(error => {
                        console.error('Error while registering');
                        alert('There was an error while registering the car...');
                    })
            }
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