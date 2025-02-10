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
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in cars" :key="car.id">
                    <td>{{ car.id }}</td>
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number ? car.registration_number : 'Not Registered' }}</td>
                    <td>
                        <ul>
                            <li v-for="part in car.parts" :key="part.id">
                                {{ part.name }}
                            </li>
                        </ul>
                    </td>
                    <td><button class='btn btn-secondary'>Delete</button></td>
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
            cars: []
        };
    },
    created() {
        this.fetchCars();
    },
    methods: {
        fetchCars() {
            axios.get('/api/cars')
                .then(response => {
                    this.cars = response.data
                })
                .catch(err => {
                    console.error('Something went wrong while fetching....');
                });
        },
        deleteCar() {
            // logic for deletion
        }
    }
}
</script>