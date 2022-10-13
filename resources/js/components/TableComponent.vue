<template>
    <table class="table table-hover text-center">

        <thead>
            <tr>
                <th scope="col" v-for="colData, colName in columns" :key="colName">
                    {{ colData.title }}
                </th>
                <th scope="col" v-for="button, key in buttons" :key="key">
                    {{ button.text }}
                </th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="obj, key in filteredData" :key="key">
                <td v-for="value, attr in obj" :key="attr">
                    
                    <template v-if="columns[attr].type == 'text'">
                        {{ value }}
                    </template>
                    
                    <template v-if="columns[attr].type == 'image'">
                        <img :src="setImageSource(value)" alt="img" width="30px">
                    </template>
                    
                    <template v-if="columns[attr].type == 'datetime'">
                        {{ value | globalFormatDateTime }}
                    </template>

                </td>

                <td v-for="button, key in buttons" :key="key">
                    <button
                        :class="'btn btn-sm btn-outline-'+button.class"
                        :data-bs-toggle="button.dataToggle"
                        :data-bs-target="'#'+button.dataTarget"
                        @click="storeObj(obj)"
                    >
                        {{ button.text }}
                    </button>
                </td>

            </tr>
        </tbody>

    </table>
</template>

<script>
    export default {
        props: [
            'columns',
            'data',
            'buttons',
        ],
        methods: {
            setImageSource(img) {
                return 'storage/' + img;
            },
            storeObj(obj) {
                this.$store.state.transaction.status = '';
                this.$store.state.transaction.message = '';
                this.$store.state.item = obj;
            },
        },
        computed: {
            filteredData() {
                let attributes = Object.keys(this.columns);
                let filteredData = [];

                this.data.map( (item, key) => {
                    let filteredItem = {};
                    
                    attributes.forEach(attr => {
                        filteredItem[attr] = item[attr]
                    });
                    
                    filteredData.push(filteredItem);
                });
                
                return filteredData;
            },
        }
    }
</script>