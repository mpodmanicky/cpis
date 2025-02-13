<template>
    <div class="container text-center d-flex justify-content-around align-items-center">
        <!--Form to add new part-->
        <input type="text" class="form-control" v-model="partName" placeholder="ex.Clutch Piston"/>
        <input type="number" class="form-control" v-model="serialNumber" placeholder="ex.998929292"/>
        <button type="button" class="btn btn-success" @click="addPart">Add</button>
    </div>
    <div class="container text-center">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Serial Number</th>
                    <th>Car</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="part in parts" :key="part.id">
                    <td>{{ part.id }}</td>
                    <td>{{ part.name }}</td>
                    <td>{{ part.serialnumber }}</td>
                    <td>{{ part.car_id ? getCarName(part.car_id) : null }}</td>
                    <td>
                        <div class="btn-group">
                        <button class='btn btn-danger' @click="deletePart(part.id)">Delete</button>
                        <button class="btn btn-primary" @click="partDetail(part.id)">Edit</button>
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
            parts: [],
            cars: [],
            partName: '',
            serialNumber: ''
        };
    },
    created() {
        this.fetchParts();
        this.fetchCars();
    },
    methods: {
        fetchParts() {
            axios.get('http://127.0.0.1:8000/api/parts')
                .then(response => {
                    if (response.data) {
                        this.parts = response.data.data
                    }
                })
                .catch(err => {
                    console.error('Something wen t wrong while fetching....');
                });
        },
        fetchCars() {
            axios.get('http://127.0.0.1:8000/api/cars')
                .then(response => {
                    if (response.data) {
                        this.cars = response.data.data
                    }
                })
                .catch(err => {
                    console.error('error while fetching...' + err)
                });
        },
        getCarName(car_id: number) {
            const car = this.cars.find(c => c.id === car_id);
            return car ? car.name : 'Not assigned';
        },
        partDetail(id: number) {
            axios.get('http://127.0.0.1:8000/detail/part/' + id)
                .then(response => {
                    if (response.status === 200) {
                    window.location.href = `/detail/part/${id}`
                    }
                })
                .catch(err => {
                    console.error('Error while retrieving details...', err);
            })
        },
        deletePart(id: number) {
            axios.delete('http://127.0.0.1:8000/api/parts/' + id)
                .then(response => {
                    this.fetchParts()
                })
                .catch(err => {
                    console.error('Something went wrong when deleting', err);
                });
        },
        addPart() {
            console.log('button clicked.')
            if (this.partName !== '' && this.serialNumber !== '') {
                axios.post('http://127.0.0.1:8000/api/parts', {
                    name: this.partName,
                    serialnumber: this.serialNumber
                })
                    .then(response => {
                        alert('Part added succecssfully.')
                        this.fetchCars()
                        this.fetchParts()
                    })
                    .catch(err => {
                        alert('Oops...');
                        console.error('Something went wrong...' + err);
                    })
            } else {
                alert('Please provide required information about the part.')
            }
        }
    }
}
</script>