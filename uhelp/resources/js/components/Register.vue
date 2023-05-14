<template>
    <div class="container">
        <div class="back-url">
            <div class="text" onclick="window.location.replace('/')">Go back</div>
            <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
        </div>

        <form class="form-register" method="POST" @submit.prevent="register" @change="errors.clear($event.target.name)">
            <div class="title">Register</div>
            <div class="field-group">
                <div class="small-fields">
                    <label for="name" class="input-label">Name</label>
                    <input v-model="name" type="text" name="name" id="name" class="small-input-field">
                    <span class="help is-danger" v-text="errors.get('name')"></span>

                    <label for="email" class="input-label">Email</label>
                    <input v-model="email" type="email" name="email" id="email" class="small-input-field">
                    <span class="help is-danger" v-text="errors.get('email')"></span>

                    <label for="password" class="input-label">Password</label>
                    <input v-model="password" type="password" name="password" id="password" class="small-input-field">
                    <span class="help is-danger" v-text="errors.get('password')"></span>
                </div>
                <div class="small-fields">
                    <label for="account" class="input-label">Account type</label>
                    <select name="account" @change="setType($event)" id="account" class="small-input-field">
                        <option
                            v-for="(type, index) in types"
                            :key="index"
                            :value="index"
                        >{{ type }}</option>
                    </select>
                    <span class="help is-danger" v-text="errors.get('account')"></span>

                    <label for="phone" class="input-label">Phone number</label>
                    <input v-model="phone" type="text" name="phone" id="phone" class="small-input-field">
                    <span class="help is-danger" v-text="errors.get('phone')"></span>

                    <label for="password" class="input-label">Confirm password</label>
                    <input v-model="rePassword" type="password" name="password_confirmation" id="password2" class="small-input-field">
                    <span class="help is-danger" v-text="errors.get('password_confirmation')"></span>
                </div>
            </div>

            <label for="document" class="input-label">Attach official document</label>
            <input @change="setDocument($event)" type="file" accept="image/png" name="document" id="document">
            <span class="help is-danger" v-text="errors.get('document')"></span>
            <InlineMessage v-if="message.length" severity="success">{{ message }}</InlineMessage>

            <button type="submit" class="main-button button-reg">Register</button>
            <div class="small-text">
                Already have an account?
                <a href="/login" class="">Log in</a>
            </div>
        </form>
    </div>
</template>

<script>
import {Errors} from '../Errors';
import InlineMessage from 'primevue/inlinemessage';
export default {
    name: "Register",

    components: {
        InlineMessage
    },

    data() {
        return {
            name: '',
            email: '',
            password: '',
            rePassword: '',
            phone: '',
            accountType: 2,
            document: File,
            errors: new Errors(),
            message: '',
        }
    },

    props: {
        types: {
            type: Array,
            default: []
        }
    },

    methods: {
        setType(event) {
            this.accountType = event.target.value;
        },

        setDocument(event) {
            // this.document = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.document = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);

        },

        register(event) {
            axios.post('/register', {
                'name': this.name,
                'email': this.email,
                'password': this.password,
                'password_confirmation': this.rePassword,
                'phone': this.phone,
                'accountId': this.accountType,
                'document': this.document
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    this.message = e.data.message;
                });
        }
    }
}
</script>
