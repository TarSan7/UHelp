<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">Закрити збір</div>

            <form method="POST" class="create-fundr" @keydown="errors.clear($event.target.name)">
                <div class="flex start">
                    <div class="create-fundr">
                        <label class="label-text" for="cause">Причина закриття</label>
                        <InputText id="cause" v-model="cause"/>
                        <span class="help is-danger" v-text="errors.get('cause')"></span>
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
import UserLayout from "../UserLayout.vue";
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import {Errors} from "../../Errors";

export default {
    name: "CloseFundraising",

    components: {
        UserLayout,
        Button,
        InputText,
    },

    props: {
        user: [Object, null],
        id: null,
    },

    data () {
        return {
            cause: '',
            errors: new Errors()
        }
    },

    methods: {
        back() {
            window.location.href = '/my-fundraising';
        },

        create() {
            axios.post('/close-fundraising', {
                'id': this.id ? this.id : null,
                'cause': this.cause,
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    if (!e.data.length) {
                        window.location.href = "/my-fundraising"
                    }
                });
        },
    }
}
</script>
