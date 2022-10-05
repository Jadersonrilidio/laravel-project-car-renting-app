<template>
    <div :class="style" role="alert" v-if="details.status">

        <strong>{{ title }}: </strong>
        <hr>

        <template v-if="details.message">
            <span>{{ details.message }}</span>
            <br>
            <ul v-if="details.errors">
                <li v-for="error, key in details.errors" :key="key">
                    {{ error[0] }}
                </li>
            </ul>
        </template>

        <template v-if="details.object.id">
            <span>{{ 'Register ID: ' + details.object.id }}</span>
            <br>
            <pre v-if="details.object">{{ details.object }}</pre>
        </template>

    </div>
</template>

<script>
    export default {
        props: [
            'details',
            'title',
        ],
        computed: {
            style() {
                return 'alert alert-' + this.details.status;
            },
        }
    }
</script>
