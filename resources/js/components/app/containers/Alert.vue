<template>
    <div :class="style" role="alert">
        <strong>{{ title }}: </strong>
        <hr>

        <template v-if="details.message">
            <span>{{ details.message }}</span>
            <br>
            <ul v-if="details.errors" style="list-style:none">
                <li v-for="error, key in details.errors" :key="key">
                    {{ error[0] }}
                </li>
            </ul>
        </template>

        <template v-if="details.object.id">
            <span>{{ 'Register ID: ' + details.object.id }}</span>
            <br>
            <ul v-if="details.object" style="list-style:none">
                <li v-for="attr, key in details.object" :key="key">
                    {{ (key != 'id') ? (key+' => '+attr) : null }}
                </li>
            </ul>
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
