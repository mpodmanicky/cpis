<template>
    <div class="container text-center">
        <!--Form to add new car-->
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
                        <button type="button" class='btn btn-secondary' @click="deleteCar(car.id)">Delete</button>
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
            parts: []
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
        }
    }
}
</script>