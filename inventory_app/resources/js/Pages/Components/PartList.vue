<template>
    <div class="container text-center">
        <!--Form to add new part-->
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
                    <td>{{ part.car ? $part.car.name : 'Not assigned' }}</td>
                    <td>
                        <div>
                        <button class='btn btn-secondary' @click="deletePart(part.id)">Delete</button>
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
            parts: []
        };
    },
    created() {
        this.fetchParts();
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
        partDetail(id: number) {
            axios.get('http://127.0.0.1:8000/detail/part/' + id)
        },
        deletePart(id: number) {
            
        }
    }
}
</script>