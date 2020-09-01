<template>
    <form class="col" method="post" @submit.prevent="postDevice">
        <div class="form-group">
            <label for="name">Device Name</label>
            <input v-model="deviceName" type="text" class="form-control" id="name" name="name"
                   placeholder="Enter Device Name" required>
        </div>
        <div class="form-group">
            <label for="id">Device ID</label>
            <input v-model="deviceID" type="text" class="form-control" id="id" name="id"
                   placeholder="Enter Device ID" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input v-model="deviceCategory" type="text" class="form-control" id="category" name="category" placeholder="Category of the device">
        </div>
        <div class="form-group" v-for="param in deviceParams">
            <input type="text" v-model="param.Key" class="form-control d-inline" placeholder="key" aria-label="Param">
            <input type="text" v-model="param.Value" class="form-control d-inline" placeholder="value" aria-label="Param">
            <input type="button" class="btn btn-danger" @click="() => deleteProp(param)" value="×" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="button" class="btn btn-primary" @click="addProp" value="Add Property" />
        <transition name="fade">
            <span class="alert-danger" v-show="response.status !== 201 && response.status !== 200">{{ response.data.message }}</span>
        </transition>
        <transition name="fade">
            <span class="alert-success" v-show="response.status === 201 || response.status === 200">OK</span>
        </transition>
    </form>
</template>

<script>
    export default {
        props:{
            device: {}
        },
        created() {
          if(this.$attrs.device)
              this.postObject = this.$attrs.device
        },
        data(){
            return {
                model: 'device',
                postObject: {},
                response: {status: 0, data: ''},
                deviceName: '',
                deviceID: '',
                deviceCategory: '',
                deviceParams: []
            }
        },
        methods: {
            postDevice: function(){
                this.postObject = {
                    name: this.deviceName,
                    category: this.deviceCategory,
                    device_id: this.deviceID
                };
                let error = '';
                let x = this;
                this.deviceParams.forEach(function (item) {
                    if(!item.Key && item.Value)
                        error = 'Missing key from one of the properties'
                    else
                        x.postObject[item.Key] = item.Value
                })
                if(error)
                    this.response = {data: { message: error}}
                else {
                    this.axios.post('/' + this.model, this.postObject, {
                        headers: {
                            'api-key': this.$auth.user().apiKey
                        }
                    }).then(response => this.success(response)).catch(error => this.fail(error))
                }

            },
            addProp: function () {
                this.deviceParams.push({
                    Key: "",
                    Value: ""
                })
            },
            deleteProp: function (item) {
                this.deviceParams.splice( this.deviceParams.indexOf(item), 1 );
            },
            success: function (response) {
                this.deviceID = ''
                this.deviceName = ''
                this.deviceCategory = ''
                this.deviceParams = []
                this.response.status = 201;
                setTimeout(() => this.response = {status: 0, data: ''}, 2000)
            },
            fail: function (error) {
                this.response = error.response
            }
        }
    }
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
