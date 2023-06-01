<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="start">
            <div class="page-title-text">Деталі збору</div>
            <div class="flex">
                <div class="width-slider fundr-info">
                    <Carousel :value="images" :numVisible="1" :numScroll="1">
                        <template #item="slotProps">
                            <img :src="slotProps.data.url" style="width: 500px">
                        </template>
                    </Carousel>
                </div>
                <div class="fundr-info">
                    <div class="label-text padding-small">{{ fundraising[0]['title'] }}</div>
                    <div class="slot-text padding-small">{{ fundraising[0]['info'] }}</div>
                    <div class="italic-text padding-small">Дата початку: {{ fundraising[0]['start_date'] }}</div>
                    <div class="slot-goal-text padding-small">Сума збору: {{ fundraising[0]['sum'] }} UAH</div>
                    <div class="slot-goal-text padding-small">Залишилося зібрати: {{ fundraising[0]['remaining_amount'] }} UAH</div>
                    <div class="slot-text padding-small">
                        Статус збору:
                        <ProgressBar :value="(fundraising[0]['sum'] - fundraising[0]['remaining_amount']) / fundraising[0]['sum'] * 100"></ProgressBar>
                    </div>
                    <div>
                        <div class="label-text padding-small">Волонтер, відповідальний за збір:</div>
                        <div class="italic-text padding-small">Ім'я: {{ volunteer['name'] }}</div>
                        <div class="italic-text padding-small">Номер телефону: {{ volunteer['phone'] }}</div>
                    </div>
                </div>
            </div>
            <div class="flex-center">
                <div v-if="fundraising[0]['is_active']">
                    <div class="label-text padding-small">Ви можете доєднатись та задонатити тут:</div>

                    <form class="paymentForm">
                        <div class="create-fundr">
                            <label class="label-text-small" for="username">Повне ім'я (на карті)</label>
                            <InputText v-model="name" class="form-control width-card" name="fullName" placeholder="Повне ім'я" />
                            <span class="help is-danger" v-text="errors.get('name')"></span>
                        </div>
                        <div class="create-fundr">
                            <label class="label-text-small" for="cardNumber">Номер карти</label>
                            <div class="input-group">
                                <InputText v-model="number" class="form-control width-card" name="cardNumber" placeholder="Номер карти" />
                                <span class="help is-danger" v-text="errors.get('number')"></span>
                                <div class="input-group-append">
                                    <span class="input-group-text text-muted">
                                        <i class="fab fa-cc-visa fa-lg pr-1"></i>
                                        <i class="fab fa-cc-amex fa-lg pr-1"></i>
                                        <i class="fab fa-cc-mastercard fa-lg"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="create-fundr">
                                <label class="label-text-small">Термін дії</label>
                                <div class="flex">
                                    <select v-model="month" class="select">
                                        <option v-for="one in months">
                                            {{ one }}
                                        </option>
                                    </select>
                                    <select v-model="year" class="select">
                                        <option v-for="one in years">
                                            {{ one }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="create-fundr">
                                <label class="label-text-small" data-toggle="tooltip" title=""
                                       data-original-title="3 digits code on back side of the card">CVV <i
                                    class="fa fa-question-circle"></i></label>
                                <InputText v-model="cvv" type="number" class="form-control" placeholder="CVV" name="cvv" />
                                <span class="help is-danger" v-text="errors.get('cvv')"></span>
                            </div>
                        </div>
                        <div class="create-fundr">
                            <label class="label-text-small" for="summ">Сума переказу</label>
                            <InputNumber v-model="sum" inputId="currency-us" mode="currency" currency="UAH" />
                            <span class="help is-danger" v-text="errors.get('sum')"></span>
                            <InlineMessage v-if="message.length" severity="success">{{ message }}</InlineMessage>
                        </div>
                        <Button severity="primary" class="margin-top-button" @click="sendForm">Донат!</Button>
                    </form>
                </div>
                <div v-else class="padding-small donate fundr-info">
                    <div class="italic-text red padding-small">Цей збір був закритий</div>
                    <div class="label-text padding-small">Причина: {{ fundraising[0]['cause'] }}</div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "../UserLayout.vue";
import Carousel from "primevue/carousel";
import ProgressBar from "primevue/progressbar";
import InputText from 'primevue/inputtext';
import InputNumber from "primevue/inputnumber";
import InlineMessage from "primevue/inlinemessage";
import Button from "primevue/button";
import {Errors} from "../../Errors";

export default {
    name: "FundraisingDetails",

    components: {
        UserLayout,
        Carousel,
        ProgressBar,
        InputText,
        Button,
        InputNumber,
        InlineMessage,
    },

    props: {
        user: [Object, null],
        fundraising: Array,
        images: Array,
        volunteer: Object
    },

    data() {
        return {
            name: '',
            number: '',
            month: 1,
            year: 2023,
            cvv: '',
            sum: 0,
            months: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            years: [2023, 2024, 2025, 2026, 2027, 2028, 2028, 2029, 2030],
            errors: new Errors(),
            message: '',
        }
    },

    methods: {
        sendForm(event) {
            axios.post('/payment', {
                'fullName': this.name,
                'cardNumber': this.number,
                'month': this.month,
                'year': this.year,
                'cvv': this.cvv,
                'sum': this.sum,
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    console.log(e.data)
                    this.message = e.data.message;
                });
        }
    }
}
</script>
