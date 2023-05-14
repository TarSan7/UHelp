<template>
    <UserLayout :user="user" :active="'map'">
        <div class="center-position">
            <div class="page-title-text">Blood donations centers map</div>
            <div class="fundraising padding-top-button">
                <GoogleMap api-key="AIzaSyBJ_0NDX02aikKLJ12ckgm0pHY7ZwzTzSc" style="width: 100%; height: 700px" :center="{lat:50.383022, lng:31.1828699}" :zoom="7">

                    <Marker
                        v-for="( item, key) in map"
                        :key="key"
                        :options="getPosition(item)"
                        :clickable="true"
                        :draggable="false"
                        @click="handle(item)"
                    >
                        <InfoWindow>
                            <div class="info-window">
                                <h3>{{ item.name }}</h3>
                                <h5>Address: {{ item.address }}</h5>
                                <h5>City: {{ item.city }}</h5>
                            </div>
                        </InfoWindow>
                    </Marker>
                </GoogleMap>
                <Button v-if="user['account_type_id'] === 2" severity="secondary" @click="toogle">Add</Button>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "./UserLayout.vue";
import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
import Button from 'primevue/button';

export default {
    name: "MapItems",

    components: {
        UserLayout,
        GoogleMap,
        Marker,
        InfoWindow,
        Button,
    },

    props: {
        user: [Object, null],
        map: Array,
    },

    methods: {
        getPosition(item) {
            return {
                position: {
                    lat:parseFloat(item.latitude),
                    lng:parseFloat(item.longitude)
                }
            };
        },

        handle(item) {
            console.log('ss')
            this.activeItem = item;
            this.infoWindowOpened = true;
        },

        toogle() {
            window.location.href = '/add-map';
        },
    }
}
</script>
