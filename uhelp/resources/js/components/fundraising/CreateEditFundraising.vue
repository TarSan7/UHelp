<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div v-if="id" class="page-title-text">Редагувати збір</div>
            <div v-else class="page-title-text">Створити збір</div>

            <form method="POST" class="create-fundr" @keydown="errors.clear($event.target.name)">
                <div class="flex start">
                    <div class="create-fundr">
                        <label class="label-text" for="title">Назва</label>
                        <InputText id="title" v-model="title"/>
                        <span class="help is-danger" v-text="errors.get('title')"></span>
                    </div>

                    <div class="create-fundr">
                        <label class="label-text" for="summ">Необхідна сума</label>
                        <InputNumber v-model="sum" inputId="currency-us" mode="currency" currency="UAH" />
                        <span class="help is-danger" v-text="errors.get('sum')"></span>
                    </div>

                    <div class="create-fundr">
                        <label class="label-text" for="startDate">Дата старту</label>
                        <Calendar v-model="startDate" dateFormat="yy-mm-dd" showIcon/>
                        <span class="help is-danger" v-text="errors.get('startDate')"></span>
                    </div>

                    <div class="create-fundr">
                        <label class="label-text" for="links">Посилання на донат</label>
                        <InputText id="links" v-model="link" placeholder="https://..." />
                        <span class="help is-danger" v-text="errors.get('link')"></span>
                    </div>
                </div>
                <hr>
                <div class="flex start">
                    <div class="create-fundr">
                        <label class="label-text" for="info">Інформація</label>
                        <Textarea v-model="info" rows="15" cols="50" />
                        <small id="username-help">Введіть повну інформацію про збір.</small>
                        <span class="help is-danger" v-text="errors.get('info')"></span>
                    </div>

                    <div class="create-fundr">
                        <label class="label-text" for="shortInfo">Коротка інформація</label>
                        <Textarea v-model="shortInfo" rows="8" cols="40" />
                        <small id="username-help">Введіть коротку інформацію про збір.</small>
                        <span class="help is-danger" v-text="errors.get('shortInfo')"></span>
                    </div>

                    <div class="create-fundr">
                        <label class="label-text" for="images">Картинки</label>
                        <FileUpload
                            name="images"
                            @input="send"
                            @remove="remove"
                            :multiple="true"
                            :showUploadButton="false"
                            :show-cancel-button="false"
                            accept="image/png"
                            :maxFileSize="1000000"
                        >
                            <template #empty>
                                <p>Перетягніть файли щоб завантажити.</p>
                            </template>
                        </FileUpload>
                        <span class="help is-danger" v-text="errors.get('images')"></span>
                    </div>
                </div>
                <div class="flex start">
                    <div v-if="images" class="create-fundr">
                        <label class="label-text" for="images">Завантажені картинки</label>
                        <div class="flex center" v-for="image in images">
                            <Image :src="image" width="100"/>
                            <img class="cross-button" src="../../../img/cross.svg" @click="removeUploaded(image)">
                        </div>
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
import Calendar from 'primevue/calendar';
import Button from 'primevue/button';
import Image from 'primevue/image';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import FileUpload from "primevue/fileupload";
import InputMask from "primevue/inputmask";
import {Errors} from "../../Errors";

export default {
    name: "CreateEditFundraising",

    components: {
        UserLayout,
        Button,
        Calendar,
        InputText,
        Textarea,
        InputNumber,
        FileUpload,
        InputMask,
        Image,
    },

    props: {
        user: [Object, null],
        id: null,
    },

    data () {
        return {
            title: '',
            info: '',
            shortInfo: '',
            startDate: '',
            sum: 0,
            link: '',
            images: [],
            errors: new Errors()
        }
    },

    async created() {
        if (this.id) {
            const res = await axios.get('/get-fundraising/' + this.id);

            this.title     = res.data[0].title;
            this.info      = res.data[0].info;
            this.shortInfo = res.data[0]['short_info'];
            this.startDate = res.data[0]['start_date'];
            this.sum       = res.data[0].sum;
            this.link      = res.data[0].link;
            this.images    = res.data[1];
        }
    },

    methods: {
        back() {
            window.location.href = '/my-fundraising';
        },

        create() {
            axios.post('/create-edit-fundraising', {
                'id': this.id ? this.id : null,
                'title': this.title,
                'info': this.info,
                'shortInfo': this.shortInfo,
                'startDate': this.startDate,
                'sum': this.sum,
                'images': this.images,
                'link': this.link
            }).catch(error => this.errors.record(error.response.data.errors))
                .then(e => {
                    if (!e.data.length) {
                        window.location.href = "/my-fundraising"
                    }
                });
        },

        send(event) {
            if (event.target.files[0].size < 1000000) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push(reader.result);
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        },

        remove(event) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.images = this.images.filter(img => img !==reader.result);
            };
            reader.readAsDataURL(event.file);
        },

        removeUploaded(image) {
            this.images = this.images.filter(img => img !== image);
        }
    }
}
</script>
