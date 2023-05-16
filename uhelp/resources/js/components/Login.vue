<template>
    <div class="container">
        <div class="back-url">
            <div class="text" onclick="window.location.replace('/')">Повернутись</div>
            <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
        </div>

        <form class="login-form" method="POST" @submit.prevent="login" @keydown="errors.clear($event.target.name)">
            <div class="title">Логін</div>
            <div class="fields">
                <label for="email" class="input-label">Емейл</label>
                <input
                    v-model="email"
                    type="email"
                    name="email"
                    class="input-field"
                >
                <span class="help is-danger" v-text="errors.get('email')"></span>

                <label for="password" class="input-label">Пароль</label>
                <input
                    v-model="password"
                    type="password"
                    name="password"
                    class="input-field"
                >
                <span class="help is-danger" v-text="errors.get('password')"></span>

                <button type="submit" class="main-button">Увійти</button>
                <span class="help is-danger" v-text="errors.get('button')"></span>
                <div class="small-text">
                    Не маєте акаунта?
                    <a href="/register" class="">Зареєструватись</a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import {Errors} from "../Errors";

export default {
    name: "Login",

    data() {
        return {
            email: '',
            password: '',
            errors: new Errors()
        }
    },

    methods: {
        login(event) {
            axios.post('/login', {
                'email': this.email,
                'password': this.password
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    if (!e.data.length) {
                        window.location.href = "/fundraising"
                    }
                });
        }
    }
}
</script>
