<template>
    <UserLayout :user="user" :active="'map'">
        <div class="center-position">
            <div class="page-title-text">Додати пункт на мапу</div>
                <form method="POST" class="create-fundr" @keydown="errors.clear($event.target.name)">
                    <div class="flex start">
                        <div class="create-fundr">
                            <label class="label-text" for="name">Назва центру</label>
                            <InputText id="name" v-model="name"/>
                            <span class="help is-danger" v-text="errors.get('name')"></span>
                        </div>

                        <div class="create-fundr">
                            <label class="label-text" for="address">Адреса</label>
                            <InputText v-model="address"/>
                            <span class="help is-danger" v-text="errors.get('address')"></span>
                        </div>

                        <div class="create-fundr">
                            <label class="label-text" for="city">Місто</label>
                            <InputText v-model="city"/>
                            <span class="help is-danger" v-text="errors.get('city')"></span>
                        </div>

                        <div class="create-fundr">
                            <label class="label-text" for="latitude">Широта</label>
                            <InputNumber inputId="minmaxfraction" :minFractionDigits="2" :maxFractionDigits="10" v-model="latitude"/>
                            <span class="help is-danger" v-text="errors.get('latitude')"></span>
                        </div>

                        <div class="create-fundr">
                            <label class="label-text" for="longitude">Довгота</label>
                            <InputNumber inputId="minmaxfraction" :minFractionDigits="2" :maxFractionDigits="10" v-model="longitude"/>
                            <span class="help is-danger" v-text="errors.get('longitude')"></span>
                        </div>
                    </div>
                    <div class="buttons padding-top-button start">
                        <Button severity="secondary" @click="create">Зберегти</Button>
                        <Button severity="secondary" @click="back">Повернутись</Button>
                    </div>
                </form>
            </div>
    </UserLayout>
</template>

<script>
import UserLayout from "./UserLayout.vue";
import {Errors} from "../Errors";
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';

export default {
    name: "MapAdd",

    components: {
        UserLayout,
        InputText,
        InputNumber,
        Button,
    },

    props: {
        user: [Object, null],
        map: Array,
    },

    data() {
        return {
            errors: new Errors(),
            name: '',
            address: '',
            city: '',
            latitude: '',
            longitude: ''
        }
    },

    methods: {
        create() {
            axios.post('/create-map', {
                'name': this.name,
                'address': this.address,
                'city': this.city,
                'latitude': this.latitude,
                'longitude': this.longitude,
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    if (!e.data.length) {
                        window.location.href = "/map"
                    }
                });
        },

        back() {
            window.location.href = "/map";
        }
    }
}
</script>
