<template>
    <div class="container">
        <h1>Contacts</h1>

        <table v-if="contacts.length" class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="order" @click="orderByClick('age')">age</th>
                    <th class="order" @click="orderByClick('eyeColor')">eyeColor</th>
                    <th class="order" @click="orderByClick('name')">name</th>
                    <th class="order" @click="orderByClick('gender')">gender</th>
                    <th class="order" @click="orderByClick('company')">company</th>
                    <th class="order" @click="orderByClick('email')">email</th>
                    <th class="order" @click="orderByClick('phone')">phone</th>
                    <th class="order" @click="orderByClick('address')">address</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="item in contacts">
                <td>{{ item.age }}</td>
                <td>{{ item.eyeColor }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.gender }}</td>
                <td>{{ item.company }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.address }}</td>
            </tr>
            </tbody>
        </table>
        <button v-if="hasPage" @click="readMore()" class="btn btn-primary mt-5">Read more</button>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                contacts: [],
                sortBy: null,
                orderBy: true,
                page: 1,
                hasPage: true
            }
        },
        methods: {
            fetchContacts(){
                axios.get('/api?sortBy='+this.sortBy+'&orderBy='+this.orderBy+'&page='+this.page).then(response => {
                    response.data.length != 0 ? response.data.forEach(el => this.contacts.push(el))  : this.hasPage = false
                })
            },
            readMore(){
                this.page++;
                this.$nextTick(() => this.fetchContacts());
            },
            orderByClick(val) {
                this.contacts = [];
                this.page = 1;
                this.hasPage = true;
                this.sortBy = val;
                this.orderBy == 'asc'
                    ? this.orderBy = 'desc'
                    : this.orderBy = 'asc';

                this.$nextTick(() => this.fetchContacts());
            },
        },
        mounted() {
            this.fetchContacts();
        }
    }
</script>
<style>
    .order{
        cursor: pointer;
    }
</style>
