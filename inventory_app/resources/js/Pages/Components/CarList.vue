<template>
    <div class="container text-center d-flex justify-content-evenly align-items-center">
        <!--Form to add new car-->
        <input type="text" class="form-control" v-model="carName" placeholder="ex. BMW M5"/>
        <select class="form-select" v-model="registeredCar">
            <option disabled-value="">
                Is the car registered ?
            </option>
            <option>Yes</option>
            <option>No</option>
        </select>
        <input v-if="registeredCar === 'Yes'" type="number" v-model="registrationNumber" class="form-control" placeholder="ex.7721622"/>
        <button type="button" class="btn btn-success" @click="addCar">Add</button>
    </div>
    <div class="container text-center">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Registration Number</th>
                    <th>Parts</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in cars" :key="car.id">
                    <td>{{ car.id }}</td>
                    <td>{{ car.name }}</td>
                    <td>{{ car.is_registered ? car.registration_number : 'Not Registered' }}</td>
                    <td>
                        <ul>
                            <li v-for="part in parts.filter(p => p.car_id === car.id)" :key="part.id">
                                {{ part.name }}
                            </li>
                        </ul>
                    </td>
                    <td>
                    <div class="btn-group">
                        <button type="button" class='btn btn-danger' @click="deleteCar(car.id)">Delete</button>
                        <button type="button" class="btn btn-primary" @click="carDetail(car.id)">Edit</button>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            cars: [],
            parts: [],
            carName: '',
            registeredCar: '',
            registrationNumber: ''
        };
    },
    created() {
        this.fetchCars();
        this.fetchParts();
    },
    methods: {
        fetchCars() {
            axios.get('http://127.0.0.1:8000/api/cars')
                .then(response => {
                    if (response.data) {
                        this.cars = response.data.data
                    }
                })
                .catch(err => {
                    console.error('Something went wrong while fetching....');
                });
        },
        fetchParts() {
            axios.get('http://127.0.0.1:8000/api/assignedParts')
                .then(response => {
                    if (response.data) {
                        this.parts = response.data.data
                    }
                })
                .catch(err => {
                    console.error('Something wen t wrong while fetching....');
                });
        },
        deleteCar(id: number) {
            axios.delete('http://127.0.0.1:8000/api/cars/' + id)
                .then(response => {
                this.fetchCars()
                }) 
                .catch(err => {
                    console.error('Something went wrong when deleting...');
            })
        },
        carDetail(id: number) {
            axios.get('http://127.0.0.1:8000/detail/car/' + id)
            .then(response => {
                    if (response.status === 200) {
                        window.location.href = `/detail/car/${id}`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching car details:', error);
                });
        },
        addCar() {
            if (this.carName !== '' && this.registeredCar !== '') {
                var temp = false;
                if (this.registeredCar === 'Yes') {
                    temp = true;
                } 
                if (temp) {
                    axios.post('http://127.0.0.1:8000/api/cars', {
                        name: this.carName,
                        registered: true,
                        registration_number: this.registrationNumber
                    })
                        .then(response => {
                            alert('Car has been succcessfully added!');
                            this.fetchCars()
                            this.fetchParts()
                        })
                        .catch(err => {
                            console.error('Error when inserting...', err);
                    })
                } else {
                    axios.post('http://127.0.0.1:8000/api/cars', {
                        name: this.carName,
                        registered: false, 
                    })
                        .then(response => {
                            //err handling cez if response.status == 200 atd atd
                            alert('Car has been succcessfully added!');
                            this.fetchCars()
                            this.fetchParts()
                        })
                        .catch(err => {
                            console.error('Error when inserting...', err);
                    })
                }
            }
        }
    }
}
</script>