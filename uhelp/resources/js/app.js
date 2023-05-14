/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { createApp } from 'vue';
import Landing from './components/Landing.vue';
import Slider from './components/Slider.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Archive from './components/Archive.vue';
import Fundraising from "./components/fundraising/Fundraising.vue";
import FundraisingDetails from "./components/fundraising/FundraisingDetails.vue";
import AnnouncementDetails from "./components/announcements/AnnouncementDetails.vue";
import MyFundraising from "./components/fundraising/MyFundraising.vue";
import CreateEditFundraising from "./components/fundraising/CreateEditFundraising.vue";
import Announcements from "./components/announcements/Announcements.vue";
import MyAnnouncements from "./components/announcements/MyAnnouncements.vue";
import CreateEditAnnouncement from "./components/announcements/CreateEditAnnouncement.vue";
import CloseAnnouncement from "./components/announcements/CloseAnnouncement.vue";
import CloseFundraising from "./components/fundraising/CloseFundraising.vue";
import UserLayout from "./components/UserLayout.vue";
import Members from "./components/Members.vue";
import Member from "./components/Member.vue";
import MapItems from "./components/MapItems.vue";
import MapAdd from "./components/MapAdd.vue";
import PrimeVue from 'primevue/config';
import 'primevue/resources/primevue.min.css';
import 'primevue/resources/themes/lara-light-blue/theme.css';
require('./bootstrap');

window.onload = function () {
    let app=createApp({
        components: {
            Landing,
            Slider,
            Login,
            Register,
            Archive,
            Fundraising,
            FundraisingDetails,
            MyFundraising,
            UserLayout,
            CreateEditFundraising,
            Announcements,
            MyAnnouncements,
            CreateEditAnnouncement,
            CloseAnnouncement,
            CloseFundraising,
            AnnouncementDetails,
            Members,
            Member,
            MapItems,
            MapAdd,
        }
    })
    app.use(PrimeVue);
    app.mount("#app")
}
