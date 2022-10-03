<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="col, key in cols" :key="key" class="text-upercase">{{ col }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj in data" :key="obj.id">
                <td v-for="value, key in obj" :key="key">
                    <template v-if="cols.includes(key)">
                        <span v-if="key == 'image'">
                            <img :src="'storage/' + value" width="30px">
                        </span>
                        <span v-else>
                            {{ value }}
                        </span>
                    </template>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: [
            'cols',
            'data',
        ],
    }
</script>