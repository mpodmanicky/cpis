<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 18rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Part Detail</h5>
                <label for="name">Part's name</label>
                <input type="text" :disabled="!editing" class="form-control" name="name" v-model="partName" />
                <label for="serialnumber">Serial number</label>
                <input type="number" :disabled="!editing" class="form-control" name="serialnumber"
                    v-model="serialNumber" />
                <div class="btn-group top-2">
                    <button class="btn btn-primary" @click="savePart(part.id)">Save</button>
                    <button class="btn btn-primary"
                        @click="() => { if (!editing) { editing = true } else { editing = false } }">Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import axios from 'axios';
export default {
    props: {
        part: Object
    },
    data() {
        return {
            editing: false,
            car: [],
            cars: [],
            partName: this.part.name,
            serialNumber: this.part.serialnumber,
        }
    },
    created() {

    },
    methods: {
        savePart(id: number) {
            if (this.partName && this.serialNumber) {
                axios.patch('http://127.0.0.1:8000/detail/part/' + id, {
                    name: this.partName,
                    serialnumber: this.serialNumber
                })
                    .then(response => {
                        alert('Part updated successfully');
                        this.part.name = this.partName;
                        this.part.serialnumber = this.serialNumber;
                        this.editing = false;
                    })
                    .catch(err => {
                        console.error('Something went wrong...', err);
                        alert('Oops!!...12.3');
                    })
            }
        },
    }
}
</script>